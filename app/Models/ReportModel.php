<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table      = 'report';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['car_id', 'car_price', 'user_id'];
}
