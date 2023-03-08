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

    public function showSaldo($username)
    {
        $table = $this->db->table($this->table);
        $inBalance = $table->select('SUM(amount_of_money) as inBalance')->where('wallet.status', 0)->where('users.username', $username)->join('users', 'user_id=users.id')->get()->getFirstRow()->inBalance ?: 0;
        $outBalance = $table->select('SUM(amount_of_money) as outBalance')->where('wallet.status', 1)->where('users.username', $username)->join('users', 'user_id=users.id')->get()->getFirstRow()->outBalance ?: 0;

        return $inBalance - $outBalance;
    }

    public function showWallet($username)
    {
        $table = $this->db->table($this->table);
        $query = $table->select('wallet.*')->where('users.username', $username)->join('users', 'user_id=users.id')->get()->getResultObject();

        return $query;
    }
}
