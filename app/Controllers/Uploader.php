<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;

class Uploader extends BaseController
{
    public function index()
    {
        //
    }
    function gambar()
    {
        $this->response->settype = 'json';
        $files = $_FILES;
        if (!isset($files['photo'])) {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Tidak ada gambar yang dikirm']);
        }
        $files = $files['photo'];
        $nama = random(8) . '.' . getExt($files['name'], true);
        $key = $_SERVER['HTTP_JENIS_GAMBAR'] ?? 'general';
        if(isset($_SERVER['HTTP_FORCE_NAME'])){
            $nama = $_SERVER['HTTP_FORCE_NAME'] . '.' . getExt($files['name'], true);
        }
        $config = config('Paths')?->upload ?? [];
        $path = null;
        if(count($config) > 0){
            $path = get_path( ASSETS_PATH . $config['gambar'][$key]) ?? null;
        }
        $img = $this->request->getFile('photo');
        if (!$img->hasMoved()) {
            $filepath = $img->store($path, $nama);
            new File($filepath);
        }
        return $this->response->setJSON(['message' => 'Berhasil upload gambar', 'new' => $nama]);
    }
}
