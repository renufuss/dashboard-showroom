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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="transactionTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Bukti Transaksi</th>
            <th>Status</th>
            <th class="text-end">Jumlah Uang</th>
            <th class="text-end">Aksi</th>
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
    $(document).ready(function () {
        getTransaction();
    });

    function getTransaction() {
        if(DataTable.isDataTable('#transactionTable')){
            $('#transactionTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#transactionTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/transaksi",
                "type": "POST",
                "data" : {}
            },
            "scrollX": true, // enables horizontal scrolling      
            "filter": true,
            "responsive": true,
            "info": true, // control table information display field
            "stateSave": false, //restore table state on page reload,
            "language": {
                "processing": "<i class='fa fa-refresh fa-spin'></i>",
            },
            // optional
            "columnDefs": [{
                "target": 1,
                "responsivePriority": 1,
                "orderable": false,
            },
            {
                "target": 2,
                "orderable": false,
            },
            {
                "target": 3,
                "orderable": false,
            },
            {
                "target": 4,
                "orderable": false,
            },
            {
                "target": 5,
                "orderable": false,
            },
        ],
        })
        // removeLoading
        $('#tbody').html('');
        $('#search').on('keyup', function () {
            table.search(this.value).draw();
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