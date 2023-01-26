<?= $this->extend('Car/EditCar/LayoutUpdate/index'); ?>

<?= $this->section('boxBawah'); ?>

<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Biaya Tambahan</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
            <?php include 'Table/additionalCostTable.php'; ?>
            </div>
            <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->

<?= $this->endSection(); ?>