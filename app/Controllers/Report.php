<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\TransactionModel;

class Report extends BaseController
{
    protected $TransactionModel;
    protected $CarModel;
    public function __construct()
    {
        $this->TransactionModel = new TransactionModel();
        $this->CarModel = new CarModel();
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        return view('Report/index', $data);
    }

    /**
     * get total transaction car.
     *
     * @return jsonResponse
     */
    public function getTransaction()
    {
        // Take All Car Sold
        $carSoldId = [];
        $carSold = $this->CarModel->where('status', 1)->findAll();

        foreach ($carSold as $car) {
            array_push($carSoldId, $car->id);
        }

        $inCars = $this->TransactionModel->getTransaction(1, 0, $carSoldId);
        $results = [];

        if ($inCars != null) {
            foreach ($inCars as $inCar) {
                $carCapitalPrice = 0;
                $additionalCost = 0;
                $carId = [$inCar->salesCarId];
                $outCars = $this->TransactionModel->getTransaction(1, 1, $carId);
                $isAlreadyAdded = false;

                // Check result
                foreach ($results as $result) {
                    if ($result['receipt_number'] == $inCar->salesReceiptNumber) {
                        $isAlreadyAdded = true;
                    }
                }

                if ($outCars != null) {
                    foreach ($outCars as $outCar) {
                        $carCapitalPrice = $outCar->carCapitalPrice;
                        $additionalCost = $additionalCost + $outCar->carAdditionalCostAmountOfMoney;
                    }
                }

                $outcome = ($carCapitalPrice + $additionalCost) ;

                if ($isAlreadyAdded) {
                    $outcome = 0;
                }

                $array = [
                    'car_id' => $inCar->salesCarId,
                    'description' => $inCar->paymentSalesDescription,
                    'license_number' =>  $inCar->salesLicenseNumber,
                    'receipt_number' => $inCar->salesReceiptNumber,
                    'income' => $inCar->paymentSalesAmountOfMoney,
                    'outcome' => $outcome,
                    'profit' => $inCar->paymentSalesAmountOfMoney - $outcome,
                ];

                array_push($results, $array);
            }
        } else {
            return null;
        }


        return $results;
    }

    public function profitTable()
    {
        $totalProfit = 0;
        $transactions = $this->getTransaction();

        foreach ($transactions as $transaction) {
            $totalProfit += $transaction['profit'];
        }

        $data = [
            'transactions' => $transactions,
            'totalProfit' => $totalProfit,
        ];

        $response['profitTable'] = view('Report/Table/profitTable', $data);
        return json_encode($response);
    }
}
