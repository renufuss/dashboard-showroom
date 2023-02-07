<?= $this->extend('Layout/index'); ?>


<?= $this->section('content'); ?>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
        <?php include('navbar.php'); ?>
        <!--end::Navbar-->
        <!--begin::details View-->
        <?= $this->renderSection('boxBawah'); ?>
        <!--end::details View-->
    </div>
    <!--end::Content container-->
</div>



<?= $this->endSection(); ?>