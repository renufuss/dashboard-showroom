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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="refundTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Jumlah Uang</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600" id="tbody">
        <?php foreach($refunds as $refund): ?>
        <tr>
            <td>
                <?= $refund->transaction_date; ?>
            </td>
            <td>
                <?= $refund->description; ?>
            </td>
            <td>
                <?= 'Rp ' . number_format($refund->amount_of_money, '0', ',', '.'); ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
    <tr>
        <td class="text-center fw-bolder desktop-only" colspan="2">Total Refund</td>
        <td class="text-center fw-bolder mobile-only">Total Refund</td>
        <td class="fw-bolder"><?= 'Rp ' . number_format($totalRefund, '0', ',', '.'); ?></td>
    </tr>
    <!--end::Table body-->
</table>
