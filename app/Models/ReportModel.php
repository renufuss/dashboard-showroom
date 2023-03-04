<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table      = 'report';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['report_receipt', 'report_date', 'percent_hereansyah', 'percent_samun'];

    public function lastReport($date)
    {
        $transaction = $this->db->table($this->table);
        $query = $transaction->select('max(report_receipt) as report_receipt')->like('report_date', $date);
        $lastTransaction = $query->get()->getFirstRow()->report_receipt;

        return $lastTransaction;
    }

    public function saveClaimedTransaction($data)
    {
        $table = $this->db->table('claimed_transaction');
        $table->insertBatch($data);

        return true;
    }

    public function getClaimedTransactionId($reportId)
    {
        $id = [];
        $table = $this->db->table('claimed_transaction');
        $query = $table->select('transaction_id')->where('report_id', $reportId);

        $transactions = $query->get()->getResultObject();
        foreach ($transactions as $transaction) {
            array_push($id, $transaction->transaction_id);
        }

        if (count($id) == 0) {
            $id = null;
        }

        return $id;
    }

    public function getProfit($carStatus, $transactionStatus, $carId = [], $transactionId = [], $name = null)
    {
        $selectTransaction = "transaction.id as transactionId, transaction.transaction_date as transactionDate, transaction.description as transactionDescription, transaction.amount_of_money as transactionAmountOfMoney, transaction.transaction_status as transactionStatus, transaction.car_id as carId, transaction.payment_sales_id as payment_sales_id, transaction.car_additional_cost_id as car_additional_cost_id, transaction.transaction_receipt as transaction_receipt, transaction.paid_by as transactionPaidBy,";
        $selectCarAdditionalCost = "car_additional_cost.description as carAdditionalCostDescription, car_additional_cost.amount_of_money as carAdditionalCostAmountOfMoney, car_additional_cost.additional_receipt as carAdditionalCostAdditionalReceipt, car_additional_cost.additional_date as carAdditionalCostAdditionalDate, car_additional_cost.id as carAdditionalCostId, car_additional_cost.additional_receipt as additional_receipt,";
        $selectCar = "tc.license_number as carLicenseNumber, tc.created_at as carDate, tc.car_price as carPrice, tc.receipt as car_receipt, tc.capital_price as carCapitalPrice,";
        $selectPaymentSales = "payment_sales.amount_of_money as paymentSalesAmountOfMoney, payment_sales.description as paymentSalesDescription, payment_sales.payment_date as paymentSalesPaymentDate, payment_sales.payment_receipt as payment_receipt,";
        $selectSales = "sales.receipt_number as salesReceiptNumber, cs.id as salesCarId, cs.license_number as salesLicenseNumber";
        $select = $selectTransaction.$selectCarAdditionalCost.$selectCar.$selectPaymentSales.$selectSales;
        $table = $this->db->table('transaction');
        $query = $table->select($select)
        ->join('car as tc', 'transaction.car_id=tc.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->join('car_sales', 'sales.id=car_sales.sales_id', 'left')
        ->join('car as cs', 'car_sales.car_id=cs.id', 'left')
        ->where('transaction.deleted_at', null)
        ->groupStart()
        ->where('tc.status', $carStatus)
        ->orWhere('cs.status', $carStatus)
        ->groupEnd()
        ->groupStart()
        ->WhereIn('tc.id', $carId)
        ->orWhereIn('cs.id', $carId)
        ->groupEnd()
        ->where('transaction.transaction_status', $transactionStatus)
        ->where('transaction.claim_date !=', null);
        if ($transactionId != null) {
            $query->whereIn('transaction.id', $transactionId);
        } else {
            return null;
        }

        if ($name != null) {
            if ($name == 'Hereansyah') {
                $query->groupStart();
                $query->orWhere('car_additional_cost.paid_by !=', 'Sam un');
                $query->orWhere('car_additional_cost.paid_by', null);
                $query->groupEnd();
            } elseif ($name != 'Hereansyah') {
                $query->groupStart();
                $query->where('transaction.paid_by', $name);
                $query->orWhere('car_additional_cost.paid_by', $name);
                $query->groupEnd();
            }
        }

        $data = $query->get()->getResultObject();

        return $data;
    }

        /**
     * getGeneralCost.
     *
     * @param int    $status, 2 = general income | 3 = general outcome | 4 = general refund
     * @param string $month Month in transaction date (optional)
     * @param boolean $withClaimed if true, will show all data
     *
     * @return int $generalCost
     */
    public function getGeneralCost($status, $transactionId = [], $name = null, $month = null)
    {
        $table = $this->db->table('transaction');
        $query = $table->select('transaction.id as transactionId, transaction_date, transaction.description as description, transaction_receipt, transaction.amount_of_money as amount_of_money')
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

        if ($transactionId != null) {
            $query->whereIn('transaction.id', $transactionId);
        } else {
            return null;
        }

        if ($name != null) {
            $query->where('transaction.paid_by', $name);
        }

        return $query->get()->getResultObject();
    }
}
