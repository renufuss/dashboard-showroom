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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="loanTable">
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
        <?php foreach($loans as $loan): ?>
        <tr>
            <td>
                <?= $loan['transaction_date']; ?>
            </td>
            <td>
                <?= $loan['description']; ?>
            </td>
            <td>
                <?= 'Rp ' . number_format($loan['amount_of_money'], '0', ',', '.'); ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
    <tr>
        <td class="text-center fw-bolder desktop-only" colspan="2">Total Utang Perusahaan</td>
        <td class="text-center fw-bolder mobile-only">Total Utang Perusahaan</td>
        <td class="fw-bolder"><?= 'Rp ' . number_format($totalLoan, '0', ',', '.'); ?></td>
    </tr>
    <!--end::Table body-->
</table>
