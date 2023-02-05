<?php echo $this->extend('Sales/History/Detail/Layout/index'); ?>

<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2><?= $sales->receipt_number; ?></h2>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="#" class="btn btn-primary btn-sm">Tambah Pembayaran</a>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <?php require('Table/paymentTable.php'); ?>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>