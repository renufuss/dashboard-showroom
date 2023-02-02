<?php

namespace App\Controllers;

use App\Models\SalesModel;
use App\Models\TempSalesModel;

class Sales extends BaseController
{
    protected $TempSalesModel;
    protected $SalesModel;
    public function __construct()
    {
        $this->SalesModel = new SalesModel();
        $this->TempSalesModel = new TempSalesModel();
    }

    public function index()
    {
        $data['title'] = 'Layout';
        // return view('Sales/index', $data);
        return view('Sales/Print/invoice2', $data);
    }

    protected function removeImage($imageName)
    {
        if (file_exists('assets/images/cars/' . $imageName)) {
            unlink('assets/images/cars/' . $imageName); //Hapus image lama
        }
    }

    protected function blobImage($image)
    {
        $image->move('assets/images/sales');
        $pathInfo = 'assets/images/sales/'.$image->getName();
        $fileContent = file_get_contents($pathInfo);
        $base64 = rtrim(base64_encode($fileContent));
        $this->removeImage($image->getName());

        return $base64;
    }

    public function carModal()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');

            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'carModal' => view('Sales/Modal/carModal', $data),
            ];

            echo json_encode($msg);
        }
    }

    public function paymentModal()
    {
        if ($this->request->isAJAX()) {
            $totalTempPrice = 'Rp '.number_format($this->TempSalesModel->getTotalTempPrice(), '0', ',', '.');
            $data = [
                'totalPrice' => $totalTempPrice,
            ];
            $msg = [
                'paymentModal' => view('Sales/Modal/paymentModal', $data),
            ];

            echo json_encode($msg);
        }
    }

    public function salesTable()
    {
        if ($this->request->isAJAX()) {
            $data['cars'] = $this->TempSalesModel->getTempSales(user()->id);
            $response['salesTable'] = view('Sales/Table/salesTable', $data);

            echo json_encode($response);
        }
    }

    public function getTotalTempPrice()
    {
        if ($this->request->isAJAX()) {
            $totalTempPrice = 'Rp '.number_format($this->TempSalesModel->getTotalTempPrice(), '0', ',', '.');

            $response = [
                'totalTempPrice' => $totalTempPrice,
            ];

            return json_encode($response);
        }
    }

    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $car = new Car();

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

    public function setDiscount()
    {
        if ($this->request->isAJAX()) {
            $discount = str_replace([',','.','Rp', ' '], '', $this->request->getPost('discount'));

            if ($discount == null) {
                $discount = 0;
            }
            $totalTempPrice = $this->TempSalesModel->getTotalTempPrice();
            $totalPrice = ($totalTempPrice - $discount);

            $response = [
                'totalPrice' => 'Rp '.number_format($totalPrice, '0', ',', '.'),
            ];

            return json_encode($response);
        }
    }

    public function setOver()
    {
        if ($this->request->isAJAX()) {
            $discount = str_replace([',','.','Rp',' '], '', $this->request->getPost('discount'));
            $amountOfMoney = str_replace([',','.','Rp',' '], '', $this->request->getPost('amount_of_money'));
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
                'over' => 'Rp '.number_format($over, '0', ',', '.'),
            ];

            return json_encode($response);
        }
    }

    public function getReceiptNumber()
    {
        $lastTransaction = $this->SalesModel->lastTransaction(date('Y-m-d'));

        $lastNoUrut = 0;
        if ($lastTransaction != null) {
            $lastNoUrut = substr($lastTransaction, -4); //4 Character dari belakang
        }
        $nextNoUrut = intval($lastNoUrut) + 1;
        $receiptNumber = 'NND' . date('dmy') . sprintf('%04s', $nextNoUrut);
        return $receiptNumber;
    }

    public function savePayment()
    {
        if ($this->request->isAJAX()) {
            $sales['receipt_number'] = $this->getReceiptNumber();
            $sales['full_name'] = $this->request->getPost('full_name');
            $sales['identity_id'] = $this->request->getPost('identity_id');
            $sales['phone_number'] = $this->request->getPost('phone_number');
            $sales['address'] = $this->request->getPost('address');
            $sales['identity_card'] = $this->request->getFile('identity_card');
            $sales['real_price'] = $this->TempSalesModel->getTotalTempPrice();
            $discount = $this->request->getPost('discount');
            if ($discount == null) {
                $discount = 0;
            }
            $sales['discount'] = str_replace([',','.','Rp',' '], '', $discount);
            $sales['total_price'] = ($sales['real_price']-$sales['discount']);
            $payment['amount_of_money'] = str_replace([',','.','Rp',' '], '', $this->request->getPost('amount_of_money'));
            $sales['sales_date'] = date('Y-m-d H:i:s');

            $isValid = ($this->validateData($sales, $this->SalesModel->getValidationRules(), $this->SalesModel->getValidationMessages()) && $payment['amount_of_money'] != null);
            if (!$isValid) {
                $error = $this->validator->getErrors();

                if ($payment['amount_of_money'] == null) {
                    $errorPayment = ['amount_of_money' => 'Jumlah uang tidak boleh kosong'];
                    $error = array_merge($error, $errorPayment);
                }

                $response = [
                    'error' => $error,
                    'errorMsg' => 'Gagal menyimpan pembayaran',
                ];
                return json_encode($response);
            }

            $sales['identity_card'] = $this->blobImage($sales['identity_card']);

            $this->SalesModel->save($sales);
            $salesId = $this->SalesModel->getInsertID();

            // Save Car
            $cars = $this->TempSalesModel->getTempSales(user()->id);
            $carData = [];
            foreach ($cars as $car) {
                $data = [
                    'sales_id' => $salesId,
                    'car_name' => $car->car_name,
                    'license_number' => $car->license_number,
                    'car_price' => $car->car_price,
                ];

                array_push($carData, $data);
            }

            $this->SalesModel->saveCar($carData);

            $payment = [
                'sales_id' => $salesId,
                'amount_of_money' => $payment['amount_of_money'],
                'payment_date' => date('Y-m-d H:i:s'),
            ];

            $this->SalesModel->savePayment($payment);

            $response['success'] = 'Berhasil menyimpan pembayaran';
            return json_encode($response);
        }
    }
}
