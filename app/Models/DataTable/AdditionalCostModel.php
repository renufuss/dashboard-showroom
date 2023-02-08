<?php

namespace App\Models\DataTable;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AdditionalCostModel extends Model
{
    protected $table = "car_additional_cost";
    protected $column_order = array(null, 'description', 'amount_of_money', null, 'paid_by', null);
    protected $column_search = array('description', 'amount_of_money', 'paid_by');
    protected $order = array('description' => 'asc', 'amount_of_money' => 'asc', 'paid_by' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($carId = null)
    {
        $this->dt = $this->db->table($this->table)->select('*')->where('car_additional_cost.deleted_at', null);

        if ($carId != null) {
            $this->dt->where('car_id', $carId);
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
    public function get_datatables($carId = null)
    {
        $this->_get_datatables_query($carId);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }
    public function count_filtered($carId)
    {
        $this->_get_datatables_query($carId);
        return $this->dt->countAllResults();
    }
    public function count_all($carId = null)
    {
        $tbl_storage = $this->db->table($this->table)->select('*')->where('car_additional_cost.deleted_at', null);

        if ($carId != null) {
            $tbl_storage->where('car_id', $carId);
        }

        return $tbl_storage->countAllResults();
    }
}
