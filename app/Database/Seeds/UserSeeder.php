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
                'username' => 'development',
                'email'    => 'dev@mail.com',
                'nama_lengkap' => 'User Development',
                'hp' => '08424222321',
                'password' => password_hash('develop', PASSWORD_DEFAULT),
                'alamat' => '52.03.19.0000',
                'detail_alamat' => ''
            ]
        ];
        $faker = new Fabricator(UserModel::class);
        $dataFake = $faker->make(30);
        $data += $dataFake;
        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
