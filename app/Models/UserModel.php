<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'username';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'dibua',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'hp',
        'alamat',
        'detail_alamat',
        'photo',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function fake(Generator &$faker){
        return [
            'username' => $faker->userName,
            'email'    => $faker->email,
            'nama_lengkap' => $faker->firstName,
            'hp' => $faker->phoneNumber,
            'password' => password_hash('faker', PASSWORD_DEFAULT),
            'alamat' => '52.03.20.0000',
            'detail_alamat' => '',
        ];
    }
}
