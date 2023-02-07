<?php echo $this->extend('Car/EditCar/LayoutUpdate/index'); ?>

<?php echo $this->section('boxBawah'); ?>

<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Biaya Tambahan</h3>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <!--begin::Add product-->
            <button type="button" id="btnAddCost" class="btn btn-primary btn-sm">Tambah Biaya</button>
            <!--end::Add product-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <?php require 'Table/additionalCostTable.php'; ?>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->

<div class="additionalCostModal"></div>


<script>
    function openAdditionalCostModal(additionalCostId = null){
        $.ajax({
            type: "post",
            url: "/mobil/biaya/modal",
            data: {
                additionalCostId,
                carId : <?= json_encode($car->id); ?> 
            },
            dataType: "json",
            success: function (response) {
                $('.additionalCostModal').html(response.additionalCostModal).show();

                $('#additionalCostModal').modal('show');
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    $('#btnAddCost').click(function (e) { 
        e.preventDefault();
        openAdditionalCostModal();
    });
</script>

<?php echo $this->endSection(); ?>