<?= $this->extend('Car/EditCar/LayoutUpdate/index'); ?>

<?= $this->section('boxBawah'); ?>

<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Detail Profil</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="formSetCar" class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline <?= ($car->car_image == null) ? 'image-input-empty' : ''; ?>"
                            data-kt-image-input="true"
                            style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                            <!--begin::Preview existing avatar-->
                            <?php if ($car->car_image != null) : ?>
                            <div class="image-input-wrapper w-200px h-120px"
                                style="background-image: url(data:image/png;base64,<?= $car->car_image; ?>)">
                            </div>
                            <?php else : ?>
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: none"></div>
                            <?php endif; ?>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" class="is-invalid" name="car_image" id="car_image"
                                    accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="avatar_remove">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div style="color:#F1416C;font-size:12.025px" id="car_image-feedback"></div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>

                        <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="car_name" id="car_name"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="<?= $car->car_name; ?>" autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="car_name-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Plat Nomor</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="license_number" id="license_number"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="<?= $car->license_number; ?>" autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="license_number-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Warna Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="car_color" id="car_color"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="<?= $car->car_color; ?>" autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="car_color-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tahun Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <select class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Tahun"
                                    id="car_year" name="car_year">
                                    <option value="">Pilih Tahun</option>
                                    <?php $firstYear = 1945; ?>
                                    <?php $lastYear = date('Y'); ?>
                                    <?php for($x=$lastYear; $x>=$firstYear; $x--) :?>
                                    <option value="<?= $x; ?>" <?= ($car->car_year == $x) ? 'selected' : ''; ?>>
                                        <?= $x; ?></option>n
                                    <?php endfor; ?>
                                </select>
                                <!--end::Input-->
                                <div class="invalid-feedback" id="car_year-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Brand Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <!--begin::Select2-->
                                <select
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" data-control="select2" data-hide-search="false" data-placeholder="Pilih Brand Mobil"
                                    id="car_brand" name="car_brand">
                                    <option value="">Pilih Brand Mobil</option>
                                    <?php foreach($brands as $brand) : ?>
                                    <option value="<?= $brand->id; ?>"
                                        <?= ($brand->brand_name == $car->car_brand) ? 'selected' : ''; ?>>
                                        <?= $brand->brand_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!--end::Select2-->
                                <div class="invalid-feedback" id="car_brand-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Harga Mobil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="capital_price" id="capital_price"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="<?= 'Rp '.number_format(($car->capital_price), '0', ',', '.'); ?>"
                                    autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="capital_price-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bukti Pembelian</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="file" id="receipt" name="receipt" class="form-control mb-2" />
                                <div class="fv-plugins-message-container invalid-feedback" id="receipt-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <input type="hidden" name="id" id="id" value="<?= $car->id; ?>">
                <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->

<script>
    $(document).ready(function () {
        autoNumeric();

        // load File to Input Form
        loadURLToInputField('data:image/png;base64,<?= $car->car_image; ?>', '#car_image', '<?= $car->car_name; ?>car_image.jpg')
        loadURLToInputField('data:image/png;base64,<?= $car->receipt; ?>', '#receipt', '<?= $car->car_name; ?>_receipt.jpg')
    });

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

    function autoNumeric() {
        capitalPrice = new AutoNumeric(('#capital_price'), {
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
                        location.reload();
                    }, 1200);
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });

    }

    $('#btnSave').click(function (e) {
        e.preventDefault();
        saveCar();
    });

    // load File to Input Form
    function loadURLToInputField(url, idFileInput, fileNames) {
        getImgURL(url, (imgBlob) => {
            // Load img blob to input
            // WIP: UTF8 character error
            let fileName = fileNames
            let file = new File([imgBlob], fileName, {
                type: "image/jpeg",
                lastModified: new Date().getTime()
            }, 'utf-8');
            let container = new DataTransfer();
            container.items.add(file);
            document.querySelector(idFileInput).files = container.files;

        })
    }

    // xmlHTTP return blob respond
    function getImgURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            callback(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }

    //End load File to Input Form
</script>

<?= $this->endSection(); ?>