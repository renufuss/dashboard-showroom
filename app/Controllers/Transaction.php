<?php

/**
 * GeneralSpend Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Spend
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

namespace App\Controllers;

use App\Models\DataTable\TransactionModel as DataTableTransactionModel;
use App\Models\TransactionModel;
use Config\Services;

/**
 * GeneralSpend Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Spend
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

class Transaction extends BaseController
{
    protected $TransactionModel;

    /**
     * Construct.
     *
     * @return void
     */
    public function __construct()
    {
        $this->TransactionModel = new TransactionModel();
    }

    /**
     * Open default page for https://base_url/pengeluaran.
     *
     * @return view
     */
    public function index()
    {
        // dd($this->TransactionModel->selectTest());
        $data['title'] = 'Transaksi';
        return view('Transaction/index', $data);
    }

    /**
     * Get Transaction History.
     *
     * @return Table
     */
    public function getTransaction()
    {
        ini_set('memory_limit', '-1');
        $request = Services::request();
        $transactionModel = new DataTableTransactionModel($request);
        if ($request->getMethod(true) == 'POST') {
            $transactions = $transactionModel->get_datatables();
            $data = [];
            foreach ($transactions as $transaction) {
                // Amount of money
                $transactionAmountOfMoney = 'Rp ' . number_format($transaction->transactionAmountOfMoney, '0', ',', '.');
                $carPrice = 'Rp ' . number_format($transaction->carPrice, '0', ',', '.');
                $carAdditionalCostAmountOfMoney = 'Rp ' . number_format($transaction->carAdditionalCostAmountOfMoney, '0', ',', '.');
                $paymentSalesAmountOfMoney = 'Rp ' . number_format($transaction->paymentSalesAmountOfMoney, '0', ',', '.');

                if ($transaction->transactionStatus == 0) {
                    $statusBadge = 'success';
                    $statusDescription = 'Masuk';
                } elseif ($transaction->transactionStatus == 1) {
                    $statusBadge = 'danger';
                    $statusDescription = 'Keluar';
                }

                // Row Table
                $row = [];
                if ($transaction->carId == null && $transaction->car_additional_cost_id == null  && $transaction->payment_sales_id == null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->transactionDescription;
                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "<div class=\"text-end\">$transactionAmountOfMoney</div>";
                    $row[] = "<div class=\"text-end\"> <button class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm\" onclick=\"alertCarDelete('2')\">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class=\"svg-icon svg-icon-3\">
                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                            xmlns=\"http://www.w3.org/2000/svg\">
                            <path
                                d=\"M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.5\"
                                d=\"M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.5\"
                                d=\"M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z\"
                                fill=\"currentColor\"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button></div>";
                } elseif ($transaction->carId != null && $transaction->car_additional_cost_id == null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->carLicenseNumber." :: Pembelian";
                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "<div class=\"text-end\">$carPrice</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                } elseif ($transaction->carId != null && $transaction->car_additional_cost_id != null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->carLicenseNumber." :: Biaya tambahan :: ".$transaction->carAdditionalCostDescription;
                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "<div class=\"text-end\">$carAdditionalCostAmountOfMoney</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                } elseif ($transaction->payment_sales_id != null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->salesReceiptNumber." :: ".$transaction->paymentSalesDescription;
                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "<div class=\"text-end\">$paymentSalesAmountOfMoney</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                }

                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $transactionModel->count_all(),
                "recordsFiltered" => $transactionModel->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

     /**
     * Set Transaction.
     *
     * @param $data data for save
     *
     * @return Boolean
     */
    public function setTransaction($data)
    {
        $this->TransactionModel->save($data);
    }
}
