<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table      = 'car';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['car_name', 'license_number', 'car_color', 'car_year', 'brand_id', 'capital_price', 'car_price', 'status', 'receipt', 'car_image', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'car_name' => 'required|alpha_numeric_space',
        'license_number' => 'required|alpha_numeric_space|is_unique[car.license_number,id,{id}]',
        'car_color' => 'required|alpha_space',
        'car_year' => 'required|numeric',
        'car_brand' => 'required',
        'capital_price' => 'required|numeric',
        'car_price' => 'required|numeric',
        'receipt' => 'max_size[receipt,5120]|is_image[receipt]|mime_in[receipt,image/jpg,image/jpeg,image/png]|uploaded[receipt]',
        'car_image' => 'max_size[car_image,5120]|is_image[car_image]|mime_in[car_image,image/jpg,image/jpeg,image/png]|uploaded[car_image]',
    ];
    protected $validationMessages = [
        'car_name' => [
            'required' => 'Nama mobil tidak boleh kosong.',
            'alpha_numeric_space' => 'Nama mobil hanya boleh angka atau huruf',
        ],
        'license_number' => [
            'required' => 'Plat nomor tidak valid',
            'alpha_numeric_space' => 'Plat nomor hanya boleh huruf dan angka',
            'is_unique' => 'Plat nomor sudah pernah ditambahkan',
        ],
        'car_color' => [
            'required' => 'Warna mobil tidak boleh kosong',
            'alpha_space' => 'Warna mobil hanya boleh huruf'
        ],
        'car_year' => [
            'required' => 'Tahun mobil tidak boleh kosong',
            'numeric' => 'Tahun mobil harus menggunakan angka',
        ],
        'car_brand' => [
            'required' => 'Brand mobil tidak boleh kosong',
        ],
        'capital_price' => [
            'required' => 'Harga beli mobil tidak boleh kosong',
            'numeric' => 'Harga beli mobil harus menggunakan angka',
        ],
        'car_price' => [
            'required' => 'Harga jual mobil tidak boleh kosong',
            'numeric' => 'Harga jual mobil harus menggunakan angka',
        ],
        'receipt' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Bukti pembelian harus diupload',
        ],
        'car_image' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Foto mobil harus diupload',
        ],
    ];
    protected $skipValidation     = true;

    public function getBrands()
    {
        $table = $this->db->table('car_brand');
        $query = $table->select('*')->orderBy('brand_name', 'ASC');
        $brand = $query->get()->getResultObject();
        return $brand;
    }

    public function getCar($keywords = null, $start = 0, $length = 0)
    {
        $table = $this->db->table('car');
        $query = $table->select('*')->orderBy('car_name', 'ASC')
            ->where('deleted_at', null);

        if ($keywords != null) {
            $keyword = explode(' ', $keywords);
            for ($i=0; $i < count($keyword); $i++) {
                $query->orLike('car_name', $keyword[$i]);
                $query->orLike('license_number', $keyword[$i]);
                $query->orLike('car_color', $keyword[$i]);
                $query->orLike('car_year', $keyword[$i]);
            }
        }

        if ($start != 0 || $length != 0) {
            $query->limit($length, $start);
        }

        $car = $query->get()->getResult();
        return $car;
    }

    public function checkBrand($brandId)
    {
        $table = $this->db->table('car_brand');
        $query = $table->select('*')->where('id', $brandId);
        $brand = $query->get()->getFirstRow();

        if ($brand != null) {
            return $brand->brand_name;
        }
        return false;
    }

    public function setTempAdditionalCost($data = [])
    {
        $table = $this->db->table('temp_additional_cost');
        $table->insert($data);

        return true;
    }

    public function getTempAdditionalCost($userId, $tempId = null, $tempSession = null)
    {
        $table = $this->db->table('temp_additional_cost');
        $query = $table->select('*')->orderBy('id', 'DESC');
        $query->where('user_id', $userId);
        if ($tempSession !=null) {
            $query->where('temp_session', $tempSession);
        }
        if ($tempId != null) {
            $query->where('id', $tempId);
            return $query->get()->getFirstRow();
        }
        $additionalCost = $query->get()->getResultObject();
        return $additionalCost;

        return true;
    }

    public function getTotalTempAdditionalCost($userId, $tempSession = null)
    {
        $table = $this->db->table('temp_additional_cost');
        $query = $table->select('SUM(amount_of_money) as totalAdditionalCost');
        $query->where('user_id', $userId);
        if ($tempSession !=null) {
            $query->where('temp_session', $tempSession);
        }

        return $query->get()->getFirstRow()->totalAdditionalCost;
    }

    public function deleteTempAdditionalCost($userId, $tempId)
    {
        $table = $this->db->table('temp_additional_cost');
        $table->delete(['id' => $tempId, 'user_id' => $userId]);

        return true;
    }

    public function setAdditionalCost($tempAdditionalCosts  = [], $carId = null, $temp = true)
    {
        if ($temp) {
            $data = [];
            foreach ($tempAdditionalCosts as $tempAdditionalCost) {
                $temp = [
                    'description' => $tempAdditionalCost->description,
                    'amount_of_money' => $tempAdditionalCost->amount_of_money,
                    'additional_receipt' => $tempAdditionalCost->additional_receipt,
                    'paid_by' => $tempAdditionalCost->paid_by,
                    'additional_date' => date('Y-m-d H:i:s'),
                    'car_id' => $carId,
                ];
                array_push($data, $temp);

                $this->deleteTempAdditionalCost($tempAdditionalCost->user_id, $tempAdditionalCost->id);
            }

            $table = $this->db->table('car_additional_cost');
            return $table->insertBatch($data);
        }
        $data = $tempAdditionalCosts;
        $table = $this->db->table('car_additional_cost');

        if ($data['id'] != null) {
            $table->where('id', $data['id']);
            $table->update($data);

            return null;
        }
        $table->insert($data);

        return $this->db->insertID();
    }

    public function getAdditionalCost($carId = null, $additionalId = null)
    {
        $table = $this->db->table('car_additional_cost');
        $query = $table->select('*');
        if ($carId != null) {
            $query->where('car_id', $carId);
        }

        if ($additionalId != null) {
            $query->where('id', $additionalId);
            return $query->get()->getFirstRow();
        }

        return $query->get()->getResultObject();
    }

    public function getTotalAdditionalCost($carId = null)
    {
        $table = $this->db->table('car_additional_cost');
        $query = $table->select('SUM(amount_of_money) as totalAdditionalCost');
        if ($carId != null) {
            $query->where('car_id', $carId);
        }

        $data = $query->get()->getFirstRow()->totalAdditionalCost;
        if ($data != null) {
            return $data;
        }
        return 0;
    }

    public function findCarReady($keyword, $licenseNumber)
    {
        $table = $this->db->table('car');
        $query = $table->select('*')->where('deleted_at', null)->where('status', 0);
        $table->groupStart();
        $query->like('car_name', $keyword);
        if ($licenseNumber != false) {
            $query->orLike('license_number', $licenseNumber);
        }
        $query->groupEnd();

        $data['car'] = $query->get()->getResultObject();
        $data['totalCar'] = 0;

        if ($data['car'] != null) {
            $data['totalCar'] = count($data['car']);
        }

        if ($data['totalCar'] == 1) {
            $data['car'] = $data['car'][0];
        }

        return $data;
    }
}
