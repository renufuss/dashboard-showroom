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
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="m-0">Penjualan</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0" style="overflow-x:auto;">
                    <!--begin::Table-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="date">Tanggal</label>
                                    <input type="date" class="form-control mb-2" name="date" id="date" readonly
                                        value="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="keyword">Pencarian</label>
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control mb-2" name="keyword" id="keyword"
                                            autocomplete="off">
                                        <div class="input-group-append">
                                            <button class="btn btn-icon btn-bg-light btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#modalProduk">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                            height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </div>
                                    </div>
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Nama atau plat nomor mobil</div>
                                    <!--end::Description-->
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">

                            <div class="col-md-10 mb-2">
                                <div class="form-group">
                                    <label class="form-label" for="jml">Total Bayar</label>
                                    <input type="text" class="form-control" name="totalbayar" id="totalbayar"
                                        style="text-align: right; color:blue; font-weight : bold;" value="0" readonly>
                                </div>
                            </div>

                            <div class="col-md-2 text-end">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal">Aksi</label>
                                    <div>
                                        <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                                            onclick="alertDeleteTempAdditionalCost('2');return false;">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                        fill="currentColor"></path>
                                                    <path opacity="0.5"
                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                        fill="currentColor"></path>
                                                    <path opacity="0.5"
                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <button class="btn btn-icon btn-bg-light btn-active-color-success btn-sm"
                                            onclick="alertDeleteTempAdditionalCost('2');return false;">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/ecommerce/ecm002.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-3"><svg width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.3"
                                                            d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.3"
                                                            d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 dataDetailPenjualan">

                            </div>
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- temporary Modal -->
<?php include('Modal/car.php') ?>


<script>
    function checkLicenseNumber() {
        let kode = $('#kodebarcode').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= base_url('kasir/viewDataBarang') ?>",
                dataType: 'json',
                success: function (response) {
                    $('.viewmodal').html(response.viewmodal).show();

                    $('#modalProduk').modal('show');
                },
                error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                },
            })
        } else {
            $.ajax({
                type: 'post',
                url: "<?= base_url('kasir/simpanTemp') ?>",
                data: {
                    kodebarcode: kode,
                    namaproduk: $('#namaproduk').val(),
                    jumlah: $('#jumlah').val(),
                    nofaktur: $('#nofaktur').val(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response.totaldata == 'banyak') {
                        $.ajax({
                            url: "<?= base_url('kasir/viewDataBarang') ?>",
                            type: 'post',
                            data: {
                                keyword: kode,
                            },
                            dataType: 'json',
                            success: function (response) {
                                $('.viewmodal').html(response.viewmodal).show();

                                $('#modalProduk').modal('show');
                            },
                            error: function (xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            },
                        })
                    }

                    if (response.sukses == 'berhasil') {
                        dataDetailPenjualan();
                        kosong();
                    }

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error..',
                            html: response.error,
                            confirmButtonColor: 'red',
                        })
                        dataDetailPenjualan();
                        kosong();
                    }
                },
                error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                },
            })
        }
    }
</script>


<?= $this->endSection(); ?>