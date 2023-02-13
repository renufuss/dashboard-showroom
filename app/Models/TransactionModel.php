<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transaction';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['transaction_date', 'description', 'transaction_status', 'transaction_receipt', 'amount_of_money', 'paid_by', 'car_id', 'car_additional_cost_id','payment_sales_id', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'transaction_date';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'description' => 'required|alpha_numeric_space',
        'amount_of_money' => 'required|numeric',
        'transaction_receipt' => 'max_size[transaction_receipt,5120]|is_image[transaction_receipt]|mime_in[transaction_receipt,image/jpg,image/jpeg,image/png]',
        'transaction_status' => 'required|in_list[2,3,4]',
        'paid_by' => 'required|in_list[Sam un,Hereansyah]',
    ];
    protected $validationMessages = [
        'description' => [
            'required' => 'Nama pengeluaran tidak boleh kosong.',
            'alpha_numeric_space' => 'Nama pengeluaran hanya boleh angka atau huruf',
        ],
        'amount_of_money' => [
            'required' => 'Jumlah pengeluaran tidak boleh kosong',
            'numeric' => 'Jumlah pengeluaran hanya boleh angka',
        ],
        'transaction_receipt' => [
            'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => 'Yang anda pilih bukan gambar',
        ],
        'transaction_status' => [
            'required' => 'Status tidak boleh kosong.',
            'in_list' => 'Status yang anda pilih, tidak ada didalam list',
        ],
        'paid_by' => [
            'required' => 'Jika uang keluar, pembayaran tidak boleh kosong.',
            'in_list' => 'Pembayaran yang anda pilih, tidak ada didalam list',
        ],
    ];
    protected $skipValidation     = true;

    public function selectTest()
    {
        $selectTransaction = "transaction.id as transactionId, transaction.transaction_date as transactionDate, transaction.description as transactionDescription, transaction.amount_of_money as transactionAmountOfMoney, transaction.transaction_status as transactionStatus, transaction.car_id as carId, transaction.payment_sales_id as payment_sales_id, transaction.car_additional_cost_id as car_additional_cost_id, transaction.transaction_receipt as transaction_receipt, transaction.paid_by as transactionPaidBy,";
        $selectCarAdditionalCost = "car_additional_cost.description as carAdditionalCostDescription, car_additional_cost.amount_of_money as carAdditionalCostAmountOfMoney, car_additional_cost.additional_receipt as carAdditionalCostAdditionalReceipt, car_additional_cost.additional_date as carAdditionalCostAdditionalDate, car_additional_cost.id as carAdditionalCostId, car_additional_cost.additional_receipt as additional_receipt,";
        $selectCar = "car.license_number as carLicenseNumber, car.created_at as carDate, car.car_price as carPrice, car.receipt as car_receipt, car.capital_price as carCapitalPrice";
        $selectPaymentSales = "payment_sales.amount_of_money as paymentSalesAmountOfMoney, payment_sales.description as paymentSalesDescription, payment_sales.payment_date as paymentSalesPaymentDate, payment_sales.payment_receipt as payment_receipt,";
        $selectSales = "sales.receipt_number as salesReceiptNumber";
        $select = $selectTransaction.$selectCarAdditionalCost.$selectCar.$selectPaymentSales.$selectSales;
        $table = $this->db->table($this->table);
        $query = $table->select($select)
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction.deleted_at', null);

        $data = $query->get()->getResultObject();

        return $data;
    }
}
