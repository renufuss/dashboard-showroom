<?php

namespace App\Models\DataTable;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = "car";
    protected $column_order = array('car_name', 'car_color', 'car_year', 'license_number', 'capital_price', null);
    protected $column_search = array('car_name', 'car_color', 'car_year', 'license_number', 'capital_price');
    protected $order = array('car_name' => 'asc', 'car_color' => 'asc', 'car_year' => 'asc', 'license_number' => 'asc', 'capital_price' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($status = null, $brandId = null)
    {
        $this->dt = $this->db->table($this->table)->select('car.*, brand_name')->join('car_brand', 'car.brand_id=car_brand.id')->where('car.deleted_at', null);

        if ($status != null) {
            $this->dt->where('car.status', $status);
        }

        if ($brandId != null) {
            $this->dt->where('car.brand_id', $brandId);
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
    public function get_datatables($status = null, $brandId = null)
    {
        $this->_get_datatables_query($status, $brandId);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }
    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    public function count_all($status = null, $brandId = null)
    {
        $tbl_storage = $this->db->table($this->table)->select('car.*, brand_name')->join('car_brand', 'car.brand_id=car_brand.id')->where('car.deleted_at', null);

        if ($status != null) {
            $tbl_storage->where('car.status', $status);
        }

        if ($brandId != null) {
            $tbl_storage->where('car.brand_id', $brandId);
        }

        return $tbl_storage->countAllResults();
    }
}
