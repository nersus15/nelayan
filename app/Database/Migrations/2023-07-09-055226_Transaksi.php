<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
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
            'barang' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'jumlah' => [
                'type' => 'INT'
            ],
            'pembeli' => [
                'type' => 'VARCHAR',
                'constraint' => '46'
            ],
            'ongkir' => [
                'type' => 'INT',
                'default' => 0
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['ambil_sendiri', 'cod'],
                'default' => 'ambil_sendiri'
            ],
            'alamat_pembeli' => [
                'type' => 'VARCHAR',
                'constraint' => '16'
            ],
            'detail_alamat_pembeli' => [
                'type' => 'VARCHAR',
                'constraint' => '92',
                'null' => true
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['proses', 'siap', 'selesai', 'batal'],
                'default' => 'proses'
            ],
            'pembatal' => [
                'type' => 'ENUM',
                'constraint' => ['', 'penjual', 'pembeli'],
                'null' => true
            ],
            'alasan_batal' => [
                'type' => 'VARCHAR',
                'constraint' => 46,
                'null' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('barang', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
