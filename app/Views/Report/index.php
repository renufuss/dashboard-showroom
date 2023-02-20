<?= $this->extend('Layout/index'); ?>


<?= $this->section('content'); ?>

<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?php require 'Toolbar/toolbar.php' ?>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="nav" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="informationBox">
                <?php require 'InformationBox/informationBox.php'?>
            </div>

            <!-- navigation -->
            <div class="navigation mb-5">
                <?php require 'Navigation/navigation.php'?>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Content-->
    <div id="profitTableContainer" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" id="searchProfit"
                                class="form-control form-control-solid w-xl-250px w-150px ps-14"
                                placeholder="Cari Transaksi" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="profitTable"></div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Content-->
    <div id="refundTableContainer" class="app-content flex-column-fluid d-none">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" id="searchRefund"
                                class="form-control form-control-solid w-xl-250px w-150px ps-14"
                                placeholder="Cari Transaksi" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="refundTable"></div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Content-->
    <div id="generalIncomeTableContainer" class="app-content flex-column-fluid d-none">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" id="searchGeneralIncome"
                                class="form-control form-control-solid w-xl-250px w-150px ps-14"
                                placeholder="Cari Transaksi" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="generalIncomeTable"></div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Content-->
    <div id="generalOutcomeTableContainer" class="app-content flex-column-fluid d-none">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" id="searchGeneralOutcome"
                                class="form-control form-control-solid w-xl-250px w-150px ps-14"
                                placeholder="Cari Transaksi" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="generalOutcomeTable"></div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Content-->
    <div id="generalCalculationContainer" class="app-content flex-column-fluid d-none">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        Perhitungan
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <span>Profit Mobil : <span class="calculationProfit"></span></span><br>
                    <span>Refund : <span class="calculationRefund"></span></span><br>
                    <span>Pemasukan Umum : <span class="calculationGeneralIncome"></span></span><br>
                    <span>Pengeluaran Umum : <span class="calculationGeneralOutcome"></span></span><br>
                    <br>
                    <span>Profit = Profit Mobil + Refund </span><br>
                    <span>Profit = <span class="calculationProfit"></span> + <span
                            class="calculationRefund"></span></span></span><br>
                    <span>Profit = <span class="calculationTotalCar"></span></span><br>
                    <br>
                    <span>Pengeluaran = Pengeluaran Umum - Pemasukan Umum</span><br>
                    <span>Pengeluaran = <span class="calculationGeneralOutcome"></span> - <span
                            class="calculationGeneralIncome"></span><br>
                        <span>Pengeluaran = <span class="calculationGeneral"></span></span><br>
                        <br>
                        <hr>
                        <span>Hasil Pembagian</span><br>
                        <br>
                        <span>Profit</span><br>
                        <span>Persentasi Hereansyah = <span class="calculationPercentHereansyah"></span></span><br>
                        <span>Persentasi Samun = <span class="calculationPercentSamun"></span></span><br>
                        <br>
                        <span>Pengeluaran = Pengeluaran / 2</span><br>
                        <span>Pengeluaran = <span class="calculationGeneral"></span> / 2</span><br>
                        <span>Pengeluaran = <span class="calculationGeneralResult"></span></span><br>
                        <br>
                        <span>Perhitungan</span><br>
                        <span>Hereansyah = (Profit x Persentasi Hereansyah) - Pengeluaran </span><br>
                        <span>Hereansyah = (<span class="calculationProfit"></span> x <span
                                class="calculationPercentHereansyah"></span>) - <span
                                class="calculationGeneralResult"></span> </span><br>
                        <span>Hereansyah = <span class="hereansyah" style="color:orange"></span></span><br>
                        <br>
                        <span>Samun = (Profit x Persentasi Samunn) - Pengeluaran </span><br>
                        <span>Samun = (<span class="calculationProfit"></span> x <span
                                class="calculationPercentSamun"></span>) - <span
                                class="calculationGeneralResult"></span> </span><br>
                        <span>Samun = <span class="samun" style="color:orange"></span></span><br>



                        <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <div id="buttonContainer" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl text-end">
            <button class="btn btn-primary">Claim</button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        profitTable();
        refundTable();
        generalIncomeTable();
        generalOutcomeTable();
        calculationReport();
    });

    function profitTable() {
        $.ajax({
            type: "POST",
            url: "/laporan/profitTable",
            data: {},
            dataType: "json",
            success: function (response) {
                $('.profitTable').html(response.profitTable);
            }
        });
    }

    function refundTable() {
        $.ajax({
            type: "POST",
            url: "/laporan/refundTable",
            data: {},
            dataType: "json",
            success: function (response) {
                $('.refundTable').html(response.refundTable);
            }
        });
    }

    function generalIncomeTable() {
        $.ajax({
            type: "POST",
            url: "/laporan/generalIncomeTable",
            data: {},
            dataType: "json",
            success: function (response) {
                $('.generalIncomeTable').html(response.generalIncomeTable);
            }
        });
    }

    function generalOutcomeTable() {
        $.ajax({
            type: "POST",
            url: "/laporan/generalOutcomeTable",
            data: {},
            dataType: "json",
            success: function (response) {
                $('.generalOutcomeTable').html(response.generalOutcomeTable);
            }
        });
    }

    function hideAllTable() {
        $('#profitTableContainer').addClass('d-none');
        $('#refundTableContainer').addClass('d-none');
        $('#generalIncomeTableContainer').addClass('d-none');
        $('#generalOutcomeTableContainer').addClass('d-none');
        $('#generalCalculationContainer').addClass('d-none');

        $('#navCar').removeClass('active');
        $('#navRefund').removeClass('active');
        $('#navGeneralIncome').removeClass('active');
        $('#navGeneralOutcome').removeClass('active');
        $('#navCalculation').removeClass('active');
    }

    function openTable(tableContainer, buttonName, tableId, searchBoxId) {
        hideAllTable();

        $(`#${tableContainer}`).removeClass('d-none');
        $(`#${buttonName}`).addClass('active');

        dataTable(tableId, searchBoxId)
    }

    function dataTable(tableId, searchBoxId) {
        const table = $(`#${tableId}`).DataTable({
            "aaSorting": [],
            "scrollX": true,
            "destroy": true,
            "responsive": true,
            'columnDefs': [{
                    'responsivePriority': 1,
                    'targets': 1
                },
                {
                    'responsivePriority': 2,
                    'targets': -1
                }
            ],
        });

        $(`#${searchBoxId}`).on('keyup', function () {
            table.search(this.value).draw();
        });
    }

    function calculationReport() {
        $.ajax({
            type: "post",
            url: "/laporan/calculation",
            data: {},
            dataType: "json",
            success: function (response) {
                $('#carBox').html(response.totalCar);
                $('#generalBox').html(response.totalGeneral);
                $('#hereansyahBox').html(response.hereansyah);
                $('#samunBox').html(response.samun);

                $('.calculationProfit').html(response.totalProfit);
                $('.calculationRefund').html(response.totalRefund);
                $('.calculationTotalCar').html(response.totalCar);
                $('.calculationGeneralIncome').html(response.totalGeneralIncome);
                $('.calculationGeneralOutcome').html(response.totalGeneralOutcome);
                $('.calculationGeneral').html(response.totalGeneral);
                $('.calculationPercentHereansyah').html(response.percentHereansyah);
                $('.calculationPercentSamun').html(response.percentSamun);
                $('.calculationGeneralResult').html(response.totalGeneralResult);
                $('.hereansyah').html(response.hereansyah);
                $('.samun').html(response.samun);
            }
        });
    }
</script>


<?= $this->endSection(); ?>