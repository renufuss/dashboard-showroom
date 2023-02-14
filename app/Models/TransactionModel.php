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
        $selectCar = "car.license_number as carLicenseNumber, car.created_at as carDate, car.car_price as carPrice, car.receipt as car_receipt, car.capital_price as carCapitalPrice,";
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

    public function getTotalIncomeCar($month = null)
    {
        $table = $this->db->table($this->table);
        $query = $table->select('sum(payment_sales.amount_of_money) as paymentSales')
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction_status', 0)
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null)
        ->where('transaction.car_id', null)
        ->where('transaction.car_additional_cost_id', null)
        ->where('transaction.payment_sales_id !=', null);

        if ($month != null) {
            $query->where("DATE_FORMAT(transaction_date,'%Y-%m')", $month);
        }

        $paymentSales = $query->get()->getFirstRow()->paymentSales;

        $refund = $this->getGeneralCost(4, $month);

        return $paymentSales + $refund;
    }

    public function getTotalOutcomeCar($month = null)
    {
        // Capital Price
        $table = $this->db->table($this->table);
        $capitalPrice = $table->select('sum(car.capital_price) as carCapitalPrice')
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction_status', 1)
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null)
        ->where('transaction.car_id !=', null)
        ->where('transaction.car_additional_cost_id', null)
        ->where('transaction.payment_sales_id', null);

        if ($month != null) {
            $capitalPrice->where("DATE_FORMAT(transaction_date,'%Y-%m')", $month);
        }

        $capitalPrice = $capitalPrice->get()->getFirstRow()->carCapitalPrice;

        // additional Cost
        $additionalCost = $table->select('sum(car_additional_cost.amount_of_money) as additionalCost')
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null)
        ->where('transaction.car_id !=', null)
        ->where('transaction.car_additional_cost_id !=', null)
        ->where('transaction.payment_sales_id', null);

        if ($month != null) {
            $additionalCost->where("DATE_FORMAT(transaction_date,'%Y-%m')", $month);
        }

        $additionalCost = $additionalCost->get()->getFirstRow()->additionalCost;

        return $capitalPrice + $additionalCost;
    }

    /**
     * getGeneralCost.
     *
     * @param int    $status, 2 = general income | 3 = general outcome | 4 = general refund
     * @param string $month Month in transaction date (optional)
     *
     * @return int $generalCost
     */
    public function getGeneralCost($status, $month = null)
    {
        $table = $this->db->table($this->table);
        $query = $table->select('sum(transaction.amount_of_money) as totalGeneralCost')
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction_status', $status)
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null)
        ->where('transaction.car_id', null)
        ->where('transaction.car_additional_cost_id', null)
        ->where('transaction.payment_sales_id', null);

        if ($month != null) {
            $query->where("DATE_FORMAT(transaction_date,'%Y-%m')", $month);
        }

        return $query->get()->getFirstRow()->totalGeneralCost;
    }
}
