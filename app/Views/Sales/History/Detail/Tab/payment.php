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
                    <button type="button" id="btnAddPayment" class="btn btn-primary btn-sm">Tambah Pembayaran</button>
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

<div class="addPaymentModal"></div>

<script>
    function toastConfig() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    }

    $('#btnAddPayment').click(function (e) {
        e.preventDefault();
        openAddPaymentModal();
    });

    function openAddPaymentModal() {
        $.ajax({
            type: "post",
            url: "/penjualan/riwayat/<?= $sales->receipt_number; ?>/pembayaran/add",
            data: {},
            dataType: "json",
            success: function (response) {
                $('.addPaymentModal').html(response.addPaymentModal).show();

                $('#addPaymentModal').modal('show');
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }
</script>

<?php echo $this->endSection(); ?>