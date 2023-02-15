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
        'identity_id' => 'required|numeric|min_length[16]',
        'phone_number' => 'required|numeric|min_length[10]|greater_than_equal_to[0]',
        'address' => 'required',
        'identity_card' => 'max_size[identity_card,5120]|is_image[identity_card]|mime_in[identity_card,image/jpg,image/jpeg,image/png]|uploaded[identity_card]',
        'real_price' => 'required|numeric',
        'discount' => 'required|numeric|greater_than_equal_to[0]',
        'total_price' => 'required|numeric|greater_than_equal_to[0]',
        'sales_date' => 'required',
        'payment_receipt' => 'max_size[payment_receipt,5120]|is_image[payment_receipt]|mime_in[payment_receipt,image/jpg,image/jpeg,image/png]|uploaded[payment_receipt]',
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
            'numeric' => 'NIK hanya boleh angka',
            'min_length' => 'NIK harus 16 karakter',
        ],
        'phone_number' => [
            'required' => 'Nomor HP tidak boleh kosong',
            'numeric' => 'Nomor HP hanya boleh angka',
            'min_length' => 'Nomor HP minimal 10 karakter',
            'greater_than_equal_to' => 'Nomor HP tidak valid',
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
            'greater_than_equal_to' => 'Harga asli tidak valid',
        ],
        'discount' => [
            'required' => 'Diskon tidak boleh kosong',
            'numeric' => 'Diskon hanya boleh angka',
            'greater_than_equal_to' => 'Diskon tidak valid',
        ],
        'total_price' => [
            'required' => 'Total harga tidak boleh kosong',
            'numeric' => 'Total harga hanya boleh angka',
            'greater_than_equal_to' => 'Total harga tidak valid',
        ],
        'sales_date' => [
            'required' => 'Tanggal pembayaran tidak boleh kosong',
        ],
        'payment_receipt' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Bukti pembayaran harus diupload',
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

        $cars = $query->get()->getResultObject();
        return $cars;
    }

    public function getPayment($receiptNumber, $paymentId = null)
    {
        $table = $this->db->table('payment_sales');
        $query = $table->select('*,payment_sales.id as paymentId')->join('sales', 'payment_sales.sales_id=sales.id', 'inner')->where('receipt_number', $receiptNumber)->orderBy('payment_date', 'asc');

        if ($paymentId != null) {
            $query->where('payment_sales.id', $paymentId);
            return $query->get()->getFirstRow();
        }

        $payments = $query->get()->getResultObject();
        return $payments;
    }

    public function getPaid($receiptNumber)
    {
        $table = $this->db->table('payment_sales');
        $query = $table->select('sum(amount_of_money) as amountOfMoney')->join('sales', 'payment_sales.sales_id=sales.id', 'inner')->where('receipt_number', $receiptNumber)->orderBy('payment_date', 'asc');

        $paid = $query->get()->getFirstRow()->amountOfMoney;
        return $paid;
    }

    public function savePayment($data)
    {
        $table = $this->db->table('payment_sales');
        $table->insert($data);

        return $this->db->insertID();
    }
}
