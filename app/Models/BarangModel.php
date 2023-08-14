<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'hasil_tangkapan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'tgl_daftar',
        'diupdate',
        'nama',
        'stok',
        'satuan',
        'harga',
        'photo',
        'nelayan',
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

    function getWithTerjual($pemilik = null, $id = null){
        $m = $this->join('nelayan', 'nelayan.id = hasil_tangkapan.nelayan')
            ->join('transaksi', 'transaksi.barang = hasil_tangkapan.id AND transaksi.status IN("siap", "selesai") ', 'left')
            ->select('hasil_tangkapan.*,nelayan.hp, nelayan.alamat, nelayan.detail_alamat, nelayan.nama_lengkap, nelayan.tgl_daftar bergabung, transaksi.barang, transaksi.jumlah');
      
        $db = \Config\Database::connect();
        $wilayah = $db->table('wilayah')->get()->getResult();
        if(!empty($pemilik))
            $m->where('hasiL_tangkapan.nelayan', $pemilik);
        if(!is_null($id) && !is_array($id))
            $m->where('hasil_tangkapan.id', $id);
        elseif(!is_null($id) && is_array($id))
            $m->whereIn('hasil_tangkapan.id', $id);

        $tmp = $m->orderBy('hasiL_tangkapan.diupdate', 'DESC')->findAll();
        $data = [];


        foreach($tmp as $t){
            $t = (object) $t;
            if(isset($data[$t->id])){
                if(!empty($t->barang))
                    $data[$t->id]->terjual += $t->jumlah;
            }else{
                $t->terjual = (!empty($t->barang) ? $t->jumlah : 0);
                unset($t->barang, $t->jumlah);
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
