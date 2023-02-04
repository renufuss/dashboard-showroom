<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table      = 'sales';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['receipt_number', 'full_name', 'identity_id', 'phone_number', 'address', 'identity_card', 'real_price', 'discount', 'total_price', 'sales_date'];

    protected $useTimestamps = true;
    protected $createdField  = null;
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'receipt_number' => 'required',
        'full_name' => 'required|alpha_space',
        'identity_id' => 'required|numeric',
        'phone_number' => 'required|numeric',
        'address' => 'required',
        'identity_card' => 'max_size[identity_card,5120]|is_image[identity_card]|mime_in[identity_card,image/jpg,image/jpeg,image/png]|uploaded[identity_card]',
        'real_price' => 'required|numeric',
        'discount' => 'required|numeric',
        'total_price' => 'required|numeric',
        'sales_date' => 'required',
    ];
    protected $validationMessages = [
        'receipt_number' => [
            'required' => 'Nomor resi tidak boleh kosong.',
        ],
        'full_name' => [
            'required' => 'Nama lengkap tidak boleh kosong',
            'alpha_space' => 'Nama lengkap hanya boleh huruf',
        ],
        'identity_id' => [
            'required' => 'NIK tidak boleh kosong',
            'numeric' => 'NIK hanya boleh angka'
        ],
        'phone_number' => [
            'required' => 'Nomor HP tidak boleh kosong',
            'numeric' => 'Nomor HP hanya boleh angka',
        ],
        'address' => [
            'required' => 'Alamat tidak boleh kosong',
        ],
        'identity_card' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Bukti pembelian harus diupload',
        ],
        'real_price' => [
            'required' => 'Harga asli tidak boleh kosong',
            'numeric' => 'Harga asli hanya boleh angka',
        ],
        'discount' => [
            'required' => 'Diskon tidak boleh kosong',
            'numeric' => 'Diskon hanya boleh angka',
        ],
        'total_price' => [
            'required' => 'Total harga tidak boleh kosong',
            'numeric' => 'Total harga hanya boleh angka',
        ],
        'sales_date' => [
            'required' => 'Tanggal pembayaran tidak boleh kosong',
        ],
    ];
    protected $skipValidation     = true;

    public function lastTransaction($date)
    {
        $transaksi = $this->db->table('sales');
        $query = $transaksi->select('max(receipt_number) as receipt_number')->like('sales_date', $date);
        $lastTransaction = $query->get()->getFirstRow()->receipt_number;

        return $lastTransaction;
    }

    public function saveCar($data)
    {
        $table = $this->db->table('car_sales');
        $table->insertBatch($data);

        return true;
    }

    public function getCar($receiptNumber)
    {
        $table = $this->db->table('car_sales');
        $query = $table->select('*')->join('sales', 'car_sales.sales_id=sales.id', 'inner')->join('car', 'car_sales.car_id=car.id', 'inner')->join('car_brand', 'car.brand_id=car_brand.id')->where('receipt_number', $receiptNumber);

        $car = $query->get()->getResultObject();
        return $car;
    }

    public function savePayment($data)
    {
        $table = $this->db->table('payment_sales');
        $table->insert($data);

        return true;
    }
}
