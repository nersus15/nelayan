<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilTangkapan extends Migration
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
                'null' => true,
                'default' => 'dummy.jpg'
            ],
            'nelayan' => [
                'type' => 'INT',
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('nelayan', 'nelayan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hasil_tangkapan');
    }
    public function down()
    {
        $this->forge->dropTable('hasil_tangkapan');
    }
}
