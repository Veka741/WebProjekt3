<?php

namespace App\Models;

use CodeIgniter\Model;

class Cat extends Model
{
    protected $table            = 'cats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'age', 'gender', 'description', 'long_description',
        'status', 'user_id', 'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;

    /**
     * Vrátí seznam koček i s navázanou fotkou a plemeny (přes JOINy).
     *
     * Co dělá:
     *   Sestaví jeden dotaz, který ke každé kočce připojí (LEFT JOIN) první
     *   fotku z tabulky `photos` a všechna plemena z `cat_breeds`/`breeds`
     *   (spojená do jednoho řetězce funkcí GROUP_CONCAT). Smazané (soft-deleted)
     *   kočky jsou vynechány. Tato metoda centralizuje dotaz, který se dříve
     *   opakoval ve více controllerech.
     *
     * @param string|null $status Filtr na sloupec status (např. 'available',
     *                            'adopted'); null = bez filtru.
     *
     * @return array<int,array<string,mixed>> Pole koček; každá obsahuje navíc
     *                                        klíče 'photo' a 'breed'.
     */
    public function getCatsWithDetails(?string $status = null, ?int $limit = null): array
    {
        $builder = $this->applyDetailsQuery($status);

        return $limit !== null ? $builder->findAll($limit) : $builder->findAll();
    }

    /**
     * Stejný výpis koček jako getCatsWithDetails(), ale se stránkováním.
     *
     * Co dělá:
     *   Vrátí jen jednu stránku koček (kvůli rychlosti – při stovkách inzerátů
     *   by se jinak vykreslovalo všechno najednou). Objekt stránkovače je pak
     *   dostupný přes $model->pager.
     *
     * @param int         $perPage Počet koček na jednu stránku.
     * @param string|null $status  Filtr na stav (např. 'available'); null = bez filtru.
     *
     * @return array<int,array<string,mixed>> Pole koček pro aktuální stránku.
     */
    public function paginateCatsWithDetails(int $perPage, ?string $status = null): array
    {
        return $this->applyDetailsQuery($status)->paginate($perPage);
    }

    /**
     * Sestaví společný dotaz pro výpis koček s fotkou a plemeny (JOINy).
     *
     * @param string|null $status Filtr na stav; null = bez filtru.
     *
     * @return self Model s nastaveným dotazem (pro findAll/paginate).
     */
    private function applyDetailsQuery(?string $status = null): self
    {
        $this->select('cats.*, ANY_VALUE(photos.id) AS photo_id, ANY_VALUE(photos.image_path) AS photo, GROUP_CONCAT(DISTINCT breeds.name SEPARATOR ", ") AS breed')
            ->join('photos', 'photos.cat_id = cats.id AND photos.deleted_at IS NULL', 'left')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->where('cats.deleted_at', null)
            ->groupBy('cats.id')
            ->orderBy('cats.created_at', 'DESC');

        if ($status !== null) {
            $this->where('cats.status', $status);
        }

        return $this;
    }

    /**
     * Spočítá počet koček v jednotlivých stavech pomocí agregační funkce COUNT.
     *
     * Co dělá:
     *   Provede dotaz "SELECT status, COUNT(*) ... GROUP BY status" nad
     *   nesmazanými kočkami a vrátí přehled, kolik koček je v každém stavu.
     *
     * @return array<string,int> Asociativní pole status => počet
     *                           (např. ['available' => 5, 'adopted' => 2]).
     */
    public function countByStatus(): array
    {
        $rows = $this
            ->select('status, COUNT(*) AS total')
            ->where('deleted_at', null)
            ->groupBy('status')
            ->findAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['status']] = (int) $row['total'];
        }

        return $result;
    }

    /**
     * Vrátí ID plemene navázaného na danou kočku (z vazební tabulky cat_breeds).
     *
     * @param int $catId ID kočky.
     *
     * @return int|null ID plemene, nebo null pokud kočka žádné plemeno nemá.
     */
    public function getBreedId(int $catId): ?int
    {
        $row = $this->db->table('cat_breeds')
            ->select('breed_id')
            ->where('cat_id', $catId)
            ->get()
            ->getRowArray();

        return $row ? (int) $row['breed_id'] : null;
    }

    /**
     * Nastaví (nahradí) plemeno kočky ve vazební tabulce cat_breeds.
     *
     * Co dělá:
     *   Smaže případné stávající vazby kočky na plemena a vloží jednu novou
     *   vazbu cat_id → breed_id. Pokud je $breedId prázdné, vazby pouze odstraní.
     *
     * @param int      $catId   ID kočky.
     * @param int|null $breedId ID vybraného plemene (null = bez plemene).
     *
     * @return void
     */
    public function setBreed(int $catId, ?int $breedId): void
    {
        $table = $this->db->table('cat_breeds');
        $table->where('cat_id', $catId)->delete();

        if ($breedId) {
            $table->insert(['cat_id' => $catId, 'breed_id' => $breedId]);
        }
    }

    public function getWithBreeds($id)
    {
        return $this->select('cats.*')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->find($id);
    }

    public function getWithPhotos($id)
    {
        $cat = $this->find($id);
        if ($cat) {
            $photoModel = new Photo();
            $cat['photos'] = $photoModel->where('cat_id', $id)
                ->where('deleted_at', null)
                ->findAll();
        }
        return $cat;
    }
}
