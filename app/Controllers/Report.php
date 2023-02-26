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
        }

        return $results;
    }

    public function getTotalProfit($transactionId)
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
        return $this->ReportModel->getGeneralCost(4, null, $transactionId);
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

    public function getGeneralIncome($transactionId)
    {
        return $this->ReportModel->getGeneralCost(2, null, $transactionId);
    }

    public function getTotalGeneralIncome($transactionId)
    {
        $totalGeneralIncome = 0;
        $generalIncomes = $this->getGeneralIncome($transactionId);

        if ($generalIncomes != null) {
            foreach ($generalIncomes as $income) {
                $totalGeneralIncome += $income->amount_of_money;
            }
        }

        return $totalGeneralIncome;
    }

    public function getGeneralOutcome($transactionId)
    {
        return $this->ReportModel->getGeneralCost(3, null, $transactionId);
    }

    public function getTotalGeneralOutcome($transactionId)
    {
        $totalGeneralOutcome = 0;
        $generalOutcomes = $this->getGeneralOutcome($transactionId);

        if ($generalOutcomes != null) {
            foreach ($generalOutcomes as $outcome) {
                $totalGeneralOutcome += $outcome->amount_of_money;
            }
        }

        return $totalGeneralOutcome;
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
        $reportId = $this->ReportModel->where('report_receipt', $reportReceipt)->first()?->id;

        $transactionId = $this->ReportModel->getClaimedTransactionId($reportId);

        $refunds = [];

        if ($transactionId != null) {
            $refunds = $this->getRefund($transactionId);
        }
        $totalRefund = $this->getTotalRefund($transactionId);

        $data = [
            'refunds' => $refunds,
            'totalRefund' => $totalRefund,
        ];

        $response['refundTable'] = view('Report/Detail/Table/refundTable', $data);
        return json_encode($response);
    }

    public function generalIncomeTable($reportReceipt)
    {
        $reportId = $this->ReportModel->where('report_receipt', $reportReceipt)->first()?->id;

        $transactionId = $this->ReportModel->getClaimedTransactionId($reportId);

        $generalIncomes = [];

        if ($transactionId != null) {
            $generalIncomes = $this->getGeneralIncome($transactionId);
        }
        $totalGeneralIncome = $this->getTotalGeneralIncome($transactionId);

        $data = [
            'generalIncomes' => $generalIncomes,
            'totalGeneralIncome' => $totalGeneralIncome,
        ];

        $response['generalIncomeTable'] = view('Report/Detail/Table/generalIncomeTable', $data);
        return json_encode($response);
    }

    public function generalOutcomeTable($reportReceipt)
    {
        $reportId = $this->ReportModel->where('report_receipt', $reportReceipt)->first()?->id;

        $transactionId = $this->ReportModel->getClaimedTransactionId($reportId);

        $generalOutcomes = [];

        if ($transactionId != null) {
            $generalOutcomes = $this->getGeneralOutcome($transactionId);
        }
        $totalGeneralOutcome = $this->getTotalGeneralOutcome($transactionId);

        $data = [
            'generalOutcomes' => $generalOutcomes,
            'totalGeneralOutcome' => $totalGeneralOutcome,
        ];

        $response['generalOutcomeTable'] = view('Report/Detail/Table/generalOutcomeTable', $data);
        return json_encode($response);
    }

    public function getCalculation($reportReceipt)
    {
        $report = $this->ReportModel->where('report_receipt', $reportReceipt)->first();

        $reportId = $report?->id;

        $transactionId = $this->ReportModel->getClaimedTransactionId($reportId);

        $totalProfit = $this->getTotalProfit($transactionId);
        $totalRefund = $this->getTotalRefund($transactionId);
        $totalGeneralIncome = $this->getTotalGeneralIncome($transactionId);
        $totalGeneralOutcome = $this->getTotalGeneralOutcome($transactionId);

        $totalGeneral = ($totalGeneralOutcome - $totalGeneralIncome);
        $totalGeneralResult = $totalGeneral / 2;

        $totalCar = ($totalProfit + $totalRefund);

        $percentHereansyahResult = $totalCar * $report->percent_hereansyah;
        $percentSamunResult = $totalCar * $report->percent_samun;

        $hereansyah = ($percentHereansyahResult - $totalGeneralResult);
        $samun = ($percentSamunResult - $totalGeneralResult);

        $response = [
            'percentHereansyah' => $report->percent_hereansyah,
            'percentSamun' => $report->percent_samun,
            'totalProfit' =>  "Rp " . number_format($totalProfit, '0', ',', '.'),
            'totalRefund' =>  "Rp " . number_format($totalRefund, '0', ',', '.'),
            'totalCar' => "Rp " . number_format($totalCar, '0', ',', '.'),
            'totalGeneralIncome' => "Rp " . number_format($totalGeneralIncome, '0', ',', '.'),
            'totalGeneralOutcome' => "Rp " . number_format($totalGeneralOutcome, '0', ',', '.'),
            'totalGeneral' => "Rp " . number_format($totalGeneral, '0', ',', '.'),
            'totalGeneralResult' => "Rp " . number_format($totalGeneralResult, '0', ',', '.'),
            'percentHereansyahResult' => "Rp " . number_format($percentHereansyahResult, '0', ',', '.'),
            'percentSamunResult' => "Rp " . number_format($percentSamunResult, '0', ',', '.'),
            'hereansyah' => "Rp " . number_format($hereansyah, '0', ',', '.'),
            'samun' => "Rp " . number_format($samun, '0', ',', '.'),
        ];

        return json_encode($response);
    }
}
