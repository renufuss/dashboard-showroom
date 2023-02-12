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
        $this->DefaultPassword = 'renufus123';
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
                'userTable' => view('User/Tables/userTable', $data),
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
                $data['username'] = strtolower($this->request->getVar('username'));
                $data['email'] = strtolower($this->request->getVar('email'));
                $data['first_name'] = ucwords(strtolower($this->request->getVar('first_name')));
                $data['last_name'] = ucwords(strtolower($this->request->getVar('last_name')));
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

    public function totalUser()
    {
        return $this->UserModel->countAllResults();
    }

        /**
     * Delete images from the application folder.
     *
     * @param string $imageName Image file name.
     *
     * @return void
     */
    protected function removeImage($imageName)
    {
        if (file_exists('assets/images/users/' . $imageName)) {
            unlink('assets/images/users/' . $imageName); //Hapus image lama
        }
    }

    /**
     * Convert image to base64.
     *
     * @param object $image Image file object.
     *
     * @return base64Image
     */
    protected function blobImage($image)
    {
        $image->move('assets/images/users');
        $pathInfo = 'assets/images/users/' . $image->getName();
        $fileContent = file_get_contents($pathInfo);
        $base64 = rtrim(base64_encode($fileContent));
        $this->removeImage($image->getName()); //Delete images from the application

        return $base64;
    }

    public function pageDetailProfile($username = null)
    {
        if ($username == null) {
            $username = user()->username;
            $view = 'User/MyProfile/index';
        } else {
            $view = 'User/Detail/index';
        }

        $user = $this->UserModel->showUser($username);
        if ($user == null) {
            return redirect()->to('/pengguna');
        }

        $data = [
            'title' => 'Profil User',
            'navDetail' => true,
            'navPengaturan' => false,
            'user' => $user,
        ];

        return view($view, $data);
    }

    public function pageSettingProfile($username = null)
    {
        if ($username == null) {
            $username = user()->username;
            $view = 'User/MyProfile/Setting/index';
        } else {
            $view = 'User/Detail/Setting/index';
        }

        $user = $this->UserModel->showUser($username);
        if ($user == null) {
            return redirect()->to('/pengguna');
        }

        $data = [
            'title' => 'Profil User',
            'navDetail' => false,
            'navPengaturan' => true,
            'role' => $this->GroupModel->orderBy('name', 'ASC')->findAll(),
            'user' => $user,
        ];

        return view($view, $data);
    }

    public function updateProfile($username = null)
    {
        if ($this->request->isAJAX()) {
            $role = $this->request->getPost('role');
            if ($username == null) {
                $username = user()->username;
                $role = user()->getRole()['name'];
            }

            $user = $this->UserModel->showUser($username);
            if ($user == null) {
                return redirect()->to('/pengguna');
            }

            $input = [
                'id' => $user->id,
                'first_name' => ucwords(strtolower($this->request->getVar('first_name'))),
                'last_name' => ucwords(strtolower($this->request->getVar('last_name'))),
                'image_profile' => $this->request->getFile('image_profile'),
                'role' => $role,
                'avatar_remove' => $this->request->getPost('avatar_remove'),
            ];



            // Validation
            $isValid = $this->validateData($input, $this->UserModel->getValidationRules(['only' => ['first_name','last_name', 'image_profile', 'role']]), $this->UserModel->getValidationMessages());

            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'errorMsg' => 'Gagal menyimpan profil pengguna',
                ];
                return json_encode($response);
            }

            // Image Profile
            if ($input['image_profile']->getError() != 4) {
                $input['image_profile'] = $this->blobImage($input['image_profile']);
            } elseif ($input['avatar_remove'] == 1) {
                $input['image_profile'] = null;
            } else {
                unset($input['image_profile']);
            }
            unset($input['avatar_remove']);

            $this->UserModel->save($input);

            // Role

            //Clear All Role
            $this->GroupModel->removeUserFromAllGroups($user->id);

            //Selected Role Id
            $roleId = $this->GroupModel->where('name', $input['role'])->first()->id;

            // Assign Role
            $this->GroupModel->addUserToGroup($user->id, $roleId);

            $response['success'] = 'Berhasil menyimpan profil pengguna';

            return json_encode($response);
        }
    }

    public function changePassword($username = null)
    {
        if ($this->request->isAJAX()) {
            if ($username == null) {
                $username = user()->username;
            }

            $user = $this->UserModel->showUser($username);
            if ($user == null) {
                return redirect()->to('/pengguna');
            }

            $input = [
                'oldPassword' => $this->request->getVar('oldPassword'),
                'newPassword' => $this->request->getVar('newPassword'),
                'confirmPassword' => $this->request->getVar('confirmPassword'),
            ];

            $validationRules = [
                'oldPassword' => 'required',
                'newPassword' => 'required|min_length[8]',
                'confirmPassword' => 'required|matches[newPassword]',
            ];

            $validationMessages = [
                'oldPassword' => [
                    'required' => 'Password lama tidak boleh kosong',
                ],
                'newPassword' => [
                    'required' => 'Password baru tidak boleh kosong',
                    'min_length' => 'Password baru minimal berjumlah 8 karakter',
                ],
                'confirmPassword' => [
                    'required' => 'Silakan konfirmasi password anda dengan benar',
                    'matches' => 'Silakan konfirmasi password anda dengan benar'
                ],
            ];

            // Validation
            $isValid = $this->validateData($input, $validationRules, $validationMessages);

            $isOldPasswordValid = Password::verify($input['oldPassword'], $user->password_hash) == true;
            if (!$isValid || !$isOldPasswordValid) {
                $error = $this->validator->getErrors();

                if (!$isOldPasswordValid) {
                    $errorOldPassword = ['oldPassword' => 'Password lama anda salah'];
                    $error = array_merge($error, $errorOldPassword);
                }

                $response = [
                    'error' => $error,
                    'errorMsg' => 'Gagal menyimpan password',
                ];

                return json_encode($response);
            }
            $data = [
                'id' => $user->id,
                'password_hash' => Password::hash($input['newPassword']),
            ];
            $this->UserModel->save($data);

            $response['success'] = 'Berhasil menyimpan password';
            return json_encode($response);
        }
    }
}
