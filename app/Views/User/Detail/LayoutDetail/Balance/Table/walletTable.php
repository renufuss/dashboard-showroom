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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="walletTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Jumlah Uang</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600" id="tbody">
        <?php foreach($wallets as $wallet): ?>
        <tr>
            <td>
                <?= $wallet->transaction_date; ?>
            </td>
            <td>
                <?= $wallet->description; ?>
            </td>
            <td>
                <?php if($wallet->status == 0) : ?>
                <span class="badge badge-light-success fs-7 fw-bold">Uang Masuk</span>
                <?php elseif($wallet->status == 1) : ?>
                <span class="badge badge-light-danger fs-7 fw-bold">Uang Keluar</span>
                <?php endif ?>
            </td>
            <td>
                <?= 'Rp ' . number_format($wallet->amount_of_money, '0', ',', '.'); ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        if (DataTable.isDataTable('#walletTable')) {
            $('#walletTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#walletTable').DataTable({
            "aaSorting": [],
            "scrollX": true,
            "responsive": true,
        });
    });
</script>
