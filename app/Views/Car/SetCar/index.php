<?php echo $this->extend('Layout/index'); ?>


<?php echo $this->section('content'); ?>


<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?php require 'Toolbar/toolbar.php' ?>
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
                            <!--begin::Image input placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url('assets/media/svg/files/blank-image.svg');
                                }

                                [data-theme="dark"] .image-input-placeholder {
                                    background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                }
                            </style>
                            <!--end::Image input placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                    <!--begin::Icon-->
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--end::Icon-->
                                    <!--begin::Inputs-->
                                    <input type="file" name="car_image" id="car_image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Remove Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <div style="color:#F1416C;font-size:12.025px" id="car_image-feedback"></div>
                            <!--begin::Description-->
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
                                <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Tahun" id="car_year" name="car_year">
                                    <option value="">Pilih Tahun</option>
                                    <?php $firstYear = 1945; ?>
                                    <?php $lastYear = date('Y'); ?>
                                    <?php for($x=$lastYear; $x>=$firstYear; $x--) :?>
                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>n
                                    <?php endfor; ?>
                                </select>
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
                                <!--begin::Select2-->
                                <select class="form-select mb-2" data-control="select2" data-hide-search="false"
                                    data-placeholder="Pilih Brand Mobil" id="car_brand" name="car_brand">
                                    <option value="">Pilih Brand Mobil</option>
                                    <?php foreach($brands as $brand) : ?>
                                    <option value="<?php echo $brand->id; ?>"><?php echo $brand->brand_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!--end::Select2-->
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
                                <label class="required form-label">Nama Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_name" id="car_name" class="form-control mb-2"
                                    autocomplete="off" />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_name-feedback"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Plat Nomor</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="license_number" id="license_number" class="form-control mb-2"
                                    autocomplete="off" />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="license_number-feedback"></div>
                                <div class="text-muted fs-7">Pastikan plat nomor sama seperti di STNK</div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Warna Mobil</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_color" id="car_color" class="form-control mb-2"
                                    autocomplete="off" />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_color-feedback"></div>
                                <div class="text-muted fs-7">Pastikan warna sama seperti di STNK</div>
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
                                <h2>Harga Beli & Bukti Pembelian</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label required">Harga Beli</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control mb-2" name="capital_price" id="capital_price"
                                    autocomplete="off" />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="capital_price-feedback"></div>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Pastikan angka sesuai dengan kuitansi pembelian</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label required">Bukti Pembelian</label>
                                <!--end::Label-->
                                <!--begin::Receipt-->
                                <input type="file" id="receipt" name="receipt" class="form-control mb-2" />
                                <!--end::Receipt-->
                                <div class="invalid-feedback" id="receipt-feedback"></div>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Bukti pembelian bisa berupa kuitansi pembelian</div>
                                <!--end::Description-->
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
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label">Nama Pengeluaran</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="cost_name" id="cost_name" class="form-control mb-2"
                                            autocomplete="off" />
                                        <div class="invalid-feedback" id="cost_name-feedback"></div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label">Jumlah Pengeluaran</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="additional_price" id="additional_price"
                                            class="form-control mb-2" autocomplete="off" />
                                        <div class="invalid-feedback" id="additional_price-feedback"></div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <div class="row">
                                <!--begin::Input group-->
                                <div class="col-xl-6 mb-5">
                                    <!--begin::Label-->
                                    <label class="form-label">Bukti Pengeluaran Tambahan</label>
                                    <!--end::Label-->
                                    <!--begin::Receipt-->
                                    <input type="file" id="additional_receipt" name="additional_receipt"
                                        class="form-control mb-2" />
                                    <!--end::Receipt-->
                                    <div class="invalid-feedback" id="additional_receipt-feedback"></div>
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Bukti pengeluaran tambahan bisa berupa kuitansi</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="col-xl-6 mb-5">
                                    <!--begin::Label-->
                                    <label class="form-label">Pengeluaran</label>
                                    <!--end::Label-->
                                    <!--begin::Receipt-->
                                    <!--begin::Select2-->
                                    <select class="form-select mb-2" data-control="select2" data-hide-search="false"
                                        data-placeholder="Pilih Pembayaran" id="paid_by" name="paid_by">
                                        <option value="">Pilih Pembayaran</option>
                                        <option value="Sam un">Sam un</option>
                                        <option value="Hereansyah">Hereansyah</option>
                                    </select>
                                    <!--end::Select2-->
                                    <!--end::Receipt-->
                                    <div class="invalid-feedback" id="paid_by-feedback"></div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="click" id="btnResetTempAdditionalCost"
                                        class="btn btn-sm btn-light btn-active-light-warning me-5">Reset</button>
                                    <button type="click" id="btnSaveTempAdditionalCost"
                                        class="btn btn-light-primary">Tambah Pengeluaran</button>
                                        <input type="hidden" name="temp_session" id="temp_session">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 additionalCostTable" style="word-wrap: break-word; overflow-x:auto;">
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="totalTempAdditionalCost">Total Biaya</label>
                                        <input type="text" class="form-control form-control-lg"
                                            style="text-align: right; color:orange; font-weight : bold; font-size:18pt;"
                                            value="0" id="totalTempAdditionalCost" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Pengeluaran Tambahan-->
                    <!--begin::Harga Pokok Penjualan-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Harga Pokok Penjualan</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label required">Harga Jual</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control mb-2" name="car_price" id="car_price"
                                    autocomplete="off" />
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_price-feedback"></div>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Harga pokok penjualan mobil</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Harga Pokok Penjualan-->

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="<?php echo base_url('mobil'); ?>" class="btn btn-sm btn-light btn-active-light-primary me-5"
                            style="border: 1px solid">Batal</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="btnSave" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                        <!--end::Button-->
                    </div>
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

<script>

    //sessionStorage TAB  
    if (!sessionStorage.tab) {
        sessionStorage.tab = generateString(32);
    }
    $(document).ready(function () {
        getTempAdditionalCost();
        getTotalTempAdditionalCost();
        autoNumeric();
    });

    function generateString(length) {
        const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = ' ';
        const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }

    function autoNumeric() {
        [additionalPrice, capitalPrice, carPrice] = AutoNumeric.multiple(['#additional_price', '#capital_price', '#car_price'], {
            digitGroupSeparator: '.',
            decimalPlaces: 0,
            decimalCharacter: ',',
            decimalCharacterAlternative: ',',
            currencySymbol: 'Rp ',
            minimumValue: 0,
            modifyValueOnWheel: false,
            currencySymbolPlacement: AutoNumeric.options.currencySymbolPlacement.prefix,
        });
    }

    function toastConfig() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    }

    function removeFeedback(form) {
        Object.entries(form).forEach(entry => {
            const [key, value] = entry;
            $(`#${key}`).removeClass('is-invalid');
            $(`#${key}-feedback`).html('');
        });

        return true;
    }

    function addFeedback(responseError) {
        Object.entries(responseError).forEach(entry => {
            const [key, value] = entry;
            $(`#${key}`).addClass('is-invalid');
            $(`#${key}-feedback`).html(value);
        });
    }

    function setTempAdditionalCost() {
        $('#temp_session').val(sessionStorage.tab);
        var form = $("#formSetCar")[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        $.ajax({
            type: "post",
            url: "/mobil/tambah/temp/save",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function () {
                $("#btnSaveTempAdditionalCost").prop("disabled", true);
                $("#btnSaveTempAdditionalCost").html(`
                <div class="loader">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </div>`);
            },
            complete: function () {
                $("#btnSaveTempAdditionalCost").prop("disabled", false);
                $("#btnSaveTempAdditionalCost").html("Tambah Pengeluaran");
            },
            success: function (response) {
                toastConfig();
                // Remove Feedback
                form = {
                    cost_name,
                    additional_price,
                    additional_receipt,
                    paid_by,
                };
                removeFeedback(form);

                if (response.error) {
                    // Add Feedback
                    addFeedback(response.error);
                    toastr.error(response.errorMsg, "Error");
                }

                if (response.success) {
                    $('#cost_name').val('');
                    additionalPrice.clear();
                    $('#additional_receipt').val('');
                    getTempAdditionalCost();
                    getTotalTempAdditionalCost();
                    toastr.success(response.success, "Sukses");
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });

    }

    function saveCar() {
        var form = $("#formSetCar")[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        $.ajax({
            type: "post",
            url: "/mobil/save",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function () {
                $("#btnSave").prop("disabled", true);
                $("#btnSave").html(`
                <div class="loader">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </div>`);
            },
            complete: function () {
                $("#btnSave").prop("disabled", false);
                $("#btnSave").html("Simpan");
            },
            success: function (response) {
                toastConfig();

                // Remove Feedback
                form = {
                    car_image,
                    car_year,
                    car_name,
                    license_number,
                    car_color,
                    capital_price,
                    receipt,
                    car_brand,
                };
                removeFeedback(form);

                if (response.error) {
                    // Add Feedback
                    addFeedback(response.error);
                    toastr.error(response.errorMsg, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    setTimeout(function () {
                        window.location = "/mobil";
                    }, 1200);
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });

    }

    function getTempAdditionalCost() {
        $.ajax({
            type: "post",
            url: "/mobil/tambah/temp",
            data: {
                temp_session:sessionStorage.tab,
            },
            dataType: "json",
            beforeSend: function () {
                $("#additionalCostTable").html(`
                <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
                    <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                </svg>
                `);
            },
            success: function (response) {
                $('.additionalCostTable').html(response.additionalCostTable);
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    function getTotalTempAdditionalCost() {
        $.ajax({
            type: "post",
            url: "/mobil/tambah/temp/totalAdditionalCost",
            data: {
                temp_session : sessionStorage.tab,
            },  
            dataType: "json",
            beforeSend: function () {
                $('#totalTempAdditionalCost').val(0);
            },
            success: function (response) {
                $('#totalTempAdditionalCost').val(response.totalTempAdditionalCost);
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    function alertDeleteTempAdditionalCost(tempId) {
        $.ajax({
            type: "POST",
            url: "/mobil/tambah/temp/alertTempDelete",
            data: {
                tempId
            },
            dataType: "json",
            success: function (response) {
                if (!response.error) {
                    Swal.fire({
                        html: `Apakah kamu yakin ingin menghapus ${response.costName} ?`,
                        icon: "warning",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Iya, Hapus",
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteTempAdditionalCost(tempId);
                        }
                    });
                } else {
                    toastConfig();
                    toastr.error(response.error, "Error");
                }
            }
        });
    }

    function deleteTempAdditionalCost(tempId) {
        $.ajax({
            type: "post",
            url: "/mobil/tambah/temp/delete",
            data: {
                tempId : tempId,
                temp_session : sessionStorage.tab,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    getTempAdditionalCost();
                    getTotalTempAdditionalCost();
                }
            }
        });
    }

    function alertResetTempAdditionalCost() {
        Swal.fire({
            html: `Apakah kamu yakin ingin menghapus semua pengeluaran tambahan ?`,
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Iya, Hapus",
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: 'btn btn-danger'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                resetTempAdditionalCost();
            }
        });
    }

    function resetTempAdditionalCost() {
        $.ajax({
            type: "post",
            url: "/mobil/tambah/temp/reset",
            data:{
                temp_session : sessionStorage.tab,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    getTempAdditionalCost();
                    getTotalTempAdditionalCost();
                }
            }
        });
    }

    $('#btnResetTempAdditionalCost').click(function (e) {
        e.preventDefault();
        alertResetTempAdditionalCost();
    });

    $('#btnSave').click(function (e) {
        e.preventDefault();
        saveCar();
    });

    $('#btnSaveTempAdditionalCost').click(function (e) {
        e.preventDefault();
        setTempAdditionalCost();
    });
</script>

<?php echo $this->endSection(); ?>
