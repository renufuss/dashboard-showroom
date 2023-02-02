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
        'full_name' => 'alpha_space',
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
            'required' => 'Plat nomor tidak valid',
            'alpha_numeric_space' => 'Plat nomor hanya boleh huruf dan angka',
            'is_unique' => 'Plat nomor sudah pernah ditambahkan',
        ],
        'identity_id' => [
            'required' => 'Warna mobil tidak boleh kosong',
            'alpha_space' => 'Warna mobil hanya boleh huruf'
        ],
        'phone_number' => [
            'required' => 'Tahun mobil tidak boleh kosong',
            'numeric' => 'Tahun mobil harus menggunakan angka',
        ],
        'address' => [
            'required' => 'Brand mobil tidak boleh kosong',
        ],
        'identity_card' => [
            'required' => 'Harga beli mobil tidak boleh kosong',
            'numeric' => 'Harga beli mobil harus menggunakan angka',
        ],
        'real_price' => [
            'required' => 'Harga jual mobil tidak boleh kosong',
            'numeric' => 'Harga jual mobil harus menggunakan angka',
        ],
        'discount' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Bukti pembelian harus diupload',
        ],
        'total_price' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Foto mobil harus diupload',
        ],
        'sales_date' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
            'uploaded' => 'Foto mobil harus diupload',
        ],
    ];
    protected $skipValidation     = true;
}
