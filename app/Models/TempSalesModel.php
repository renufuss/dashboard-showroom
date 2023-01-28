<?php

namespace App\Models;

use CodeIgniter\Model;

class TempSalesModel extends Model
{
    protected $table      = 'temp_sales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['car_id', 'car_price', 'user_id'];

    public function getTempSales($user, $tempId = null)
    {
        $table = $this->db->table('temp_sales');
        $query = $table->select('*, temp_sales.id as tempId')->join('car', 'temp_sales.car_id=car.id', 'INNER')->where('user_id', $user)->where('car.deleted_at', null);

        if ($tempId != null) {
            $query->where('temp_sales.id', $tempId);
            return $query->get()->getFirstRow();
        }

        $car = $query->get()->getResultObject();
        return $car;
    }

    public function getTotalTempPrice()
    {
        $table = $this->db->table('temp_sales');
        $query = $table->select('SUM(car_price) as totalTempPrice')->join('car', 'temp_sales.car_id=car.id', 'INNER')->where('user_id', user()->id)->where('car.deleted_at', null);
        $price = $query->get()->getFirstRow()->totalTempPrice;
        if ($price != null) {
            return $price;
        }
        return 0;
    }
}
