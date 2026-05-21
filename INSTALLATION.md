# 🐱 Portál adopce koček - Web aplikace

Kompletní webová aplikace pro správu adopce koček vytvořená v CodeIgniter 4.

## 📋 Obsah

- **Domovská stránka** - Informace "O nás" s popisem portálu
- **Galerie** - Přehled všech koček dostupných k adopci
- **Správa** - Přidávání, editace a mazání inzerátů koček

## 🚀 Instalace a spuštění

### Předpoklady
- PHP 8.1+
- MySQL 5.7+
- Composer
- MAMP nebo podobný lokální server

### Kroky instalace

1. **Vytvoření databáze:**
   ```sql
   CREATE DATABASE cat_adoption;
   ```

2. **Spuštění migrace:**
   ```bash
   php spark migrate
   ```
   Tím se vytvoří tabulka `cats` s potřebnou strukturou.

3. **Vytvoření adresáře pro nahrávání fotek:**
   ```bash
   mkdir -p public/uploads
   chmod 755 public/uploads
   ```

4. **Spuštění aplikace:**
   - V MAMP: Nastavte Document Root na adresář projektu
   - Nebo spusťte: `php spark serve`
   - Otevřete: `http://localhost:8080`

## 📱 Stránky aplikace

### 1. Domovská stránka (`/`)
- Uvítací zpráva
- Informace o portálu
- Odkazy na ostatní stránky

### 2. Galerie (`/gallery`)
- Zobrazení všech koček
- Fotky, jméno, plemeno, věk
- Informace o kontaktu (uživatel, typ - soukromá osoba/útulna/organizace)

### 3. Správa (`/manage`)
- Přehled všech vašich inzerátů
- **Přidat kočku** - Formulář pro přidání nové koček
- **Editovat** - Změna informací o kočce
- **Smazat** - Odstranění inzerátu (fotka se také smaže)

## 💾 Struktura databáze

Tabulka `cats`:
```
- id (INT, PK, Auto increment)
- name (VARCHAR) - Jméno koček
- breed (VARCHAR) - Plemeno
- age (DECIMAL) - Věk v letech
- description (LONGTEXT) - Detailní popis
- photo (VARCHAR) - Název fotky
- user_name (VARCHAR) - Jméno/název uživatele
- user_type (ENUM) - private/shelter/organization
- created_at (DATETIME) - Čas vytvoření
- updated_at (DATETIME) - Čas poslední úpravy
```

## 🎨 Styly a design

- Responsivní design (mobilní, tablet, desktop)
- Moderní CSS s gradientem
- Gradienty: purpurová (#667eea) a fialová (#764ba2)

## 📁 Struktura projektu

```
app/
├── Controllers/
│   ├── Home.php          # Domovská stránka
│   ├── Gallery.php       # Galerie koček
│   └── Manage.php        # Správa inzerátů
├── Models/
│   └── CatModel.php      # Model pro práci s databází
└── Views/
    ├── layout.php        # Hlavní layout
    ├── home.php          # Domovská stránka
    ├── gallery.php       # Galerie
    ├── manage.php        # Přehled inzerátů
    ├── manage_add.php    # Formulář pro přidání
    └── manage_edit.php   # Formulář pro editaci

app/Config/
└── Routes.php            # Definice tras

app/Database/Migrations/
└── 2026-05-21-000001_CreateCatsTable.php  # Migrace
```

## 🔄 Trasy aplikace

- `GET /` - Domovská stránka
- `GET /gallery` - Galerie koček
- `GET /manage` - Přehled inzerátů
- `POST /manage/add` - Přidání nové koček
- `GET /manage/edit/:id` - Editace koček
- `POST /manage/update/:id` - Uložení úprav
- `GET /manage/delete/:id` - Smazání koček

## 📝 Příklad přidání koček

1. Jděte na stránku `/manage`
2. Klikněte na "Přidat novou kočku"
3. Vyplňte formulář:
   - Jméno: Míša
   - Plemeno: Britská krátkosrstá
   - Věk: 2.5
   - Popis: Klidná, přátelská, vhodná pro rodiny
   - Fotka: Vyberte soubor
   - Jméno: Vašeho jméno
   - Typ: Soukromá osoba / Útulna / Organizace
4. Klikněte "Přidat kočku"

## ⚙️ Konfigurace

Upravte v `app/Config/Database.php`:
```php
'default' => [
    'DSN' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'database' => 'cat_adoption',
    'DBDriver' => 'MySQLi',
    ...
]
```

## 🐛 Řešení problémů

### Problem: Migrace se nespustí
- Zkontrolujte, zda je databáze vytvořená
- Proveďte: `php spark db:create cat_adoption`

### Problem: Fotky se neukládají
- Zkontrolujte, zda adresář `public/uploads` existuje
- Nastavte správná oprávnění: `chmod 755 public/uploads`

### Problem: CSS se neaplikuje
- Vymažte cache: `php spark cache:clear`
- Aktualizujte stránku (Ctrl+F5)

## 📧 Kontakt a podpora

Pro otázky nebo problémy přidejte Issue do repozitáře.

---

**Vytvořeno:** 21. května 2026  
**Framework:** CodeIgniter 4  
**PHP:** 8.1+
