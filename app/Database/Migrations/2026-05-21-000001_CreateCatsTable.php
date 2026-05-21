<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'breed' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'age' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'user_type' => [
                'type' => 'ENUM',
                'constraint' => ['private', 'shelter', 'organization'],
                'default' => 'private',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('cats');
    }

    public function down()
    {
        $this->forge->dropTable('cats');
    }
}
