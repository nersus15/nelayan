<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $dataUser = $userModel->findAll();
        $username = [];
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[$i] = [
                'id' => random(8),
                'nama' => 'Barang ' . $i,
                'deskripsi' => 'Barang data dummy',
                'stok' => random(2, 'int'),
                'satuan' => 'ekor',
                'harga' => random(2, 'int') * 1000,
                'pemilik' => ''
            ];
        }
        foreach ($dataUser as $user) {
            $user = (array) $user;
            $username[] = $user['username'];
        }
        
        $index = 0;
        for ($i = 0; $i < 100; $i++) {
            if ($index == count($username))
                $index = 0;
            
            $data[$i]['pemilik'] = $username[$index];
            $index += 1;
        }
        $this->db->table('barang')->insertBatch($data);
    }
}
