<?php echo $this->extend('Sales/History/Detail/Layout/index'); ?>

<?php echo $this->section('content'); ?>
<div class="tab-pane fade show active" id="" role="tab-panel">
    <!--begin::Orders-->
    <div class="row">
        <div class="col-xl-12 mb-7">
            <!--begin::Payment address-->
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <!--begin::Background-->
                <div class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                    <img src="assets/media/icons/duotune/ecommerce/ecm001.svg" class="w-175px" />
                </div>
                <!--end::Background-->
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Alamat</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0"><?= $sales->address; ?></div>
                <!--end::Card body-->
            </div>
            <!--end::Payment address-->
        </div>
        <div class="col-xl-12 mb-7">
            <!--begin::Shipping address-->
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <!--begin::Background-->
                <div class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                    <img src="assets/media/icons/duotune/ecommerce/ecm006.svg" class="w-175px" />
                </div>
                <!--end::Background-->
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>KTP</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="col-12">
                        <img class="image-input-wrapper w-300px"
                            src="data:image/png;base64,<?= $sales->identity_card; ?>" alt="Car Image">
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Shipping address-->
            </div>
            <!--begin::Product List-->
        </div>
        <div class="col-12">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2><?= $sales->receipt_number; ?></h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <?php require('Table/carTable.php'); ?>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
    <!--end::Product List-->
</div>
<?php echo $this->endSection(); ?>