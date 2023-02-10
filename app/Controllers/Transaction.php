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
        $transactionStatus = $this->request->getPost('transaction_status');
        if ($request->getMethod(true) == 'POST') {
            $transactions = $transactionModel->get_datatables($transactionStatus);
            $data = [];
            foreach ($transactions as $transaction) {
                // Amount of money
                $transactionAmountOfMoney = 'Rp ' . number_format($transaction->transactionAmountOfMoney, '0', ',', '.');
                $carPrice = 'Rp ' . number_format($transaction->carPrice, '0', ',', '.');
                $carAdditionalCostAmountOfMoney = 'Rp ' . number_format($transaction->carAdditionalCostAmountOfMoney, '0', ',', '.');
                $paymentSalesAmountOfMoney = 'Rp ' . number_format($transaction->paymentSalesAmountOfMoney, '0', ',', '.');

                if ($transaction->transactionStatus == 0) {
                    $statusBadge = 'success';
                    $statusDescription = 'Masuk :: Mobil';
                } elseif ($transaction->transactionStatus == 1) {
                    $statusBadge = 'danger';
                    $statusDescription = 'Keluar :: Mobil';
                } elseif ($transaction->transactionStatus == 2) {
                    $statusBadge = 'primary';
                    $statusDescription = 'Masuk :: Umum';
                } elseif ($transaction->transactionStatus == 3) {
                    $statusBadge = 'warning';
                    $statusDescription = 'Keluar :: Umum';
                }

                // Row Table
                $row = [];
                if ($transaction->carId == null && $transaction->car_additional_cost_id == null  && $transaction->payment_sales_id == null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->transactionDescription;

                    if ($transaction->transaction_receipt != null) {
                        $row[] = "<button class=\"btn btn-icon btn-bg-light btn-active-color-success btn-sm\"
                        onclick=\"downloadImage('$transaction->transaction_receipt', '$transaction->transactionDescription');return false;\">
                        <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil021.svg-->
                        <span class=\"svg-icon svg-icon-muted svg-icon-2hx\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"
                                fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path opacity=\"0.3\"
                                    d=\"M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z\"
                                    fill=\"currentColor\" />
                                <path d=\"M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z\"
                                    fill=\"currentColor\" />
                                <path opacity=\"0.3\" d=\"M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z\"
                                    fill=\"currentColor\" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>";
                    } else {
                        $row[] = "-";
                    }

                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";

                    if ($transaction->transactionPaidBy != null) {
                        $row[] = $transaction->transactionPaidBy;
                    } else {
                        $row[] = '-';
                    }
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

                    if ($transaction->car_receipt != null) {
                        $row[] = "<button class=\"btn btn-icon btn-bg-light btn-active-color-success btn-sm\"
                        onclick=\"downloadImage('$transaction->car_receipt', '$transaction->carLicenseNumber :: Pembelian');return false;\">
                        <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil021.svg-->
                        <span class=\"svg-icon svg-icon-muted svg-icon-2hx\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"
                                fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path opacity=\"0.3\"
                                    d=\"M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z\"
                                    fill=\"currentColor\" />
                                <path d=\"M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z\"
                                    fill=\"currentColor\" />
                                <path opacity=\"0.3\" d=\"M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z\"
                                    fill=\"currentColor\" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>";
                    } else {
                        $row[] = "-";
                    }

                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "-";
                    $row[] = "<div class=\"text-end\">$carPrice</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                } elseif ($transaction->carId != null && $transaction->car_additional_cost_id != null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->carLicenseNumber." :: Biaya tambahan :: ".$transaction->carAdditionalCostDescription;

                    if ($transaction->additional_receipt != null) {
                        $row[] = "<button class=\"btn btn-icon btn-bg-light btn-active-color-success btn-sm\"
                        onclick=\"downloadImage('$transaction->additional_receipt', '$transaction->carLicenseNumber :: Biaya tambahan :: $transaction->carAdditionalCostDescription');return false\">
                        <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil021.svg-->
                        <span class=\"svg-icon svg-icon-muted svg-icon-2hx\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"
                                fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path opacity=\"0.3\"
                                    d=\"M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z\"
                                    fill=\"currentColor\" />
                                <path d=\"M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z\"
                                    fill=\"currentColor\" />
                                <path opacity=\"0.3\" d=\"M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z\"
                                    fill=\"currentColor\" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>";
                    } else {
                        $row[] = "-";
                    }

                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "-";
                    $row[] = "<div class=\"text-end\">$carAdditionalCostAmountOfMoney</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                } elseif ($transaction->payment_sales_id != null) {
                    $row[] = $transaction->transactionDate;
                    $row[] = $transaction->salesReceiptNumber." :: ".$transaction->paymentSalesDescription;

                    if ($transaction->payment_receipt != null) {
                        $row[] = "<button class=\"btn btn-icon btn-bg-light btn-active-color-success btn-sm\"
                        onclick=\"downloadImage('$transaction->payment_receipt', '$transaction->salesReceiptNumber ::  $transaction->paymentSalesDescription');return false;\">
                        <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil021.svg-->
                        <span class=\"svg-icon svg-icon-muted svg-icon-2hx\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"
                                fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path opacity=\"0.3\"
                                    d=\"M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z\"
                                    fill=\"currentColor\" />
                                <path d=\"M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z\"
                                    fill=\"currentColor\" />
                                <path opacity=\"0.3\" d=\"M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z\"
                                    fill=\"currentColor\" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>";
                    } else {
                        $row[] = "-";
                    }
                    $row[] = "<span class=\"badge badge-light-$statusBadge fs-7 fw-bold\">$statusDescription</span>";
                    $row[] = "-";
                    $row[] = "<div class=\"text-end\">$paymentSalesAmountOfMoney</div>";
                    $row[] = "<div class=\"text-end\">-</div>";
                }

                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $transactionModel->count_all($transactionStatus),
                "recordsFiltered" => $transactionModel->count_filtered($transactionStatus),
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

    /**
     * Set Transaction.
     *
     * @return View
     */
    public function openTransactionModal()
    {
        $response = [
            'transactionModal' => view('Transaction/Modal/transactionModal'),
        ];

        return json_encode($response);
    }

    /**
     * Delete images from the application folder.
     *
     * @param string $imageName Image file name.
     *
     * @return void
     */
    protected function removeImage($imageName)
    {
        if (file_exists('assets/images/cars/' . $imageName)) {
            unlink('assets/images/cars/' . $imageName); //Hapus image lama
        }
    }

    /**
     * Convert image to base64.
     *
     * @param object $image Image file object.
     *
     * @return base64Image
     */
    protected function blobImage($image)
    {
        $image->move('assets/images/sales');
        $pathInfo = 'assets/images/sales/' . $image->getName();
        $fileContent = file_get_contents($pathInfo);
        $base64 = rtrim(base64_encode($fileContent));
        $this->removeImage($image->getName());

        return $base64;
    }

    /**
     * Add New General Transaction.
     *
     * @return jsonResponse
     */
    public function saveTransaction()
    {
        if ($this->request->isAJAX()) {
            $input = [
                'description' => $this->request->getPost('description'),
                'amount_of_money' => str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('amount_of_money')),
                'transaction_receipt' => $this->request->getFile('transaction_receipt'),
                'transaction_status' => $this->request->getPost('transaction_status'),
                'paid_by' => $this->request->getPost('paid_by'),
            ];

            // Validation
            $isValid = $this->validateData($input, $this->TransactionModel->getValidationRules(), $this->TransactionModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'errorMsg' => 'Gagal menyimpan transaksi',
                ];
                return json_encode($response);
            }

            // Additional Receipt
            $transactionReceipt = null;
            if ($input['transaction_receipt']->getError() != 4) {
                $transactionReceipt = $this->blobImage($input['transaction_receipt']);
            }

            $data = [
                'description' => ucwords(strtolower($input['description'])),
                'amount_of_money' => $input['amount_of_money'],
                'transaction_receipt' => $transactionReceipt,
                'transaction_status' => $input['transaction_status'],
                'paid_by' => $input['paid_by']
            ];

            $this->TransactionModel->save($data);

            $response['success'] = 'Berhasil menambahkan transaksi';

            return json_encode($response);
        }
    }
}
