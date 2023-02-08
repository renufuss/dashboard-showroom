<style>

td, th {
  margin: 0;
  border: 0px solid grey;
  white-space: nowrap;
  border-top-width: 0px;
}

</style>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="salesTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-200px">Tanggal</th>
            <th class="min-w-200px">Keterangan</th>
            <th class="text-center">Bukti Pembayaran</th>
            <th class="text-end min-w-70px">Jumlah Uang</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        <!--begin::Table row-->
        <?php foreach($payments as $payment) : ?>
        <tr>
            <!--begin::Date=-->
            <td><?= $payment->payment_date; ?></td>
            <!--end::Date=-->
            <!--begin::Description-->
            <td><?= ($payment->description) ? $payment->description : '-'; ?></td>
            <!--end::Description-->
            <td class="text-center">
                <?php if($payment->payment_receipt != null) : ?>
                <button class="btn btn-icon btn-bg-light btn-active-color-success btn-sm"
                    onclick="getImage('<?php echo $payment->paymentId; ?>');return false;">
                    <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil021.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3"
                                d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z"
                                fill="currentColor" />
                            <path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z"
                                fill="currentColor" />
                            <path opacity="0.3" d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
                <?php else : ?>
                <span>-</span>
                <?php endif; ?>
            </td>
            <!--begin::Price=-->
            <td class="text-end pe-0">
                <span class="fw-bold text-dark"><?php echo 'Rp '.number_format($payment->amount_of_money, '0', ',', '.'); ?></span>
            </td>
            <!--end::Price=-->
        </tr>
        <?php endforeach; ?>
        <!--end::Table row-->
    </tbody>
    <!--end::Table body-->
</table>

<script>
     $(document).ready(function() {
        if(DataTable.isDataTable('#salesTable')){
            $('#salesTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#salesTable').DataTable({
            "aaSorting": [],
            "scrollX": true,
            "responsive": true,
        });
    });


    function getImage(paymentId) {
        $.ajax({
            type: "post",
            url: "/penjualan/riwayat/<?= $sales->receipt_number; ?>/paymentReceipt",
            data: {paymentId},
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error, "Error");
                }

                if (response.success) {
                    downloadImage(response.blobBase64, response.fileName);
                }
            }
        });
    }

    function downloadImage(blobBase64, fileName) {
        linkSource = `data:image/png;base64,${blobBase64}`;
        downloadLink = document.createElement('a');
        fileName = `${fileName}.png`;
        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        downloadLink.click();
    }
</script>
