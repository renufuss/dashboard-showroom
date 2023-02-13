<?php

namespace App\Models\DataTable;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = "transaction";
    protected $column_order = array('transaction_date');
    protected $column_search = array('transaction_date','transaction.description','car.license_number','sales.receipt_number','payment_sales.description','car_additional_cost.description');
    protected $order = array('transaction_date' => 'desc');
    protected $request;
    protected $db;
    protected $dt;
    protected $select;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $selectTransaction = "transaction.id as transactionId, transaction.transaction_date as transactionDate, transaction.description as transactionDescription, transaction.amount_of_money as transactionAmountOfMoney, transaction.transaction_status as transactionStatus, transaction.car_id as carId, transaction.payment_sales_id as payment_sales_id, transaction.car_additional_cost_id as car_additional_cost_id, transaction.transaction_receipt as transaction_receipt, transaction.paid_by as transactionPaidBy,";
        $selectCarAdditionalCost = "car_additional_cost.description as carAdditionalCostDescription, car_additional_cost.amount_of_money as carAdditionalCostAmountOfMoney, car_additional_cost.additional_receipt as carAdditionalCostAdditionalReceipt, car_additional_cost.additional_date as carAdditionalCostAdditionalDate, car_additional_cost.id as carAdditionalCostId, car_additional_cost.additional_receipt as additional_receipt,";
        $selectCar = "car.license_number as carLicenseNumber, car.created_at as carDate, car.car_price as carPrice, car.receipt as car_receipt, car.capital_price as carCapitalPrice";
        $selectPaymentSales = "payment_sales.amount_of_money as paymentSalesAmountOfMoney, payment_sales.description as paymentSalesDescription, payment_sales.payment_date as paymentSalesPaymentDate, payment_sales.payment_receipt as payment_receipt,";
        $selectSales = "sales.receipt_number as salesReceiptNumber";
        $this->select = $selectTransaction.$selectCarAdditionalCost.$selectCar.$selectPaymentSales.$selectSales;
    }
    private function _get_datatables_query($status = null)
    {
        $this->dt = $this->db->table($this->table)->select($this->select)
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null);

        if ($status != null) {
            $this->dt->where('transaction.transaction_status', $status);
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    public function get_datatables($status = null)
    {
        $this->_get_datatables_query($status);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }
    public function count_filtered($status = null)
    {
        $this->_get_datatables_query($status);
        return $this->dt->countAllResults();
    }
    public function count_all($status = null)
    {
        $tbl_storage = $this->db->table($this->table)->select($this->select)
        ->join('car', 'transaction.car_id=car.id', 'left')
        ->join('car_additional_cost', 'transaction.car_additional_cost_id=car_additional_cost.id', 'left')
        ->join('payment_sales', 'transaction.payment_sales_id=payment_sales.id', 'left')
        ->join('sales', 'payment_sales.sales_id=sales.id', 'left')
        ->where('transaction.deleted_at', null)
        ->where('car.deleted_at', null)
        ->where('car_additional_cost.deleted_at', null);

        if ($status != null) {
            $this->dt->where('transaction.transaction_status', $status);
        }

        return $tbl_storage->countAllResults();
    }
}
