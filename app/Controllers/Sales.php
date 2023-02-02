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
        return view('Sales/index', $data);
    }

    protected function removeImage($imageName)
    {
        if (file_exists('assets/images/cars/' . $imageName)) {
            unlink('assets/images/cars/' . $imageName); //Hapus image lama
        }
    }

    protected function blobImage($image)
    {
        $image->move('assets/images/cars');
        $pathInfo = 'assets/images/cars/'.$image->getName();
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

    public function savePayment()
    {
        if ($this->request->isAJAX()) {
            $input['receipt_number'] = $this->getReceiptNumber();
            $input['full_name'] = $this->request->getPost('full_name');
            $input['identity_id'] = $this->request->getPost('identity_id');
            $input['phone_number'] = $this->request->getPost('phone_number');
            $input['address'] = $this->request->getPost('address');
            $input['identity_card'] = $this->request->getFile('identity_card');
            $input['real_price'] = $this->TempSalesModel->getTotalTempPrice();
            $input['discount'] = $this->request->getPost('discount');
            $input['total_price'] = $input['real_price']-$input['discount'];
            $input['amount_of_money'] = $this->request->getPost('amount_of_money');
            $input['sales_date'] = date('Y-m-d H:i:s');

            $isValid = ($this->validateData($input, $this->SalesModel->getValidationRules(), $this->SalesModel->getValidationMessages()));
            if ($isValid) {
            }
        }
    }
}
