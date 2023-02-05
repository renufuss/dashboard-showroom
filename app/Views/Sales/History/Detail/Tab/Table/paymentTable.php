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
</script>
