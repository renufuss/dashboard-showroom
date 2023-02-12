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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="historyTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Tanggal</th>
            <th>ID</th>
            <th>Nama Lengkap</th>
            <th>Nomor HP</th>
            <th>Status</th>
            <th>Total Harga</th>
            <?php if(in_groups('Super Admin') || in_groups('Keuangan')) : ?>
            <th class="text-end">Aksi</th>
            <?php endif; ?>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600" id="tbody">

    </tbody>
    <!--end::Table body-->
</table>

<script>
    function getHistory() {
        if(DataTable.isDataTable('#historyTable')){
            $('#historyTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#historyTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/penjualan/riwayat",
                "type": "POST",
                "data" : {}
            },
            'columnDefs': [{
                    'responsivePriority': 1,
                    'targets': 1
                },
                {
                    'responsivePriority': 2,
                    'targets': -1
                }
            ],
            "scrollX": true, // enables horizontal scrolling      
            "filter": true,
            "responsive": true,
            "info": true, // control table information display field
            "stateSave": false, //restore table state on page reload,
            "language": {
                "processing": "<i class='fa fa-refresh fa-spin'></i>",
            },
            // optional
            // "columnDefs": [{
            //     "target": 4,
            //     "orderable": false,
            // },
            // {
            //     "target": -1,
            //     "orderable": false,
            // },
        // ],
        })
        // removeLoading
        $('#tbody').html('');
        $('#search').on('keyup', function () {
            table.search(this.value).draw();
        });

    }
    $(document).ready(function () {
        getHistory();
    });
</script>