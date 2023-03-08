<?= $this->extend('User/Detail/LayoutDetail/index'); ?>

<?= $this->section('boxBawah'); ?>

<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Saldo Akun</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Saldo</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo 'Rp '.number_format($userBalance, '0', ',', '.'); ?></span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                 <!--begin::Row-->
                 <div class="row mb-7">
                    <div class="walletTable"><?php include('Table/walletTable.php') ?></div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Card body-->
           
        </div>



<?= $this->endSection(); ?>