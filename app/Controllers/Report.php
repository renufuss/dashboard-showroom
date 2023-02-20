<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\TransactionModel;

class Report extends BaseController
{
    protected $TransactionModel;
    protected $CarModel;
    protected $percentHereansyah;
    protected $percentSamun;

    public function __construct()
    {
        $this->TransactionModel = new TransactionModel();
        $this->CarModel = new CarModel();

        $this->percentHereansyah = 0.6;
        $this->percentSamun = 0.4;
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
    public function getProfit()
    {
        // Take All Car Sold
        $carSoldId = [];
        $carSold = $this->CarModel->where('status', 1)->findAll();

        foreach ($carSold as $car) {
            array_push($carSoldId, $car->id);
        }

        $inCars = $this->TransactionModel->getTransaction(1, 0, $carSoldId, false);
        $results = [];

        if ($inCars != null) {
            foreach ($inCars as $inCar) {
                $carCapitalPrice = 0;
                $additionalCost = 0;
                $carId = [$inCar->salesCarId];
                $outCars = $this->TransactionModel->getTransaction(1, 1, $carId, false);
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

    public function getTotalProfit()
    {
        $totalProfit = 0;
        $transactions = $this->getProfit();

        foreach ($transactions as $transaction) {
            $totalProfit += $transaction['profit'];
        }
        return $totalProfit;
    }

    public function getRefund()
    {
        return $this->TransactionModel->getGeneralCost(4, null, false);
    }

    public function getTotalRefund()
    {
        $totalRefund = 0;
        $refunds = $this->getRefund();

        foreach ($refunds as $refund) {
            $totalRefund += $refund->amount_of_money;
        }

        return $totalRefund;
    }

    public function getGeneralIncome()
    {
        return $this->TransactionModel->getGeneralCost(2, null, false);
    }

    public function getTotalGeneralIncome()
    {
        $totalGeneralIncome = 0;
        $generalIncomes = $this->getGeneralIncome();

        foreach ($generalIncomes as $income) {
            $totalGeneralIncome += $income->amount_of_money;
        }

        return $totalGeneralIncome;
    }

    public function getGeneralOutcome()
    {
        return $this->TransactionModel->getGeneralCost(3, null, false);
    }

    public function getTotalGeneralOutcome()
    {
        $totalGeneralOutcome = 0;
        $generalOutcomes = $this->getGeneralOutcome();

        foreach ($generalOutcomes as $outcome) {
            $totalGeneralOutcome += $outcome->amount_of_money;
        }

        return $totalGeneralOutcome;
    }

    public function profitTable()
    {
        $totalProfit = $this->getTotalProfit();
        $transactions = $this->getProfit();

        $data = [
            'transactions' => $transactions,
            'totalProfit' => $totalProfit,
        ];

        $response['profitTable'] = view('Report/Table/profitTable', $data);
        return json_encode($response);
    }

    public function refundTable()
    {
        $refunds = $this->getRefund();
        $totalRefund = $this->getTotalRefund();

        $data = [
            'refunds' => $refunds,
            'totalRefund' => $totalRefund,
        ];

        $response['refundTable'] = view('Report/Table/refundTable', $data);
        return json_encode($response);
    }

    public function generalIncomeTable()
    {
        $generalIncomes = $this->getGeneralIncome();
        $totalGeneralIncome = $this->getTotalGeneralIncome();

        $data = [
            'generalIncomes' => $generalIncomes,
            'totalGeneralIncome' => $totalGeneralIncome,
        ];

        $response['generalIncomeTable'] = view('Report/Table/generalIncomeTable', $data);
        return json_encode($response);
    }

    public function generalOutcomeTable()
    {
        $generalOutcomes = $this->getGeneralOutcome();
        $totalGeneralOutcome = $this->getTotalGeneralOutcome();

        $data = [
            'generalOutcomes' => $generalOutcomes,
            'totalGeneralOutcome' => $totalGeneralOutcome,
        ];

        $response['generalOutcomeTable'] = view('Report/Table/generalOutcomeTable', $data);
        return json_encode($response);
    }


    public function getCalculation()
    {
        $totalProfit = $this->getTotalProfit();
        $totalRefund = $this->getTotalRefund();
        $totalGeneralIncome = $this->getTotalGeneralIncome();
        $totalGeneralOutcome = $this->getTotalGeneralOutcome();

        $totalGeneral = ($totalGeneralOutcome - $totalGeneralIncome);
        $totalGeneralResult = $totalGeneral / 2;

        $totalCar = ($totalProfit + $totalRefund);

        $hereansyah = (($totalCar * $this->percentHereansyah) - $totalGeneralResult);
        $samun = (($totalCar * $this->percentSamun) - $totalGeneralResult);

        $response = [
            'percentHereansyah' => $this->percentHereansyah,
            'percentSamun' => $this->percentSamun,
            'totalProfit' =>  "Rp " . number_format($totalProfit, '0', ',', '.'),
            'totalRefund' =>  "Rp " . number_format($totalRefund, '0', ',', '.'),
            'totalCar' => "Rp " . number_format($totalCar, '0', ',', '.'),
            'totalGeneralIncome' => "Rp " . number_format($totalGeneralIncome, '0', ',', '.'),
            'totalGeneralOutcome' => "Rp " . number_format($totalGeneralOutcome, '0', ',', '.'),
            'totalGeneral' => "Rp " . number_format($totalGeneral, '0', ',', '.'),
            'totalGeneralResult' => "Rp " . number_format($totalGeneralResult, '0', ',', '.'),
            'hereansyah' => "Rp " . number_format($hereansyah, '0', ',', '.'),
            'samun' => "Rp " . number_format($samun, '0', ',', '.'),
        ];

        return json_encode($response);
    }
}
