<?php

/**
 * GeneralSpend Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Spend
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

namespace App\Controllers;

/**
 * GeneralSpend Class Doc Comment
 *
 * PHP Version 8.0.13
 *
 * @category Spend
 * @package  DashboardShowroom
 * @author   Renanda Auzan Firdaus <renanda0039934@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/renufuss/dashboard-showroom
 */

class Spend extends BaseController
{
    protected $SpendModel;

    /**
     * Construct.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Open default page for https://base_url/pengeluaran.
     *
     * @return view
     */
    public function index()
    {
        $data['title'] = 'Pengeluaran Umum';
        return view('Spend/index', $data);
    }
}
