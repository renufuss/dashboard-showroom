<?php

namespace Myth\Auth\Models;

use CodeIgniter\Model;
use Faker\Generator;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

/**
 * @method User|null first()
 */
class UserModel extends Model
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $returnType     = User::class;
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at' ,'first_name', 'last_name', 'image_profile',
    ];
    protected $useTimestamps   = true;
    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|is_unique[users.username,id,{id}]|alpha_numeric|min_length[5]|max_length[30]',
        'password_hash' => 'required|min_length[8]',
        'first_name' => 'required|min_length[3]|alpha_space',
        'last_name' => 'required|min_length[3]|alpha_space',
        'role'=>'required',
        'image_profile' => 'max_size[image_profile,1024]|is_image[image_profile]|mime_in[image_profile,image/jpg,image/jpeg,image/png]',
    ];
    protected $validationMessages = [
        'email' => [
            'required' => 'Email tidak boleh kosong',
            'valid_email' => 'Email tidak valid',
            'is_unique' => 'Email sudah terdaftar',
        ],
        'username' => [
            'required' => 'Username tidak boleh kosong',
            'is_unique' => 'Username sudah terdaftar',
            'alpha_numeric' => 'Username tidak valid',
            'min_length' => 'Username minimal berjumlah 5 karakter',
            'max_length' => 'Username tidak boleh lebih dari 30 karakter',
        ],
        'password_hash' => [
            'required' => 'Password tidak valid',
            'min_length' => 'Password minimal berjumlah 8 karakter',
        ],
        'first_name' => [
            'required' => 'Nama depan tidak boleh kosong',
            'min_length' => 'Nama depan minimal berjumlah 3 karakter',
            'alpha_space' => 'Nama depan tidak valid',
        ],
        'last_name' => [
            'required' => 'Nama belakang tidak boleh kosong',
            'min_length' => 'Nama belakang minimal berjumlah 3 karakter',
            'alpha_space' => 'Nama belakang tidak valid',
        ],
        'role' => [
            'required' => 'Role tidak boleh kosong',
        ],
        'image_profile' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 1 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
        ],
    ];
    protected $skipValidation     = true;
    protected $afterInsert        = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     *
     * @var int|null
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     */
    public function logResetAttempt(string $email, ?string $token = null, ?string $ipAddress = null, ?string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email'      => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     */
    public function logActivationAttempt(?string $token = null, ?string $ipAddress = null, ?string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Sets the group to assign any users created.
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup)) {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): User
    {
        return new User([
            'email'    => $faker->email,
            'username' => $faker->userName,
            'password' => bin2hex(random_bytes(16)),
        ]);
    }

    public function showUser($username = null)
    {
        $table = $this->db->table($this->table);
        $query = $table->select('users.*, auth_groups.name as role, badge')->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left')->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left')->orderBy('auth_groups.id', 'asc')->orderBy('username', 'asc')->where('deleted_at', null);
        if ($username != null) {
            $data = $query->where('username', $username)->get()->getFirstRow();
        } else {
            $data = $query->get()->getResultObject();
        }
        return $data;
    }
}
