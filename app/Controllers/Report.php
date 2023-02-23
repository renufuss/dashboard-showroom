<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReportModel;
use App\Models\TransactionModel;

class Report extends BaseController
{
    protected $ReportModel;
    protected $CarModel;
    protected $TransactionModel;

    public function __construct()
    {
        $this->ReportModel = new ReportModel();
        $this->CarModel = new CarModel();
        // $this->TransactionModel = new TransactionModel();
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        $data['reports'] = $this->ReportModel->orderBy('report_date', 'desc')->orderBy('report_receipt', 'desc')->findAll();
        return view('Report/index', $data);
    }

    public function getProfit($transactionId = [])
    {
        // Take All Car Sold
        $carSoldId = [];
        $carSold = $this->CarModel->where('status', 1)->findAll();

        foreach ($carSold as $car) {
            array_push($carSoldId, $car->id);
        }

        $inCars = $this->ReportModel->getProfit(1, 0, $carSoldId, $transactionId);
        $results = [];

        if ($inCars != null) {
            foreach ($inCars as $inCar) {
                $carCapitalPrice = 0;
                $additionalCost = 0;
                $carId = [$inCar->salesCarId];
                $outCars = $this->ReportModel->getProfit(1, 1, $carId, $transactionId);
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
                    'transaction_id' => $inCar->transactionId,
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

    public function getTotalProfit($transactionId = [])
    {
        $totalProfit = 0;
        $transactions = $this->getProfit($transactionId);

        if ($transactions != null) {
            foreach ($transactions as $transaction) {
                $totalProfit += $transaction['profit'];
            }
        }
        return $totalProfit;
    }

    public function getRefund($transactionId)
    {
        return $this->ReportModel->getGeneralCost(4, null, false, $transactionId);
    }

    public function getTotalRefund($transactionId)
    {
        $totalRefund = 0;
        $refunds = $this->getRefund($transactionId);

        if ($refunds != null) {
            foreach ($refunds as $refund) {
                $totalRefund += $refund->amount_of_money;
            }
        }

        return $totalRefund;
    }

    public function detail($reportReceipt)
    {
        $data =[
            'title' => 'Detail | '.$reportReceipt,
            'reportReceipt' => $reportReceipt,
        ];
        return view('Report/Detail/index', $data);
    }

    public function profitTable($reportReceipt)
    {
        $reportId = $this->ReportModel->where('report_receipt', $reportReceipt)->first()?->id;

        $transactionId = $this->ReportModel->getClaimedTransactionId($reportId);

        $transactions = [];

        if ($transactionId != null) {
            $transactions = $this->getProfit($transactionId);
        }
        $totalProfit = $this->getTotalProfit($transactionId);

        $data = [
            'transactions' => $transactions,
            'totalProfit' => $totalProfit,
        ];


        // return $transactions;
        $response['profitTable'] = view('Report/Detail/Table/profitTable', $data);
        return json_encode($response);
    }

    public function refundTable($reportReceipt)
    {
        $refunds = $this->getRefund($reportReceipt);
        $totalRefund = $this->getTotalRefund($reportReceipt);

        $data = [
            'refunds' => $refunds,
            'totalRefund' => $totalRefund,
        ];

        $response['refundTable'] = view('Report/Detail/Table/refundTable', $data);
        return json_encode($response);
    }
}
