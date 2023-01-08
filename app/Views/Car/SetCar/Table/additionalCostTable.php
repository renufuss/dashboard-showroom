<style>
    td {
        margin: 0;
        border: 0px solid grey;
        white-space: nowrap;
        border-top-width: 0px;
    }
</style>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table" style="width: 100%;">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-50px">Nama Pengeluaran</th>
            <th class="desktop-only text-end">Jumlah Pengeluaran</th>
            <th class="text-center">Bukti Pengeluaran</th>
            <th>Pembayaran</th>
            <th class="text-end min-w-70px">Actions</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        <!--begin::Table row-->
        <?php foreach ($additionalCosts as $additionalCost) : ?>
        <tr>
            <!--begin::PLAT=-->
            <td class="pe-0">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark"><?= $additionalCost->cost_name; ?></span>
                    <span class="mobile-only">Rp
                        <?= number_format($additionalCost->additional_price, '0', ',', '.'); ?></span>
                </div>
            </td>
            <!--end::PLAT=-->
            <!--begin::Price=-->
            <td class="pe-0 desktop-only text-end">
                <span class="fw-bold text-dark">Rp
                    <?= number_format($additionalCost->additional_price, '0', ',', '.'); ?></span>
            </td>
            <!--end::Price=-->
            <td class="text-center">
                <?php if($additionalCost->additional_receipt != null) : ?>
                <button class="btn btn-icon btn-bg-light btn-active-color-success btn-sm"
                    onclick="getImage('<?= $additionalCost->id; ?>');return false;">
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
            <!-- begin::Person Who Pay -->
            <td>
                <?= $additionalCost->paid_by; ?>
            </td>
            <!-- end::Person Who Pay -->
            <!--begin::Action=-->
            <td class="text-end">
                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onclick="alertDeleteTempAdditionalCost('<?= $additionalCost->id; ?>');return false;">
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
