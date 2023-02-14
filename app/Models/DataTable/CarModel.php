<?php

namespace App\Models\DataTable;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = "car";
    protected $column_order = array('car_name', 'car_color', 'car_year', 'license_number', null, 'capital_price', 'car_price', null);
    protected $column_search = array('car_name', 'car_color', 'car_year', 'license_number', 'capital_price', 'car_price', 'brand_name');
    protected $order = array('car_name' => 'asc', 'car_color' => 'asc', 'car_year' => 'asc', 'license_number' => 'asc', 'capital_price' => 'asc', 'car_price' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($status = null, $brandId = null, $keyword = [])
    {
        $this->dt = $this->db->table($this->table)->select('car.*, brand_name, receipt_number')
        ->join('car_brand', 'car.brand_id=car_brand.id', 'left')
        ->join('car_sales', 'car.id=car_sales.car_id', 'left')
        ->join('sales', 'car_sales.sales_id=sales.id', 'left')
        ->where('car.deleted_at', null);


        if ($brandId != null) {
            $this->dt->where('car.brand_id', $brandId);
        }
        if ($status != null) {
            $this->dt->where('car.status', $status);
        }

        if ($keyword != null) {
            $this->dt->groupStart();
            $this->dt->like('car_name', $keyword['car_name']);
            if ($keyword['license_number'] != false) {
                $this->dt->orLike('license_number', $keyword['license_number']);
            }
            $this->dt->groupEnd();
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    public function get_datatables($status = null, $brandId = null, $keyword = [])
    {
        $this->_get_datatables_query($status, $brandId, $keyword);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }
    public function count_filtered($status = null, $brandId = null, $keyword = [])
    {
        $this->_get_datatables_query($status, $brandId, $keyword);
        return $this->dt->countAllResults();
    }
    public function count_all($status = null, $brandId = null, $keyword = [])
    {
        $tbl_storage = $this->db->table($this->table)->select('car.*, brand_name')->join('car_brand', 'car.brand_id=car_brand.id')->where('car.deleted_at', null);

        if ($status != null) {
            $tbl_storage->where('car.status', $status);
        }

        if ($brandId != null) {
            $tbl_storage->where('car.brand_id', $brandId);
        }

        if ($keyword != null) {
            $tbl_storage->groupStart();
            $tbl_storage->like('car_name', $keyword['car_name']);
            if ($keyword['license_number'] != false) {
                $tbl_storage->orLike('license_number', $keyword['license_number']);
            }
            $tbl_storage->groupEnd();
        }

        return $tbl_storage->countAllResults();
    }
}
