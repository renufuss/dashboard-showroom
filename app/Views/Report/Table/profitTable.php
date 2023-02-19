<style>
    /* desktop only */
    @media (min-width: 769px) {
        .mobile-only {
            display: none;
        }

        td {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    /* mobile only */
    @media (max-width: 480px) {
        .desktop-only {
            display: none;
        }

        td {
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="profitTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Deskripsi</th>
            <th>Mobil</th>
            <th>Uang Masuk</th>
            <th>Uang Keluar</th>
            <th>Keuntungan</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600" id="tbody">
        <?php foreach($transactions as $transaction): ?>
        <tr>
            <td>
                <a class="text-gray-800 text-hover-primary mb-1" href="<?= base_url(); ?>/penjualan/riwayat/<?= $transaction['receipt_number']; ?>/pembayaran" target="_blank"><?= $transaction['description'].' :: '.$transaction['receipt_number'] ; ?></a>
            </td>
            <td>
                <a class="text-gray-800 text-hover-primary mb-1" href="<?= base_url(); ?>/mobil/<?= $transaction['car_id']; ?>" target="_blank"><?= $transaction['license_number'] ; ?></a>
            </td>
            <td>
                <?= 'Rp ' . number_format($transaction['income'], '0', ',', '.'); ?>
            </td>
            <td>
            <?= 'Rp ' . number_format($transaction['outcome'], '0', ',', '.'); ?>
            </td>
            <td>
            <?= 'Rp ' . number_format($transaction['profit'], '0', ',', '.'); ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
    <tr>
        <td class="text-center fw-bolder desktop-only" colspan="4">Total Keuntungan</td>
        <td class="text-center fw-bolder mobile-only">Total Keuntungan</td>
        <td class="fw-bolder"><?= 'Rp ' . number_format($totalProfit, '0', ',', '.'); ?></td>
    </tr>
    <!--end::Table body-->
</table>

<script>
    $(document).ready(function () {
        const table = $('#profitTable').DataTable({
            "aaSorting": [],
            "scrollX": true,
            "responsive" : true,
            "destroy" : true,
            'columnDefs': [{
                    'responsivePriority': 1,
                    'targets': 1
                },
                {
                    'responsivePriority': 2,
                    'targets': -1
                }
            ],
        });

        $('#searchProfit').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>
