<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Password;

class User extends BaseController
{
    protected $UserModel;
    protected $GroupModel;
    protected $DefaultPassword;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->GroupModel = new GroupModel();
        $this->DefaultPassword = 'kebabturkiyem123';
    }

    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'heading' => 'Pengguna',
            'breadcrumb' => 'Pengguna',
            'role' => $this->GroupModel->orderBy('name', 'ASC')->findAll(),
        ];
        return view('User/index', $data);
    }

    public function showTable()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'users' => $this->UserModel->showUser(),
            ];
            $response = [
                'tableUser' => view('User/Tables/tableUser', $data),
            ];
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost();
            $data['password_hash'] = Password::hash($this->DefaultPassword);
            $data['active'] = 1;
            if (!$this->validateData($data, $this->UserModel->getValidationRules(['except' => ['image_profile']]), $this->UserModel->getValidationMessages())) {
                $msg = [
                    'error' => $this->validator->getErrors(),
                    'errormsg'=> 'Gagal menambahkan pengguna',
                ];
            } else {
                $data['username'] = strtolower($this->request->getPost('username'));
                $data['email'] = strtolower($this->request->getPost('email'));
                $data['first_name'] = ucwords(strtolower($this->request->getPost('first_name')));
                $data['last_name'] = ucwords(strtolower($this->request->getPost('last_name')));
                $this->UserModel->withGroup($data['role'])->save($data);
                $msg = [
                    'sukses' => 'Berhasil menambahkan pengguna'
                ];
            }
            return json_encode($msg);
        }
    }

    public function confirmDelete()
    {
        if ($this->request->isAJAX()) {
            $userId = $this->request->getPost('userId');
            $user = $this->UserModel->find($userId);

            if ($user == null) {
                $response['error'] = 'Data tidak ditemukan';
                return json_encode($response);
            }

            return json_encode($user);
        }
    }

    public function deleteUser()
    {
        if ($this->request->isAJAX()) {
            $userId = $this->request->getPost('userId');
            $user = $this->UserModel->find($userId);

            if ($user == null) {
                $response['error'] = 'Data tidak ditemukan';
                return json_encode($response);
            }

            $response['success'] = 'Berhasil menghapus barang';
            $this->UserModel->delete($userId);

            return json_encode($response);
        }
    }

    public function myProfile()
    {
        $user = $this->UserModel->showUser(user()->username);
        $data = [
            'title' => 'Akun Saya',
            'heading' => 'Akun Saya',
            'breadcrumb' => 'Akun Saya',
            'navDetail' => true,
            'navPengaturan' => false,
            'user' => $user,
        ];

        return view('MyProfile/index', $data);
    }

    public function setMyProfile()
    {
        $user = $this->UserModel->showUser(user()->username);
        if ($user == null) {
            return redirect()->to('/profil');
        }
        $data = [
            'title' => 'Pengaturan Akun',
            'heading' => 'Pengaturan Akun',
            'breadcrumb' => 'Pengaturan Akun',
            'navDetail' => false,
            'navPengaturan' => true,
            'user' => $user,
            'role' => $this->GroupModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('MyProfile/Setting/index', $data);
    }

    public function totalUser()
    {
        return $this->UserModel->countAllResults();
    }
}
