<?php

namespace App\Database\Seeds;

use App\Models\NelayanModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class NelayanSeeder extends Seeder
{
    public function run()
    {
        
        $faker = new Fabricator(NelayanModel::class, null, 'ID_id');
        $dataFake = $faker->make(30);
        
        $this->db->table('nelayan')->insertBatch($dataFake);
    }
}
