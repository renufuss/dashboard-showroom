<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModal" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="formPayment">
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Nama Lengkap</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="full_name" id="full_name"
                                autocomplete="off" />
                            <div class="invalid-feedback" id="full_name-feedback"></div>
                        </div>
                        <!-- end::col -->
                        <!-- begin::col -->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">NIK</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="identity_id" id="identity_id"
                                autocomplete="off" />
                            <div class="invalid-feedback" id="identity_id-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">No. HP</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="phone_number" id="phone_number"
                                autocomplete="off" />
                            <div class="invalid-feedback" id="phone_number-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Alamat</span>
                            </label>
                            <!--end::Label-->
                            <textarea class="form-control form-control-solid" name="address" id="address" ></textarea>
                            <div class="invalid-feedback" id="address-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">KTP</span>
                            </label>
                            <!--end::Label-->
                            <input type="file" id="identity_card" name="identity_card" class="form-control mb-2" />
                            <div class="invalid-feedback" id="identity_card-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Diskon</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="discount" name="discount" class="form-control form-control-solid" autocomplete="off" />
                            <div class="invalid-feedback" id="discount-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Total Harga</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="total_price" name="total_price" class="form-control form-control-solid" value="<?= $totalPrice; ?>" readonly/>
                            <div class="invalid-feedback" id="total_price-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Jumlah Uang</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="amount_of_money" name="amount_of_money" class="form-control form-control-solid" autocomplete="off"/>
                            <div class="invalid-feedback" id="amount_of_money-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-2">
                        <!-- begin::col -->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Sisa</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="over" name="over" class="form-control form-control-solid" readonly/>
                            <div class="invalid-feedback" id="over-feedback"></div>
                        </div>
                        <!-- end::col -->
                    </div>
                    <!--end::Input group-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button type="button" class="btn btn-primary" id="btnSavePayment">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        autoNumeric();
    });

    function autoNumeric() {
        [discount, amountOfMoney] = AutoNumeric.multiple(['#discount', '#amount_of_money'], {
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

    function setDiscount(){
        $.ajax({
            type: "POST",
            url: "/penjualan/payment/discount",
            data: {
                discount : $('#discount').val(),
            },
            dataType: "json",
            success: function (response) {
                $('#total_price').val(response.totalPrice);
            }
        });
    }

    function setOver(){
        $.ajax({
            type: "POST",
            url: "/penjualan/payment/over",
            data: {
                discount : $('#discount').val(),
                amount_of_money : $('#amount_of_money').val(),
            },
            dataType: "json",
            success: function (response) {
                $('#over').val(response.over);
            }
        });
    }


    $('#discount').on('input',function(e){
        setDiscount();
        setOver();
    });

    $('#amount_of_money').on('input',function(e){
        setOver();
    });

    function savePayment(){
        var form = $("#formPayment")[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        $.ajax({
            type: "post",
            url: "/penjualan/payment",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function () {
                $("#btnSavePayment").prop("disabled", true);
                $("#btnSavePayment").html(`
                <div class="loader">
    			<span class="bar"></span>
    			<span class="bar"></span>
    			<span class="bar"></span>
				</div>`);
            },
            success: function (response) {
                console.log(response);
            }
        });
    }

    $('#btnSavePayment').click(function (e) { 
        e.preventDefault();
        savePayment();
    });
</script>