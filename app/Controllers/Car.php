<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\DataTable\CarModel as DataTableCarModel;
use App\Models\DataTable\AdditionalCostModel as DataTableAdditionalCostModel;
use Config\Services;
use Dompdf\Dompdf;

class Car extends BaseController
{
    protected $CarModel;
    protected $Session;
    public function __construct()
    {
        $this->Session = session();
        $this->CarModel = new CarModel();
    }

    public function index()
    {
        $data['title'] = 'Mobil';
        $data['brands'] = $this->CarModel->getBrands();
        return view('Car/index', $data);
    }

    public function pageSetCar()
    {
        // custom session
        $data['title'] = 'Tambah Mobil';
        $data['brands'] = $this->CarModel->getBrands();
        return view('Car/SetCar/index', $data);
    }

    protected function removeImage($imageName)
    {
        if (file_exists('assets/images/cars/' . $imageName)) {
            unlink('assets/images/cars/' . $imageName); //Hapus image lama
        }
    }

    protected function blobImage($image)
    {
        $image->move('assets/images/cars');
        $pathInfo = 'assets/images/cars/'.$image->getName();
        $fileContent = file_get_contents($pathInfo);
        $base64 = rtrim(base64_encode($fileContent));
        $this->removeImage($image->getName());

        return $base64;
    }

    public function setCar()
    {
        if ($this->request->isAJAX()) {
            // Form Input
            $licenseNumber = $this->formatLicenseNumber(strtoupper($this->request->getPost('license_number')));
            $input = [
                'id' => $this->request->getPost('id'),
                'car_name' => $this->request->getPost('car_name'),
                'license_number' => $licenseNumber,
                'car_color' => $this->request->getPost('car_color'),
                'car_year' => $this->request->getPost('car_year'),
                'car_brand' => $this->request->getPost('car_brand'),
                'capital_price' => str_replace([',','.','Rp '], '', $this->request->getPost('capital_price')),
                'car_price' => str_replace([',','.','Rp '], '', $this->request->getPost('car_price')),
                'receipt' => $this->request->getFile('receipt'),
                'car_image' => $this->request->getFile('car_image'),
            ];

            // Validation
            $isValid = ($this->validateData($input, $this->CarModel->getValidationRules(), $this->CarModel->getValidationMessages()) && $this->CarModel->checkBrand($input['car_brand']));
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'errorMsg' => 'Gagal menyimpan mobil',
                ];
                return json_encode($response);
            }

            // Convert Image To String
            $receipt = $this->blobImage($input['receipt']);
            $carImage = $this->blobImage($input['car_image']);

            //Save
            $data = [
                'car_name' => ucwords(strtolower($input['car_name'])),
                'license_number' => $licenseNumber,
                'car_color' => ucwords(strtolower($input['car_color'])),
                'car_year' => $input['car_year'],
                'brand_id' => $input['car_brand'],
                'capital_price' => $input['capital_price'],
                'car_price' => $input['car_price'],
                'receipt' => $receipt,
                'car_image' => $carImage,
            ];
            if ($input['id'] != null) {
                $data['id'] = $input['id'];
            }

            $this->CarModel->save($data);

            if ($input['id'] == null) {
                // Insert Temp Additional Cost
                $tempSession = $this->request->getPost('temp_session');
                $tempAdditionalCost = $this->CarModel->getTempAdditionalCost(user()->id, null, $tempSession);
                $carId = $this->CarModel->getInsertID();
                if ($tempAdditionalCost != null) {
                    $this->CarModel->setAdditionalCost($tempAdditionalCost, $carId);
                }
            }

            $response['success'] = 'Berhasil menyimpan mobil';
            return json_encode($response);
        }
    }

    public function pageEditGeneralCar($id)
    {
        $car = $this->CarModel->find($id);
        if ($car != null) {
            $car->car_brand = $this->CarModel->checkBrand($car->brand_id);
            $data = [
                'title' => $car->car_name.' | Edit Car',
                'car' => $car,
                'brands' => $this->CarModel->getBrands(),
                'additionalCosts' => $this->CarModel->getAdditionalCost($car->id),
            ];
            return view('Car/EditCar/general', $data);
        } else {
            return redirect()->to(base_url('mobil'));
        }
    }

    public function pageEditAdditionalCost($id)
    {
        $car = $this->CarModel->find($id);
        if ($car != null) {
            $car->car_brand = $this->CarModel->checkBrand($car->brand_id);
            $data = [
                'title' => $car->car_name.' | Edit Car',
                'car' => $car,
                'additionalCosts' => $this->CarModel->getAdditionalCost($car->id),
                'brands' => $this->CarModel->getBrands(),
            ];
            return view('Car/EditCar/additionalCost', $data);
        } else {
            return redirect()->to(base_url('mobil'));
        }
    }

    public function getAdditionalCost($carId)
    {
        ini_set('memory_limit', '-1');
        $request = Services::request();
        $additionalCostModel = new DataTableAdditionalCostModel($request);
        if ($request->getMethod(true) == 'POST') {
            $additionalCosts = $additionalCostModel->get_datatables($carId);
            $no = $request->getPost('start');
            $data = [];
            foreach ($additionalCosts as $additionalCost) {
                $no++;
                // Row Table
                $row = [];
                $row[] = $no;
                $row[] = $additionalCost->cost_name;
                $row[] = "Rp " . number_format($additionalCost->additional_price, '0', ',', '.');
                if ($additionalCost->additional_receipt != null) {
                    $row[] = "<button class=\"btn btn-icon btn-bg-light btn-active-color-success btn-sm\"
                    onclick=\"getImage('$additionalCost->id');return false;\"><span class=\"svg-icon svg-icon-muted svg-icon-2hx\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"
                    fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path opacity=\"0.3\"
                        d=\"M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z\"
                        fill=\"currentColor\" />
                    <path d=\"M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z\"
                        fill=\"currentColor\" />
                    <path opacity=\"0.3\" d=\"M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z\"
                        fill=\"currentColor\" />
                </svg>
            </span>
            <!--end::Svg Icon-->
                </button>";
                } else {
                    $row[] = "<span>-</span>";
                }
                $row[] = $additionalCost->paid_by;
                $row[] = "<div class=\"d-flex justify-content-end flex-shrink-0\">
                <a href=\"a\" target=_blank class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1\">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class=\"svg-icon svg-icon-3\">
                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                            xmlns=\"http://www.w3.org/2000/svg\">
                            <path
                                d=\"M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.3\"
                                d=\"M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z\"
                                fill=\"currentColor\"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>
                <button class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm\" onclick=\"alertCarDelete('b')\">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class=\"svg-icon svg-icon-3\">
                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                            xmlns=\"http://www.w3.org/2000/svg\">
                            <path
                                d=\"M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.5\"
                                d=\"M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z\"
                                fill=\"currentColor\"></path>
                            <path opacity=\"0.5\"
                                d=\"M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z\"
                                fill=\"currentColor\"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
            </div>";

                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $additionalCostModel->count_all($carId),
                "recordsFiltered" => $additionalCostModel->count_filtered($carId),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function formatLicenseNumber($licenseNumber)
    {
        $licenseNumber = str_replace(' ', '', $licenseNumber);
        $realNumber = [];
        $convertNumber = [];
        for ($i = 0; $i < strlen($licenseNumber); $i++) {
            $char = $licenseNumber[$i];
            if (is_numeric($char)) {
                array_push($realNumber, $char);
                array_push($convertNumber, $char);
            }
        }

        // add space to convert number;
        array_unshift($convertNumber, ' ');
        array_push($convertNumber, ' ');

        // Array To String
        $realNumber = implode('', $realNumber);
        $convertNumber = implode('', $convertNumber);


        if (str_contains($licenseNumber, $realNumber)) {
            $licenseNumber = str_replace($realNumber, $convertNumber, $licenseNumber);

            if ($licenseNumber[0] === ' ' || ctype_alpha($licenseNumber)) { //user memasukkan angka duluan dan huruf semua
                return false;
            }

            return $licenseNumber;
        }

        return false;
    }

    public function getCar()
    {
        ini_set('memory_limit', '-1');
        $car = new Car();
        $request = Services::request();
        $status = $this->request->getPost('status');
        $brandId = $this->request->getPost('brandId');
        $sales = $this->request->getPost('sales');
        $keywords = $this->request->getPost('keyword');
        $keyword = null;
        if ($keywords != null) {
            $keyword = [
                'license_number' => $car->formatLicenseNumber($keywords),
                'car_name' => $keywords,
                'car_status' => 0, //Ready Car
            ];
        }

        $carModel = new DataTableCarModel($request);
        if ($request->getMethod(true) == 'POST') {
            $cars = $carModel->get_datatables($status, $brandId, $keyword);
            $data = [];
            // Menu Mobil
            if ($sales == null) {
                foreach ($cars as $car) {
                    // Total Additional Cost
                    $totalAdditionalCost = $this->CarModel->getTotalAdditionalCost($car->id);

                    // Row Table
                    $row = [];
                    $urlDetail = base_url('mobil/'.$car->id);
                    $row[] = "<div class=\"d-flex align-items-center\">
                    <!--begin::Thumbnail-->
                    <div class=\"symbol symbol-50px\">
                        <span class=\"symbol-label\"
                            style=\"background-image:url(data:image/png;base64,$car->car_image);\"></span>
                    </div>
                    <!--end::Thumbnail-->
                    <div class=\"ms-5\">
                        <!--begin::Car details-->
                        <div class=\"d-flex flex-column\">
                            <a href=\"$urlDetail\"
                                class=\"text-gray-800 text-hover-primary mb-1\" target=\"_blank\">$car->car_name</a>
                            <span>$car->brand_name</span>
                        </div>
                        <!--begin::Car details-->
                    </div>
                    </div>";
                    $row[] = $car->car_color;
                    $row[] = $car->car_year;
                    $row[] = $car->license_number;
                    switch ($car->status) {
                        case '0':
                            $row[] = "<span class=\"badge badge-light-success fs-7 fw-bold\">Ready</span>";
                            break;
                        case '1':
                            $row[] = "<span class=\"badge badge-light-danger fs-7 fw-bold\">Sold</span>";
                    }
                    $carPrice = 'Rp '.number_format($car->car_price, '0', ',', '.');
                    $totalCost = 'Rp '.number_format(($car->capital_price + $totalAdditionalCost), '0', ',', '.');
                    $row[] = "<div class=\"text-end\">$totalCost</div>";
                    $row[] = "<div class=\"text-end\">$carPrice</div>";
                    $urlEditGeneral = base_url().'/mobil/'.$car->id.'/umum';
                    $row[] = "<div class=\"d-flex justify-content-end flex-shrink-0\">
                    <a href=\"$urlEditGeneral\" target=_blank class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1\">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class=\"svg-icon svg-icon-3\">
                            <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                                xmlns=\"http://www.w3.org/2000/svg\">
                                <path
                                    d=\"M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z\"
                                    fill=\"currentColor\"></path>
                                <path opacity=\"0.3\"
                                    d=\"M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z\"
                                    fill=\"currentColor\"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <button class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm\" onclick=\"alertCarDelete('$car->id')\">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                        <span class=\"svg-icon svg-icon-3\">
                            <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
                                xmlns=\"http://www.w3.org/2000/svg\">
                                <path
                                    d=\"M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z\"
                                    fill=\"currentColor\"></path>
                                <path opacity=\"0.5\"
                                    d=\"M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z\"
                                    fill=\"currentColor\"></path>
                                <path opacity=\"0.5\"
                                    d=\"M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z\"
                                    fill=\"currentColor\"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>";

                    $data[] = $row;
                }
            } else { //Menu penjualan mobil
                foreach ($cars as $car) {
                    // Row Table
                    $row = [];
                    $row[] = "<div class=\"d-flex align-items-center\">
                    <!--begin::Thumbnail-->
                    <div class=\"symbol symbol-50px\">
                        <span class=\"symbol-label\"
                            style=\"background-image:url(data:image/png;base64,$car->car_image);\"></span>
                    </div>
                    <!--end::Thumbnail-->
                    <div class=\"ms-5\">
                        <!--begin::Car details-->
                        <div class=\"d-flex flex-column\">
                            <a href=\"#\"
                                class=\"text-gray-800 text-hover-primary mb-1\" target=\"_blank\">$car->car_name</a>
                            <span>$car->license_number</span>
                        </div>
                        <!--begin::Car details-->
                    </div>
                    </div>";
                    $carPrice = 'Rp '.number_format($car->car_price, '0', ',', '.');
                    $row[] = "<div class=\"text-end\">$carPrice</div>";
                    $row[] = "<div class=\"text-end\"> <button class=\"btn btn-icon btn-bg-light btn-active-color-primary btn-sm\" onclick=\"selectItem('$car->license_number')\">
                    <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/arrows/arr012.svg-->
                    <span class=\"svg-icon svg-icon-muted svg-icon-3\"><svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path opacity=\"0.3\" d=\"M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z\" fill=\"currentColor\"/>
                    <path d=\"M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z\" fill=\"currentColor\"/>
                    </svg>
                    </span>
                    <!--end::Svg Icon-->
                    </button></div>";

                    $data[] = $row;
                }
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $carModel->count_all($status, $brandId, $keyword),
                "recordsFiltered" => $carModel->count_filtered($status, $brandId, $keyword),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function detail($id, $print = false)
    {
        ini_set('memory_limit', '-1');
        $car = $this->CarModel->find($id);
        if ($car != null) {
            $car->car_brand = $this->CarModel->checkBrand($car->brand_id);
            $car->totalAdditionalCost = $this->CarModel->getTotalAdditionalCost($car->id);

            $data = [
                'title' => $car->car_name .' | '. 'Renufus',
                'car' => $car,
                'print' => false,
                'additionalCosts' => $this->CarModel->getAdditionalCost($car->id),
            ];
            if ($print != false) {
                $data['print'] = true;
                return view('Car/Detail/Print/index', $data);
            }
            return view('Car/Detail/index', $data);
        }
        return redirect()->to(base_url('mobil'));
    }

    public function printDetail($id)
    {
        $car = $this->CarModel->find($id);
        if ($car != null) {
            $html = $this->detail($id, true);
            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream($car->car_name.'.pdf', [
                'Attachment' => false,
            ]);
        } else {
            return redirect()->to(base_url('mobil'));
        }
    }

    public function alertCarDelete()
    {
        if ($this->request->isAJAX()) {
            $carId = $this->request->getPost('carId');
            $car = $this->CarModel->find($carId);

            $isEmpty = ($car == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $response = [
                'carName' => $car->car_name,
            ];

            return json_encode($response);
        }
    }

    public function deleteCar()
    {
        if ($this->request->isAJAX()) {
            $carId = $this->request->getPost('carId');
            $car = $this->CarModel->find($carId);

            $isEmpty = ($car == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $this->CarModel->delete($car->id);

            $response['success'] = 'Berhasil menghapus mobil';
            return json_encode($response);
        }
    }

    public function setTempAdditionalCost()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'cost_name' => 'required|alpha_numeric_space',
                'additional_price' => 'required|numeric',
                'additional_receipt' => 'max_size[additional_receipt,5120]|is_image[additional_receipt]|mime_in[additional_receipt,image/jpg,image/jpeg,image/png]',
                'paid_by' => 'required|in_list[Sam un, Hereansyah]',
            ];

            $validationMessages = [
                'cost_name' => [
                    'required' => 'Nama pengeluaran tidak boleh kosong.',
                    'alpha_numeric_space' => 'Nama pengeluaran hanya boleh angka atau huruf',
                ],
                'additional_price' => [
                    'required' => 'Jumlah pengeluaran tidak boleh kosong',
                    'numeric' => 'Jumlah pengeluaran hanya boleh angka',
                ],
                'additional_receipt' => [
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 5 MB',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ],
                'paid_by' => [
                    'required' => 'Pembayaran tidak boleh kosong.',
                    'in_list' => 'Pembayaran yang anda pilih, tidak ada didalam list',
                ],
            ];

            $input = [
                'cost_name' => $this->request->getPost('cost_name'),
                'additional_price' => str_replace([',','.','Rp '], '', $this->request->getPost('additional_price')),
                'additional_receipt' => $this->request->getFile('additional_receipt'),
                'paid_by' => $this->request->getPost('paid_by'),
                'temp_session' => $this->request->getPost('temp_session'),
            ];

            // Validation
            $isValid = $this->validateData($input, $validationRules, $validationMessages);
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'errorMsg' => 'Gagal menyimpan pengeluaran',
                ];
                return json_encode($response);
            }

            // Additional Receipt
            $additionalReceipt = null;
            if ($input['additional_receipt']->getError() != 4) {
                $additionalReceipt = $this->blobImage($input['additional_receipt']);
            }

            // Insert to Database
            $data = [
                'cost_name' => ucfirst(strtolower($input['cost_name'])),
                'additional_price' => $input['additional_price'],
                'additional_receipt' => $additionalReceipt,
                'paid_by' => $input['paid_by'],
                'user_id' => user()->id,
                'temp_session' => $input['temp_session'],
            ];
            $this->CarModel->setTempAdditionalCost($data);

            $response['success'] = 'Berhasil menambahkan pengeluaran';
            return json_encode($response);
        }
    }

    public function getTempAdditionalCost()
    {
        if ($this->request->isAJAX()) {
            $tempSession = $this->request->getPost('temp_session');
            $data = [
                'additionalCosts' => $this->CarModel->getTempAdditionalCost(user()->id, null, $tempSession),
            ];
            $response = [
                'additionalCostTable' => view('Car/SetCar/Table/additionalCostTable', $data),
            ];
            return json_encode($response);
        }
    }

    public function getTempAdditionalCostById($tempId, $tempSession)
    {
        $tempAdditionalCost = $this->CarModel->getTempAdditionalCost(user()->id, $tempId, $tempSession);
        if ($tempAdditionalCost != null) {
            return $tempAdditionalCost;
        }
        return false;
    }

    public function downloadAdditionalReceipt()
    {
        if ($this->request->isAJAX()) {
            $additionalId = $this->request->getPost('additionalId');
            $additionalCost = $this->CarModel->getAdditionalCost(null, $additionalId);

            $isEmpty = ($additionalCost == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $response['success'] = 'Berhasil mendownload image';
            $response['blobBase64'] = $additionalCost->additional_receipt;
            $response['fileName'] = $additionalCost->cost_name;
            return json_encode($response);
        }
    }

    public function downloadTempAdditionalReceipt()
    {
        if ($this->request->isAJAX()) {
            $tempId = $this->request->getPost('tempId');
            $tempSession = $this->request->getPost('temp_session');

            $tempAdditionalCost = $this->getTempAdditionalCostById($tempId, $tempSession);

            $isEmpty = ($tempAdditionalCost == null || $tempAdditionalCost->additional_receipt == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $response['success'] = 'Berhasil mendownload image';
            $response['blobBase64'] = $tempAdditionalCost->additional_receipt;
            $response['fileName'] = $tempAdditionalCost->cost_name;
            return json_encode($response);
        }
    }

    public function getTotalTempAdditionalCost()
    {
        if ($this->request->isAJAX()) {
            $tempSession = $this->request->getPost('temp_session');
            $totalTempAdditionalCost = 'Rp '.number_format($this->CarModel->getTotalTempAdditionalCost(user()->id, $tempSession), '0', ',', '.');

            $response = [
                'totalTempAdditionalCost' => $totalTempAdditionalCost,
            ];

            return json_encode($response);
        }
    }

    public function alertTempAdditionalCostDelete()
    {
        if ($this->request->isAJAX()) {
            $tempId = $this->request->getPost('tempId');
            $tempSession = $this->request->getPost('temp_session');
            $tempAdditionalCost = $this->getTempAdditionalCostById($tempId, $tempSession);

            $isEmpty = ($tempAdditionalCost == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $response = [
                'costName' => $tempAdditionalCost->cost_name,
            ];

            return json_encode($response);
        }
    }

    public function deleteTempAdditionalCost()
    {
        if ($this->request->isAJAX()) {
            $tempId = $this->request->getPost('tempId');
            $tempSession = $this->request->getPost('temp_session');
            $tempAdditionalCost = $this->getTempAdditionalCostById($tempId, $tempSession);

            $isEmpty = ($tempAdditionalCost == null);
            if ($isEmpty) {
                $response = [
                    'error' => 'Data tidak ditemukan',
                ];
                return json_encode($response);
            }

            $this->CarModel->deleteTempAdditionalCost(user()->id, $tempId);

            $response['success'] = 'Berhasil menghapus pengeluaran tambahan';
            return json_encode($response);
        }
    }

    public function resetTempAdditionalCost()
    {
        $tempSession = $this->request->getPost('temp_session');
        $additionalCosts = $this->CarModel->getTempAdditionalCost(user()->id, null, $tempSession);

        if ($additionalCosts != null) {
            foreach ($additionalCosts as $additionalCost) {
                $this->CarModel->deleteTempAdditionalCost(user()->id, $additionalCost->id);
            }

            $response['success'] = 'Berhasil menghapus semua pengeluaran tambahan';
            return json_encode($response);
        }
        $response['error'] = 'Tidak ada data yang dihapus';
        return json_encode($response);
    }

    public function findCarReady($keyword)
    {
        $licenseNumber = $this->formatLicenseNumber($keyword);

        return $this->CarModel->findCarReady($keyword, $licenseNumber);
    }
}
