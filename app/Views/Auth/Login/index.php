<?= $this->extend('Auth/Layout/index'); ?>


<?= $this->section('main'); ?>
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Logo-->
        <a href="<?= base_url('login'); ?>" class="d-block d-lg-none mx-auto py-20">
        <img alt="Logo" src="<?= base_url(); ?>/assets/media/logo/logo.png" class="theme-light-show h-100px" />
            <img alt="Logo" src="<?= base_url(); ?>/assets/media/logo/logo.png" class="theme-dark-show h-100px" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <!--begin::Wrapper-->
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Header-->
                <div class="d-flex flex-stack py-2">
                    <!--begin::Back link-->
                    <div class="me-2"></div>
                    <!--end::Back link-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="py-0">
                    <!--begin::Form-->
                    <?php include('Form/form.php'); ?>
                    <!--end::Form-->
                </div>
                <!--end::Body-->

<?= $this->endSection(); ?>