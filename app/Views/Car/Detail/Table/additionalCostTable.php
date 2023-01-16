<style>
    td {
        margin: 0;
        border: 0px solid grey;
        white-space: nowrap;
        border-top-width: 0px;
    }
</style>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="additionalCostTable" style="width: 100%;">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>No</th>
            <th class="min-w-50px">Nama Pengeluaran</th>
            <th class="desktop-only <?= ($print != true) ? 'text-end' : '' ?>">Jumlah Pengeluaran</th>
            <?php if($print != true) : ?>
            <th class="text-center">Bukti Pengeluaran</th>
            <?php endif; ?>
            <th>Pembayaran</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        <!--begin::Table row-->
        <?php $i = 1; ?>
        <?php foreach ($additionalCosts as $additionalCost) : ?>
        <tr>
            <td><?= $i; ?></td>
            <?php $i++; ?>
            <!--begin::PLAT=-->
            <td class="pe-0">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark"><?= $additionalCost->cost_name; ?></span>
                    <?php if($print != true) : ?>
                    <span class="mobile-only">Rp
                        <?= number_format($additionalCost->additional_price, '0', ',', '.'); ?></span>
                        <?php endif; ?>
                </div>
            </td>
            <!--end::PLAT=-->
            <!--begin::Price=-->
            <td class="pe-0 desktop-only <?= ($print != true) ? 'text-end' : '' ?>">
                <span class="fw-bold text-dark">Rp
                    <?= number_format($additionalCost->additional_price, '0', ',', '.'); ?></span>
            </td>
            <!--end::Price=-->
            <?php if($print != true) : ?>
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
            <?php endif; ?>
            <!-- begin::Person Who Pay -->
            <td>
                <?= $additionalCost->paid_by; ?>
            </td>
            <!-- end::Person Who Pay -->
        </tr>
        <?php endforeach; ?>
        <!--end::Table row-->
    </tbody>
    <!--end::Table body-->
</table>

<script>
    function getImage(additionalId) {
        $.ajax({
            type: "post",
            url: "/mobil/download/additionalreceipt",
            data: {
                additionalId : additionalId,
            },
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
