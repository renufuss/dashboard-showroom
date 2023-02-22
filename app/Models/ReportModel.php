<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table      = 'report';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['report_receipt', 'report_date'];

    public function lastReport($date)
    {
        $transaction = $this->db->table('report');
        $query = $transaction->select('max(report_receipt) as report_receipt')->like('report_date', $date);
        $lastTransaction = $query->get()->getFirstRow()->report_receipt;

        return $lastTransaction;
    }

    public function saveClaimedTransaction($data)
    {
        $table = $this->db->table('claimed_transaction');
        $table->insertBatch($data);

        return true;
    }
}
