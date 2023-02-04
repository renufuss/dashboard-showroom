<?php echo $this->extend('Layout/index'); ?>


<?php echo $this->section('content'); ?>

<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?php require 'Toolbar/toolbar.php' ?>
    <!--end::Toolbar-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <?php require 'navbar.php'; ?>
            <!--end::Navbar-->
            <!--begin::details View-->
            <?php echo $this->renderSection('boxBawah'); ?>
            <!--end::details View-->
        </div>
        <!--end::Content container-->
    </div>
</div>



<?php echo $this->endSection(); ?>
