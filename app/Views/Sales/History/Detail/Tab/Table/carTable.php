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
            <th class="min-w-200px">Mobil</th>
            <th class="min-w-200px">Nomor Plat</th>
            <th class="text-end min-w-70px">Harga</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        <!--begin::Table row-->
        <?php foreach($cars as $car) : ?>
        <tr>
            <!--begin::Car=-->
            <td>
                <div class="d-flex align-items-center">
                    <!--begin::Thumbnail-->
                    <span class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image:url(data:image/png;base64,<?php echo $car->car_image; ?>);"></span>
                    </span>
                    <!--end::Thumbnail-->
                    <div class="ms-5">
                        <!--begin::Car details-->
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 text-hover-primary mb-1"><?php echo $car->car_name; ?></span>
                            <span><?php echo $car->brand_name; ?></span>
                        </div>
                        <!--begin::Car details-->
                    </div>
                </div>
            </td>
            <!--end::Car=-->
            <td><?= $car->license_number; ?></td>
            <!--begin::Price=-->
            <td class="text-end pe-0">
                <span class="fw-bold text-dark"><?php echo 'Rp '.number_format($car->car_price, '0', ',', '.'); ?></span>
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
