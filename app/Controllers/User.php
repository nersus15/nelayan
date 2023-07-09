<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    private $userModel;
    function __construct() {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        //
    }

    function login()
    {
        return view('pages/login');
    }
    function register()
    {
        $db = \Config\Database::connect();
        $dataWil = $db->table('wilayah')->get()->getResultArray();
        $desa = [];
        foreach ($dataWil as $key => $value) {
            if ($value['level'] < 4) continue;

            $kode = substr($value['id'], 0, 8);
            if (isset($desa[$kode])) {
                $desa[$kode][] = $value;
            } else {
                $desa[$kode] = [$value];
            }
        }
        $data = [
            'kec' => array_filter($dataWil, function ($arr) {
                return $arr['level'] == 3;
            }),
            'desa' => $desa
        ];

        return view('pages/register', $data);
    }
    function logout()
    {
        $session = session();
        $session->remove('login');
        return redirect('')->with('response', 'Anda baru saja logout');
    }
    function login_post()
    {
        $post = $this->request->getPost();
        if (empty($post['user']))
            return redirect()->to(base_url('login'))->with('response', '"Username atau No. Hp" tidak boleh kosong');
        if (empty($post['password']))
            return redirect()->to(base_url('login'))->with('response', '"Password" tidak boleh kosong')->with('loginData', $post);;

        // Cari User
        $user = $this->userModel->where('username', $post['user'])->orWhere('hp', $post['user'])->find();
        if (empty($user))
            return redirect()->to(base_url('login'))->with('response', 'User tidak ditemukan')->with('loginData', $post);

        $session = session();
        $user = $user[0];
        if (password_verify($post['password'], $user['password'])) {
            $session->set('login', $user);
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('login'))->with('response', 'Password salah')->with('loginData', $post);;
        }
    }
    function register_post(){
        $post = $this->request->getPost();
        if($post['password'] != $post['repass'])
            return redirect()->to(base_url('register'))->with('response', '"password" dan "ulangi password" tidak sama')->with('registerData', $post);
        
        $userByUsername = $this->userModel->where('username', $post['username'])->find();
        if(!empty($userByUsername))
            return redirect()->to(base_url('register'))->with('response', 'Username sudah terdaftar')->with('registerData', $post);

        $userByHp = $this->userModel->where('hp', $post['hp'])->find();
        if(!empty($userByHp))
            return redirect()->to(base_url('register'))->with('response', 'No Hp sudah terdaftar')->with('registerData', $post);

        $userByEmail = $this->userModel->where('email', $post['email'])->find();
        if(!empty($userByEmail))
            return redirect()->to(base_url('register'))->with('response', 'Email sudah terdaftar')->with('registerData', $post);

        $data = [
            'dibuat' => waktu(),
            'username' => $post['username'],
            'nama_lengkap' => $post['nama'],
            'hp' => $post['hp'],
            'email' => $post['email'],
            'alamat' => $post['desa'],
            'detail_alamat' => $post['alamat'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT)
        ];

        $this->userModel->insert($data);
        return redirect()->to(base_url('login'))->with('response', 'Silahkan login dengan akun yang sudah dibuat')->with('loginData', ['user' => $post['username'], 'password' => $post['password']]);
    }
}
