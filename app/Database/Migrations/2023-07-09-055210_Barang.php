<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'dibuat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'diupdate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 92,
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'stok' => [
                'type' => 'INT',
            ],
            'satuan' => [
                'type' => 'ENUM',
                'constraint' => ['ekor', 'kilo', 'bak', 'ember'],
                'default' => 'ekor',
                'null' => false
            ],
            'harga' => [
                'type' => 'INT',
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint'=> '15',
                'null' => true
            ],
            'pemilik' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pemilik', 'users', 'username', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
