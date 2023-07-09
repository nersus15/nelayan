<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'dibuat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '46',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'null' => false,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'default' => null,
                'null' => true,
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => null,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => false,
            ],
            'detail_alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'null' => true,
                'default' => null
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => 'default.jpg',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('username');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
