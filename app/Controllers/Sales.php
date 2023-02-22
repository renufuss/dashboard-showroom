<?php

/**
 * Sales Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Sales
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

namespace App\Controllers;

use App\Models\SalesModel;
use App\Models\TempSalesModel;
use App\Models\DataTable\SalesModel as DataTableSalesModel;
use Config\Services;

/**
 * Sales Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Sales
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

class Sales extends BaseController
{
    protected $TempSalesModel;
    protected $SalesModel;
    protected $salesCarLimit;

    /**
     * Construct.
     *
     * @return void
     */
    public function __construct()
    {
        $this->SalesModel = new SalesModel();
        $this->TempSalesModel = new TempSalesModel();
        $this->salesCarLimit = 1;
    }

    /**
     * Open default page for https://base_url/penjualan.
     *
     * @return view
     */
    public function index()
    {
        $data['title'] = 'Penjualan';
        return view('Sales/index', $data);
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
        if (file_exists('assets/images/sales/' . $imageName)) {
            unlink('assets/images/sales/' . $imageName); //Hapus image lama
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
     * Opens a modal pop up to select a car.
     *
     * @return jsonResponse
     */
    public function carModal()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');

            $data = [
                'keyword' => $keyword,
            ];
            $msg = [
                'carModal' => view('Sales/Modal/carModal', $data),
            ];

            echo json_encode($msg);
        }
    }

    /**
     * Opens a modal pop up to save the payment.
     *
     * @return jsonResponse
     */
    public function paymentModal()
    {
        if ($this->request->isAJAX()) {
            $selectedCar = $this->TempSalesModel->where('user_id', user()->id)->findAll();
            $isEmpty = ($selectedCar == null);
            if ($isEmpty) {
                $response['error'] = 'Maaf, anda belum memilih mobil manapun...';
                return json_encode($response);
            }

            $isOverCarLimit = count($selectedCar) > $this->salesCarLimit;
            if ($isOverCarLimit) {
                $response['error'] = 'Maaf, hanya boleh memilih 1 mobil';
                $response['errorMsg'] = 'Maaf, hanya boleh memilih 1 mobil';
                return json_encode($response);
            }

            $totalTempPrice = 'Rp ' . number_format($this->TempSalesModel->getTotalTempPrice(), '0', ',', '.');
            $data = [
                'totalPrice' => $totalTempPrice,
            ];
            $msg = [
                'paymentModal' => view('Sales/Modal/paymentModal', $data),
            ];

            echo json_encode($msg);
        }
    }

    /**
     * Displays the sales table containing the selected car.
     *
     * @return jsonResponse
     */
    public function salesTable()
    {
        if ($this->request->isAJAX()) {
            $data['cars'] = $this->TempSalesModel->getTempSales(user()->id);
            $response['salesTable'] = view('Sales/Table/salesTable', $data);

            echo json_encode($response);
        }
    }

    /**
     * Displays the current total price.
     *
     * @return jsonResponse
     */
    public function getTotalTempPrice()
    {
        if ($this->request->isAJAX()) {
            $totalTempPrice = 'Rp ' . number_format($this->TempSalesModel->getTotalTempPrice(), '0', ',', '.');

            $response = [
                'totalTempPrice' => $totalTempPrice,
            ];

            return json_encode($response);
        }
    }

        /**
     * Format phone number.
     *
     * @param string $phoneNumber string number
     *
     * @return string $phoneNumber
     */
    public function formatPhoneNumber($phoneNumber)
    {
        $isZero = substr($phoneNumber, 0, 1) == '0';
        $is62 = substr($phoneNumber, 0, 2) == '62';
        if ($isZero) {
            $phoneNumber = substr_replace($phoneNumber, "+62", 0, 1);
        } elseif ($is62) {
            $phoneNumber = substr_replace($phoneNumber, "+62", 0, 2);
        }
        return $phoneNumber;
    }

    /**
     * Choose a car to the sales table.
     *
     * @return jsonResponse
     */
    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $car = new Car();

            // Car Limit
            $selectedCar = $this->TempSalesModel->where('user_id', user()->id)->findAll();
            $isOverCarLimit = count($selectedCar) >= $this->salesCarLimit;
            if ($isOverCarLimit) {
                $response['error'] = 'Maaf, hanya boleh memilih 1 mobil';
                $response['errorMsg'] = 'Maaf, hanya boleh memilih 1 mobil';
                return json_encode($response);
            }

            $data = $car->findCarReady($keyword);

            // multiple data
            if ($data['totalCar'] > 1) {
                $response['totalCar'] = 'multiple';
            } elseif ($data['totalCar'] == 1) {
                $temp = [
                    'car_id' => $data['car']->id,
                    'user_id' => user()->id,
                ];

                $isSelected = ($this->TempSalesModel->where('car_id', $temp['car_id'])->where('user_id', $temp['user_id'])->findAll() != null);

                if ($isSelected) {
                    $response['error'] = 'Maaf, data sudah anda pilih...';
                    return json_encode($response);
                }

                $response['success'] = 'Berhasil menambahkan data';
                $this->TempSalesModel->save($temp);
            } else {
                $response['error'] = 'Maaf, data tidak ditemukan...';
            }

            return json_encode($response);
        }
    }

    /**
     * Displays an alert to delete the car that has been selected.
     *
     * @return jsonResponse
     */
    public function alertDeleteTemp()
    {
        if ($this->request->isAJAX()) {
            $tempId = $this->request->getPost('tempId');
            $temp = $this->TempSalesModel->getTempSales(user()->id, $tempId);
            if ($temp != null) {
                $response['carName'] = $temp->car_name;
            } else {
                $response['error'] = 'Data tidak ditemukan';
            }
            return json_encode($response);
        }
    }

    /**
     * Delete the selected car.
     *
     * @return jsonResponse
     */
    public function deleteTemp()
    {
        if ($this->request->isAJAX()) {
            $tempId = $this->request->getPost('tempId');
            $temp = $this->TempSalesModel->getTempSales(user()->id, $tempId);

            $isEmpty = ($temp == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $this->TempSalesModel->delete($temp->tempId);

            $response['success'] = 'Berhasil menghapus data penjualan';
            return json_encode($response);
        }
    }

    /**
     * Delete all selected cars.
     *
     * @return jsonResponse
     */
    public function resetTemp()
    {
        $temps = $this->TempSalesModel->getTempSales(user()->id);

        if ($temps != null) {
            foreach ($temps as $temp) {
                $this->TempSalesModel->delete($temp->tempId);
            }

            $response['success'] = 'Berhasil menghapus semua item yang dipilih';
            return json_encode($response);
        }

        $response['error'] = 'Tidak ada data yang dihapus';
        return json_encode($response);
    }

    /**
     * Change the total price after being given a discount.
     *
     * @return jsonResponse
     */
    public function setDiscount()
    {
        if ($this->request->isAJAX()) {
            $discount = str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('discount'));

            if ($discount == null) {
                $discount = 0;
            }
            $totalTempPrice = $this->TempSalesModel->getTotalTempPrice();
            $totalPrice = ($totalTempPrice - $discount);

            $response = [
                'totalPrice' => 'Rp ' . number_format($totalPrice, '0', ',', '.'),
            ];

            return json_encode($response);
        }
    }

    /**
     * Displays the remaining unpaid money.
     *
     * @return jsonResponse
     */
    public function setOver()
    {
        if ($this->request->isAJAX()) {
            $discount = str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('discount'));
            $amountOfMoney = str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('amount_of_money'));
            if ($discount == null) {
                $discount = 0;
            }

            if ($amountOfMoney == null) {
                $amountOfMoney = 0;
            }
            $totalTempPrice = $this->TempSalesModel->getTotalTempPrice();
            $totalPrice = ($totalTempPrice - $discount);

            $over = $totalPrice - $amountOfMoney;

            $response = [
                'over' => 'Rp ' . number_format($over, '0', ',', '.'),
            ];

            return json_encode($response);
        }
    }

    /**
     * Create receipt numbers.
     *
     * @return string $receiptNumber
     */
    public function getReceiptNumber()
    {
        $lastTransaction = $this->SalesModel->lastTransaction(date('Y-m-d'));

        $lastNumber = 0;
        if ($lastTransaction != null) {
            $lastNumber = substr($lastTransaction, -4); //4 Character dari belakang
        }
        $nextNumber = intval($lastNumber) + 1;
        $receiptNumber = 'NND' . date('dmy') . sprintf('%04s', $nextNumber);
        return $receiptNumber;
    }

    /**
     * Save payment.
     *
     * @return jsonResponse
     */
    public function savePayment()
    {
        if ($this->request->isAJAX()) {
            $cars = $this->TempSalesModel->getTempSales(user()->id);
            $isEmptyCar = ($cars == null);
            if ($isEmptyCar) {
                $response['error'] = 'Maaf, anda belum memilih mobil manapun...';
                $response['errorMsg'] = 'Maaf, anda belum memilih mobil manapun...';
                return json_encode($response);
            }

            $isOverCarLimit = count($cars) > $this->salesCarLimit;
            if ($isOverCarLimit) {
                $response['error'] = 'Maaf, hanya boleh memilih 1 mobil';
                $response['errorMsg'] = 'Maaf, hanya boleh memilih 1 mobil';
                return json_encode($response);
            }

            $sales['receipt_number'] = $this->getReceiptNumber();
            $sales['full_name'] = ucwords(strtolower($this->request->getVar('full_name')));
            $sales['identity_id'] = $this->request->getPost('identity_id');
            $sales['phone_number'] = $this->formatPhoneNumber($this->request->getPost('phone_number'));
            $sales['address'] = $this->request->getPost('address');
            $sales['identity_card'] = $this->request->getFile('identity_card');
            $sales['real_price'] = $this->TempSalesModel->getTotalTempPrice();
            $discount = $this->request->getPost('discount');
            if ($discount == null) {
                $discount = 0;
            }
            $sales['discount'] = str_replace([',', '.', 'Rp', ' '], '', $discount);
            $sales['total_price'] = ($sales['real_price'] - $sales['discount']);
            $payment['amount_of_money'] = str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('amount_of_money'));
            $sales['sales_date'] = date('Y-m-d H:i:s');
            $payment['payment_receipt'] = $this->request->getFile('payment_receipt');
            $sales['payment_receipt'] = $payment['payment_receipt']; //CHECK PHOTO

            $isDiscountValid = ($sales['discount'] <= $sales['real_price']);
            $isAmountOfMoneyValid = ($payment['amount_of_money'] <= $sales['total_price']);

            $isValid = ($this->validateData($sales, $this->SalesModel->getValidationRules(), $this->SalesModel->getValidationMessages()) && $payment['amount_of_money'] != null);
            if (!$isValid || !$isDiscountValid || !$isAmountOfMoneyValid) {
                $error = $this->validator->getErrors();

                if ($payment['amount_of_money'] == null) {
                    $errorPayment = ['amount_of_money' => 'Jumlah uang tidak boleh kosong'];
                    $error = array_merge($error, $errorPayment);
                }

                if (!$isDiscountValid) {
                    $errorPayment = ['discount' => 'Diskon tidak boleh melebihi harga asli'];
                    $error = array_merge($error, $errorPayment);
                }

                if (!$isAmountOfMoneyValid) {
                    $errorPayment = ['amount_of_money' => 'Jumlah uang tidak boleh melebihi total harga'];
                    $error = array_merge($error, $errorPayment);
                }

                $response = [
                    'error' => $error,
                    'errorMsg' => 'Gagal menyimpan pembayaran',
                ];
                return json_encode($response);
            }

            //Remove from array after check
            unset($sales['payment_receipt']);

            $payment['payment_receipt'] = $this->blobImage($payment['payment_receipt']);
            $sales['identity_card'] = $this->blobImage($sales['identity_card']);

            $this->SalesModel->save($sales);
            $salesId = $this->SalesModel->getInsertID();

            // Save Car
            $carData = [];
            foreach ($cars as $car) {
                $data = [
                    'sales_id' => $salesId,
                    'car_id' => $car->id,
                ];

                array_push($carData, $data);
                // Update Car To Sold
                $cars = new Car();
                $cars->updateCarStatus($car->id, 1);
            }

            $this->SalesModel->saveCar($carData);

            // save payment
            $payment = [
                'sales_id' => $salesId,
                'amount_of_money' => $payment['amount_of_money'],
                'description' => 'Pembayaran Awal',
                'payment_date' => date('Y-m-d H:i:s'),
                'payment_receipt' => $payment['payment_receipt'],
            ];

            $paymentId = $this->SalesModel->savePayment($payment);

            // Save payment transaction
            $transaction = new Transaction();
            $data = [
               'payment_sales_id' => $paymentId,
               'transaction_status' => 0,
            ];

            $transaction->setTransaction($data);

            $response['success'] = 'Berhasil menyimpan pembayaran';

            // Reset Temp
            $this->resetTemp();
            return json_encode($response);
        }
    }

    /**
     * Page Sales History.
     *
     * @return view
     */
    public function pageSalesHistory()
    {
        $data['title'] = 'Riwayat Penjualan';
        return view('Sales/History/index', $data);
    }

    /**
     * Page Sales History Detail.
     *
     * @return view
     */
    public function pageSalesHistoryDetail($receiptNumber)
    {
        ini_set('memory_limit', '-1');
        $sales = $this->SalesModel->where('receipt_number', $receiptNumber)->first();
        if ($sales != null) {
            $cars = $this->SalesModel->getCar($receiptNumber);
            $paid = $this->SalesModel->getPaid($receiptNumber);
            $data = [
                'title' => 'Detail | '. $sales->receipt_number,
                'sales' => $sales,
                'cars' => $cars,
                'paid' => $paid,
            ];
            return view('Sales/History/Detail/Tab/detail', $data);
        }
        return redirect()->to(base_url('penjualan/riwayat'));
    }

     /**
     * Get Sales History.
     *
     * @return Table
     */
    public function getSalesHistory()
    {
        ini_set('memory_limit', '-1');
        $request = Services::request();
        $salesModel = new DataTableSalesModel($request);
        if ($request->getMethod(true) == 'POST') {
            $sales = $salesModel->get_datatables();
            $data = [];
            foreach ($sales as $sale) {
                $paid = $this->SalesModel->getPaid($sale->receipt_number);
                $isPaid = ($sale->total_price - $paid <= 0);
                $paidBadge = 'danger';
                $paidDescription = 'Belum Lunas';
                if ($isPaid) {
                    $paidBadge = 'success';
                    $paidDescription = 'Lunas';
                }

                // Row Table
                $row = [];
                $row[] = $sale->sales_date;
                $row[] = $sale->receipt_number;
                $row[] = $sale->full_name;
                $row[] = $sale->phone_number;
                $row[] = "<span class=\"badge badge-light-$paidBadge fs-7 fw-bold\">$paidDescription</span>";
                $row[] = "Rp " . number_format($sale->total_price, '0', ',', '.');
                if (in_groups('Super Admin') || in_groups('Keuangan')) {
                    $urlDetail = base_url()."/penjualan/riwayat/".$sale->receipt_number;
                    $row[] = "<div class=\"text-end\"><a href=\"$urlDetail\" target=_blank class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1\">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class=\"svg-icon svg-icon-3\">
                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                            xmlns=\"http://www.w3.org/2000/svg\">
                            <path
                                d=\"M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.3\"
                                d=\"M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z\"
                                fill=\"currentColor\"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a></div>";
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $salesModel->count_all(),
                "recordsFiltered" => $salesModel->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    /**
     * Page Sales History Detail.
     *
     * @param String $receiptNumber receipt number
     *
     * @return view
     */
    public function pageSalesHistoryPayment($receiptNumber)
    {
        $sales = $this->SalesModel->where('receipt_number', $receiptNumber)->first();

        if ($sales != null) {
            $paid = $this->SalesModel->getPaid($receiptNumber);
            $payments = $this->SalesModel->getPayment($receiptNumber);
            $data = [
                'title' => 'Pembayaran | '. $sales->receipt_number,
                'sales' => $sales,
                'paid' => $paid,
                'payments' => $payments,
            ];
            return view('Sales/History/Detail/Tab/payment', $data);
        }
        return redirect()->to(base_url('penjualan/riwayat'));
    }

    /**
     * Opens a modal pop up to update additional cost.
     *
     * @return jsonResponse
     */
    public function addPaymentModal($receiptNumber)
    {
        if ($this->request->isAJAX()) {
            $sales = $this->SalesModel->where('receipt_number', $receiptNumber)->first();

            $isEmpty = ($sales == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $data['sales'] = $sales;
            $response = [
                'addPaymentModal' => view('Sales/History/Detail/Tab/Modal/addPaymentModal', $data),
            ];

            return json_encode($response);
        }
    }

    /**
     * Add Payment.
     *
     * @param String $receiptNumber receipt number
     *
     * @return jsonResponse
     */
    public function addPayment($receiptNumber)
    {
        if ($this->request->isAJAX()) {
            $sales = $this->SalesModel->where('receipt_number', $receiptNumber)->first();

            $isEmpty = ($sales == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $validationRules = [
                'description' => 'required|alpha_numeric_space',
                'amount_of_money' => 'required|numeric',
                'payment_receipt' => 'max_size[payment_receipt,5120]|is_image[payment_receipt]|mime_in[payment_receipt,image/jpg,image/jpeg,image/png]',
            ];

            $validationMessages = [
                'description' => [
                    'required' => 'Nama pengeluaran tidak boleh kosong.',
                    'alpha_numeric_space' => 'Nama pengeluaran hanya boleh angka atau huruf',
                ],
                'amount_of_money' => [
                    'required' => 'Jumlah pengeluaran tidak boleh kosong',
                    'numeric' => 'Jumlah pengeluaran hanya boleh angka',
                ],
                'payment_receipt' => [
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ],
            ];

            $input = [
                'description' => $this->request->getPost('description'),
                'amount_of_money' => str_replace([',', '.', 'Rp', ' '], '', $this->request->getPost('amount_of_money')),
                'payment_receipt' => $this->request->getFile('payment_receipt'),
            ];

            $paid = $this->SalesModel->getPaid($receiptNumber);

            $over = ($sales->total_price - $paid);
            $isAmountOfMoneyValid = ($input['amount_of_money'] <= $over);
            $isAmountOfMoneyMinus = ($input['amount_of_money'] <= 0);
            // Validation
            $isValid = $this->validateData($input, $validationRules, $validationMessages);
            if (!$isValid || !$isAmountOfMoneyValid || $isAmountOfMoneyMinus) {
                $error = $this->validator->getErrors();

                if (!$isAmountOfMoneyValid) {
                    $errorPayment = ['amount_of_money' => 'Jumlah uang tidak boleh melebihi sisa pembayaran'];
                    $error = array_merge($error, $errorPayment);
                }

                if ($isAmountOfMoneyMinus) {
                    $errorPayment = ['amount_of_money' => 'Jumlah uang tidak valid'];
                    $error = array_merge($error, $errorPayment);
                }

                $response = [
                    'error' => $error,
                    'errorMsg' => 'Gagal menyimpan pembayaran',
                ];
                return json_encode($response);
            }
            // Additional Receipt
            $paymentReceipt = null;
            if ($input['payment_receipt']->getError() != 4) {
                $paymentReceipt = $this->blobImage($input['payment_receipt']);
            }

            // Insert to Database
            $data = [
                'sales_id' => $sales->id,
                'description' => ucfirst(strtolower($input['description'])),
                'amount_of_money' => $input['amount_of_money'],
                'payment_receipt' => $paymentReceipt,
                'payment_date' => date('Y-m-d H:i:s')
            ];
            $paymentId = $this->SalesModel->savePayment($data);

            $response['success'] = 'Berhasil menambahkan pembayaran';

            // Save Car Transaction
            $transaction = new Transaction();
            $data = [
                'payment_sales_id' => $paymentId,
                'transaction_status' => 0,
            ];

            $transaction->setTransaction($data);

            return json_encode($response);
        }
    }

    /**
     * Download image payment receipt.
     *
     * @return jsonResponse
     */
    public function downloadPaymentReceipt($receiptNumber)
    {
        if ($this->request->isAJAX()) {
            $paymentId = $this->request->getPost('paymentId');
            $payment = $this->SalesModel->getPayment($receiptNumber, $paymentId);

            $isEmpty = ($payment == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $response['success'] = 'Berhasil mendownload image';
            $response['blobBase64'] = $payment->payment_receipt;
            $response['fileName'] = $payment->description;
            return json_encode($response);
        }
    }
}
