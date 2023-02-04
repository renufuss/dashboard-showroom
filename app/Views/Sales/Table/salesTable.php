<style>
    td,
    th {
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
            <th class="text-end min-w-70px">Harga</th>
            <th class="text-end min-w-70px">Aksi</th>
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
                        <span class="symbol-label"
                            style="background-image:url(data:image/png;base64,<?php echo $car->car_image; ?>);"></span>
                    </span>
                    <!--end::Thumbnail-->
                    <div class="ms-5">
                        <!--begin::Car details-->
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 text-hover-primary mb-1"><?php echo $car->car_name; ?></span>
                            <span><?php echo $car->license_number; ?></span>
                        </div>
                        <!--begin::Car details-->
                    </div>
                </div>
            </td>
            <!--end::Car=-->
            <!--begin::Price=-->
            <td class="text-end pe-0">
                <span
                    class="fw-bold text-dark"><?php echo 'Rp '.number_format($car->car_price, '0', ',', '.'); ?></span>
            </td>
            <!--end::Price=-->
            <!--begin::Action=-->
            <td class="text-end">
                <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                    onclick="alertDeleteTemp('<?php echo $car->tempId; ?>')">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                fill="currentColor"></path>
                            <path opacity="0.5"
                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                fill="currentColor"></path>
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
            </td>
            <!--end::Action=-->
        </tr>
        <?php endforeach; ?>
        <!--end::Table row-->
    </tbody>
    <!--end::Table body-->
</table>

<script>
    $(document).ready(function () {
        if (DataTable.isDataTable('#salesTable')) {
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