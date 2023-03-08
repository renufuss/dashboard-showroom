<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReportModel;
use App\Models\TransactionModel;
use App\Models\WalletModel;
use Myth\Auth\Models\UserModel;

class ClaimReport extends BaseController
{
    protected $TransactionModel;
    protected $CarModel;
    protected $ReportModel;
    protected $WalletModel;
    protected $UserModel;
    protected $percentHereansyah;
    protected $percentSamun;

    public function __construct()
    {
        $this->TransactionModel = new TransactionModel();
        $this->CarModel = new CarModel();
        $this->ReportModel = new ReportModel();
        $this->WalletModel = new WalletModel();
        $this->UserModel = new UserModel();
        $this->percentHereansyah = 60/100;
        $this->percentSamun = 40/100;
    }

    public function index()
    {
        $data['title'] = 'Claim Laporan';
        return view('Report/ClaimReport/index', $data);
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

    public function getTotalProfit()
    {
        $totalProfit = 0;
        $transactions = $this->getProfit();

        if ($transactions != null) {
            foreach ($transactions as $transaction) {
                $totalProfit += $transaction['profit'];
            }
        }
        return $totalProfit;
    }

    public function getRefund()
    {
        return $this->TransactionModel->getGeneralCost(4);
    }

    public function getTotalRefund()
    {
        $totalRefund = 0;
        $refunds = $this->getRefund();

        if ($refunds != null) {
            foreach ($refunds as $refund) {
                $totalRefund += $refund->amount_of_money;
            }
        }

        return $totalRefund;
    }

    public function getGeneralIncome()
    {
        return $this->TransactionModel->getGeneralCost(2);
    }

    public function getTotalGeneralIncome()
    {
        $totalGeneralIncome = 0;
        $generalIncomes = $this->getGeneralIncome();

        if ($generalIncomes != null) {
            foreach ($generalIncomes as $income) {
                $totalGeneralIncome += $income->amount_of_money;
            }
        }

        return $totalGeneralIncome;
    }

    public function getGeneralOutcome()
    {
        return $this->TransactionModel->getGeneralCost(3);
    }

    public function getTotalGeneralOutcome()
    {
        $totalGeneralOutcome = 0;
        $generalOutcomes = $this->getGeneralOutcome();

        if ($generalOutcomes != null) {
            foreach ($generalOutcomes as $outcome) {
                $totalGeneralOutcome += $outcome->amount_of_money;
            }
        }

        return $totalGeneralOutcome;
    }

    public function getLoan($name)
    {
        $result = [];
        // Take All Car Sold
        $carSoldId = [];
        $carSold = $this->CarModel->where('status', 1)->findAll();

        foreach ($carSold as $car) {
            array_push($carSoldId, $car->id);
        }

        $loanCars = $this->TransactionModel->getTransaction(1, 1, $carSoldId, $name);
        $loanGenerals = $this->TransactionModel->getGeneralCost(3, $name);

        if ($loanCars != null || $loanGenerals != null) {
            foreach ($loanCars as $loanCar) {
                $description = $loanCar->carAdditionalCostDescription ?: "Pembelian";
                $array = [
                    'transaction_date' => $loanCar->transactionDate,
                    'description' => $loanCar->carLicenseNumber." :: ". $description,
                    'amount_of_money' => $loanCar->carAdditionalCostAmountOfMoney ?: $loanCar->carCapitalPrice,
                ];

                array_push($result, $array);
            }

            foreach ($loanGenerals as $loanGeneral) {
                $array = [
                    'transaction_date' => $loanGeneral->transaction_date,
                    'description' => $loanGeneral->description,
                    'amount_of_money' => $loanGeneral->amount_of_money,
                ];

                array_push($result, $array);
            }
        }

        return $result;
    }

    public function getTotalLoan($name)
    {
        $totalLoan = 0;
        $loans = $this->getLoan($name);

        if ($loans != null) {
            foreach ($loans as $loan) {
                $totalLoan += $loan['amount_of_money'];
            }
        }

        return $totalLoan;
    }

    public function profitTable()
    {
        $totalProfit = $this->getTotalProfit();
        $transactions = $this->getProfit();

        $data = [
            'transactions' => $transactions,
            'totalProfit' => $totalProfit,
        ];

        $response['profitTable'] = view('Report/ClaimReport/Table/profitTable', $data);
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

        $response['refundTable'] = view('Report/ClaimReport/Table/refundTable', $data);
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

        $response['generalIncomeTable'] = view('Report/ClaimReport/Table/generalIncomeTable', $data);
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

        $response['generalOutcomeTable'] = view('Report/ClaimReport/Table/generalOutcomeTable', $data);
        return json_encode($response);
    }

    public function loanTable()
    {
        $dataHereansyah = [
            'loans' => $this->getLoan('Hereansyah'),
            'totalLoan' => $this->getTotalLoan('Hereansyah'),
        ];

        $dataSamun = [
            'loans' => $this->getLoan('Sam un'),
            'totalLoan' => $this->getTotalLoan('Sam un'),
        ];

        $response = [
            'hereansyahLoanTable' => view('Report/ClaimReport/Table/loanTable', $dataHereansyah),
            'samunLoanTable' => view('Report/ClaimReport/Table/loanTable', $dataSamun),
        ];

        return json_encode($response);
    }

    public function getCalculation()
    {
        $totalProfit = $this->getTotalProfit();
        $totalRefund = $this->getTotalRefund();
        $totalGeneralIncome = $this->getTotalGeneralIncome();
        $totalGeneralOutcome = $this->getTotalGeneralOutcome();
        $hereansyahTotalLoan = $this->getTotalLoan('Hereansyah');
        $samunTotalLoan = $this->getTotalLoan('Sam un');

        $totalGeneral = ($totalGeneralOutcome - $totalGeneralIncome);
        $totalGeneralResult = $totalGeneral / 2;

        $totalCar = ($totalProfit + $totalRefund);

        $percentHereansyahResult = $totalCar * $this->percentHereansyah;
        $percentSamunResult = $totalCar * $this->percentSamun;

        $hereansyahResult = $percentHereansyahResult - $totalGeneralResult;
        $samunResult = $percentSamunResult - $totalGeneralResult;

        $hereansyah = $hereansyahResult + $hereansyahTotalLoan;
        $samun = $samunResult + $samunTotalLoan;

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
            'percentHereansyahResult' => "Rp " . number_format($percentHereansyahResult, '0', ',', '.'),
            'percentSamunResult' => "Rp " . number_format($percentSamunResult, '0', ',', '.'),
            'hereansyahTotalLoan' => "Rp " . number_format($hereansyahTotalLoan, '0', ',', '.'),
            'samunTotalLoan' => "Rp " . number_format($samunTotalLoan, '0', ',', '.'),
            'hereansyah' => "Rp " . number_format($hereansyah, '0', ',', '.'),
            'samun' => "Rp " . number_format($samun, '0', ',', '.'),
            'hereansyahResult' => "Rp " . number_format($hereansyahResult, '0', ',', '.'),
            'samunResult' => "Rp " . number_format($samunResult, '0', ',', '.'),
            'totalHereansyah' => $hereansyah,
            'totalSamun' => $samun,
        ];

        return json_encode($response);
    }

    /**
     * Create receipt numbers.
     *
     * @return string $reportReceipt
     */
    public function getReportReceipt()
    {
        $lastTransaction = $this->ReportModel->lastReport(date('Y-m-d'));

        $lastNumber = 0;
        if ($lastTransaction != null) {
            $lastNumber = substr($lastTransaction, -4); //4 Character dari belakang
        }
        $nextNumber = intval($lastNumber) + 1;
        $reportReceipt = 'RM' . date('dmy') . sprintf('%04s', $nextNumber);
        return $reportReceipt;
    }

    public function saveReport()
    {
        $reportReceipt = $this->getReportReceipt();
        $reportDate = date('Y-m-d');

        $data = [
            'percent_hereansyah' => $this->percentHereansyah,
            'percent_samun' => $this->percentSamun,
            'report_receipt' => $reportReceipt,
            'report_date' => $reportDate,
        ];
        $this->ReportModel->save($data);

        $data = [
            'reportId' => $this->ReportModel->getInsertID(),
            'reportReceipt' => $reportReceipt,
        ];
        return $data;
    }

    public function claimTransaction()
    {
        $transactionIds = [];
        $reportData = [];
        $transactions = $this->TransactionModel->where('claim_date', null)->findAll();

        if ($transactions == null) {
            $response['error'] = 'Tidak ada data yang diclaim';
            return json_encode($response);
        }

        $report = $this->saveReport();
        $reportId = $report['reportId'];

        // WALLET SAMUN DAN HEREANSYAH
        $samunId = $this->UserModel->where('username', 'samun')->first()?->id;
        $hereansyahId = $this->UserModel->where('username', 'hereansyah')->first()?->id;
        $calculation = json_decode($this->getCalculation());
        $description = 'CLAIM TRANSACTION :: '.$report['reportReceipt'];

        if ($hereansyahId != null && $samunId != null) {
            $this->WalletModel->walletTransaction($description, 0, $calculation->totalSamun, $samunId);
            $this->WalletModel->walletTransaction($description, 0, $calculation->totalHereansyah, $hereansyahId);
        }

        // SAVE TRANSACTION
        if ($transactions != null) {
            foreach ($transactions as $transaction) {
                array_push($transactionIds, $transaction->id);

                $data = [
                    'id' => $transaction->id,
                    'claim_date' => date('Y-m-d H:i:s'),
                ];
                $this->TransactionModel->save($data);
            }

            foreach ($transactionIds as $transactionId) {
                $data = [
                    'report_id' => $reportId,
                    'transaction_id' => $transactionId,
                ];
                array_push($reportData, $data);
            }
        }

        $this->ReportModel->saveClaimedTransaction($reportData);



        $response['success'] = 'Berhasil claim';
        return json_encode($response);
    }
}
