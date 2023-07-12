<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'dibuat',
        'diupdate',
        'nama',
        'stok',
        'satuan',
        'harga',
        'photo',
        'pemilik',
        'deskripsi'
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

    function getWithTerjual($pemilik = null){
        $m = $this->join('users', 'users.username = barang.pemilik')
            ->join('transaksi', 'transaksi.barang = barang.id AND transaksi.status IN("siap", "selesai") AND transaksi.dibuat LIKE "' . waktu(null, MYSQL_DATE_FORMAT) . '%"', 'left')->select('barang.*,users.alamat, users.detail_alamat, users.nama_lengkap, transaksi.barang');
        $db = \Config\Database::connect();
        $wilayah = $db->table('wilayah')->get()->getResult();
        if(!empty($pemilik))
            $m->where('barang.pemilik', $pemilik);

        $tmp = $m->orderBy('barang.diupdate', 'DESC')->findAll();
        $data = [];


        foreach($tmp as $t){
            $t = (object) $t;
            if(isset($data[$t->id])){
                if(!empty($t->barang))
                    $data[$t->id]->terjual += 1;
            }else{
                $t->terjual = (!empty($t->barang) ? 1 : 0);
                unset($t->barang);
                $data[$t->id] = $t;
            }
        }
        $tmpWil = $wilayah;
        $wilayah = [];
        foreach($tmpWil as $w){
            $wilayah[$w->id] = [
                'nama' => $w->nama,
                'level' => $w->level
            ];
        }
        foreach($data as $k => $d){
            $d = (array)$d;
            $levelWil = level_wilayah($d['alamat']);
            if($levelWil == 3){
                $data[$k]->kecamatan = $wilayah[$d['alamat']]['nama'];
                $data[$k]->desa = '';
                $data[$k]->detail_alamat = $d['detail_alamat'];
            }elseif($levelWil == 4){
                $data[$k]->kecamatan = $wilayah[substr($d['alamat'], 0, 8) . '.0000']['nama'];
                $data[$k]->desa = $wilayah[$d['alamat']]['nama'];
                $data[$k]->detail_alamat = $d['detail_alamat'];
            }
        }
        return $data;
    }
}
