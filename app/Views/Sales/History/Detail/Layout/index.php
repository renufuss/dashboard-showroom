<?php echo $this->extend('Layout/index'); ?>


<?php echo $this->section('content'); ?>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <?php require 'Toolbar/toolbar.php'?>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Order details page-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                <?php require 'Navigation/navigation.php'?>
                    <!--begin::Order summary-->
                    <?php require 'OrderSummary/index.php'?>
                    <!--end::Order summary-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <?= $this->renderSection('content'); ?>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Order details page-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>
    <?php echo $this->endSection(); ?>