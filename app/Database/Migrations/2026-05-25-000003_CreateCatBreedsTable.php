<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatBreedsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'breed_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey(['cat_id', 'breed_id'], true);
        $this->forge->addForeignKey('cat_id', 'cats', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('breed_id', 'breeds', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cat_breeds');
    }

    public function down()
    {
        $this->forge->dropTable('cat_breeds');
    }
}
