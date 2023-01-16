<?= $this->extend('Layout/index'); ?>


<?= $this->section('content'); ?>


<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?php include('Toolbar/toolbar.php') ?>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form id="formSetCar" class="form d-flex flex-column flex-lg-row">
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Foto</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <img class="image-input-wrapper w-200px"
                                    src="data:image/png;base64,<?= $car->car_image; ?>" alt="Car Image">
                                <!--end::Preview existing avatar-->
                            </div>
                            <div class="text-muted fs-7">Foto Mobil</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Thumbnail settings-->
                    <!--begin::Status-->
                    <div class="card card-flush py-4">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Year-->
                            <!--begin::Input group-->
                            <div class="fv-row mt-3">
                                <!--begin::Label-->
                                <label class="required form-label">Tahun Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_year" id="car_year" class="form-control mb-2"
                                    autocomplete="off" value="<?= $car->car_year; ?>" readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_year-feedback"></div>
                            </div>
                            <!--end::Input group-->
                            <!--end::Year-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Status-->
                    <!--begin::Template settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mt-3 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Brand Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_brand" id="car_brand" class="form-control mb-2"
                                    autocomplete="off" value="<?= $car->car_brand; ?>" readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_brand-feedback"></div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Template settings-->
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Umum</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="form-label">Nama Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_name" id="car_name" class="form-control mb-2"
                                    autocomplete="off" value="<?= $car->car_name; ?>" readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_name-feedback"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="form-label">Plat Nomor</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="license_number" id="license_number" class="form-control mb-2"
                                    autocomplete="off" value="<?= $car->license_number; ?>" readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="license_number-feedback"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="form-label">Warna Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_color" id="car_color" class="form-control mb-2"
                                    autocomplete="off" value="<?= $car->car_color; ?>" readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_color-feedback"></div>
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <!--begin::Harga & Bukti Pembelian-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Harga & Bukti Pembelian</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label">Harga Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control mb-2" name="capital_price" id="capital_price"
                                    autocomplete="off"
                                    value="<?= 'Rp '.number_format(($car->capital_price), '0', ',', '.'); ?>"
                                    readonly />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="capital_price-feedback"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Bukti Pembelian</label>
                                <!--end::Label-->
                                <!--begin::Receipt-->
                                <div class="col-12">
                                    <img class="image-input-wrapper w-300px"
                                        src="data:image/png;base64,<?= $car->receipt; ?>" alt="Car Image">
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Harga & Bukti Pembelian-->
                    <!--begin::Pengeluaran Tambahan-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Pengeluaran Tambahan</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <?php include('Table/additionalCostTable.php'); ?>
                            <div class="row mt-5">
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="totalTempAdditionalCost">Total Pengeluaran Tambahan</label>
                                        <input type="text" class="form-control form-control-lg"
                                            style="text-align: right; color:black; font-weight : bold; font-size:12pt;"
                                            value="<?= 'Rp '.number_format(($car->totalAdditionalCost), '0', ',', '.'); ?>" id="totalTempAdditionalCost" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Pengeluaran Tambahan-->
                    <!--begin::Total Tambahan-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Total Pengeluaran</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="totalTempAdditionalCost">Total Pengeluaran (Harga Mobil + Pengeluaran Tambahan)</label>
                                        <input type="text" class="form-control form-control-lg"
                                            style="text-align: right; color:blue; font-weight : bold; font-size:12pt;"
                                            value="<?= 'Rp '.number_format(($car->totalAdditionalCost + $car->capital_price), '0', ',', '.'); ?>" id="totalTempAdditionalCost" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Total Tambahan-->
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<?= $this->endSection(); ?>