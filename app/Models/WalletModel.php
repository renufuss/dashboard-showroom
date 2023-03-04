<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table      = 'wallet';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['transaction_date', 'description', 'status', 'amount_of_money', 'user_id'];

    public function walletTransaction($description, $status, $amountOfMoney, $userId)
    {
        $data = [
            'transaction_date' => date('Y-m-d H:i:s'),
            'description' => $description,
            'status' => $status,
            'amount_of_money' => $amountOfMoney,
            'user_id' => $userId,
        ];

        $table = $this->db->table($this->table);

        $table->insert($data);

        return true;
    }
}
