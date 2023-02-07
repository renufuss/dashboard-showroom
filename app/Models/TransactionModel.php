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

    protected $allowedFields = ['transaction_date', 'description', 'status', 'amount_of_money', 'car_id', 'car_additional_cost_id','payment_sales_id', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'transaction_date';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

    public function selectTest()
    {
        $selectTransaction = "transaction.id as transactionId, transaction.transaction_date as transactionDate, transaction.description as transactionDescription, transaction.amount_of_money as transactionAmountOfMoney, transaction.status as transactionStatus, transaction.car_id as carId, transaction.payment_sales_id as payment_sales_id, transaction.car_additional_cost_id as car_additional_cost_id,";
        $selectCarAdditionalCost = "car_additional_cost.description as carAdditionalCostDescription, car_additional_cost.amount_of_money as carAdditionalCostAmountOfMoney, car_additional_cost.additional_receipt as carAdditionalCostAdditionalReceipt, car_additional_cost.additional_date as carAdditionalCostAdditionalDate, car_additional_cost.id as carAdditionalCostId,";
        $selectCar = "car.license_number as carLicenseNumber, car.created_at as carDate, car.car_price as carPrice,";
        $selectPaymentSales = "payment_sales.amount_of_money as paymentSalesAmountOfMoney, payment_sales.description as paymentSalesDescription, payment_sales.payment_date as paymentSalesPaymentDate,";
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
