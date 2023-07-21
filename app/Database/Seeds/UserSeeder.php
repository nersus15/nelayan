<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'Admin',
                'email'    => 'dev@mail.com',
                'nama_lengkap' => 'User Development',
                'hp' => '08424222321',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'alamat' => '52.03.19.0000',
                'detail_alamat' => ''
            ]
        ];
        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
