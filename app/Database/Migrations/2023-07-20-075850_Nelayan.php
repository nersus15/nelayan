<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nelayan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'dibuat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nama_lengkap' => [
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
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('nelayan', true);
    }

    public function down()
    {
        $this->forge->dropTable('nelayan');
    }
}
