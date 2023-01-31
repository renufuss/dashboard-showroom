<?php

namespace App\Controllers;

use App\Models\TempSalesModel;

class Sales extends BaseController
{
    protected $tempSalesModel;
    public function __construct()
    {
        $this->tempSalesModel = new TempSalesModel();
    }

    public function index()
    {
        $data['title'] = 'Layout';
        return view('Sales/index', $data);
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
            $totalTempPrice = 'Rp '.number_format($this->tempSalesModel->getTotalTempPrice(), '0', ',', '.');
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
            $data['cars'] = $this->tempSalesModel->getTempSales(user()->id);
            $response['salesTable'] = view('Sales/Table/salesTable', $data);

            echo json_encode($response);
        }
    }

    public function getTotalTempPrice()
    {
        if ($this->request->isAJAX()) {
            $totalTempPrice = 'Rp '.number_format($this->tempSalesModel->getTotalTempPrice(), '0', ',', '.');

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

                $isSelected = ($this->tempSalesModel->where('car_id', $temp['car_id'])->where('user_id', $temp['user_id'])->findAll() != null);

                if ($isSelected) {
                    $response['error'] = 'Maaf, data sudah anda pilih...';
                    return json_encode($response);
                }

                $response['success'] = 'Berhasil menambahkan data';
                $this->tempSalesModel->save($temp);
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
            $temp = $this->tempSalesModel->getTempSales(user()->id, $tempId);
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
            $temp = $this->tempSalesModel->getTempSales(user()->id, $tempId);

            $isEmpty = ($temp == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $this->tempSalesModel->delete($temp->tempId);

            $response['success'] = 'Berhasil menghapus data penjualan';
            return json_encode($response);
        }
    }

    public function resetTemp()
    {
        $temps = $this->tempSalesModel->getTempSales(user()->id);

        if ($temps != null) {
            foreach ($temps as $temp) {
                $this->tempSalesModel->delete($temp->tempId);
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
            $discount = str_replace([',','.','Rp '], '', $this->request->getPost('discount'));
            $totalTempPrice = $this->tempSalesModel->getTotalTempPrice();
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
            $discount = $this->request->getPost('discount');
            $amountOfMoney = $this->request->getPost('amount_of_money');

            if ($discount == null) {
                $discount = 0;
            }

            if ($amountOfMoney == null) {
                $amountOfMoney = 0;
            }

            $discount = str_replace([',','.','Rp '], '', $discount);
            $amountOfMoney = str_replace([',','.','Rp '], '', $amountOfMoney);
            $totalTempPrice = $this->tempSalesModel->getTotalTempPrice();
            $totalPrice = ($totalTempPrice - $discount);

            $over = $amountOfMoney - $totalPrice;

            $response = [
                'over' => 'Rp '.number_format($over, '0', ',', '.'),
            ];

            return json_encode($response);
        }
    }
}
