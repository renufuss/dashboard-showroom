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
            <th class="text-center">No</th>
            <th class="min-w-50px">Nama Pengeluaran</th>
            <th>Jumlah Pengeluaran</th>
            <th>Bukti Pengeluaran</th>
            <th>Pembayaran</th>
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
        getAdditionalCost();
    });

    function getAdditionalCost() {
        if(DataTable.isDataTable('#additionalCostTable')){
            $('#additionalCostTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#additionalCostTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/mobil/<?= $car->id; ?>/biaya",
                "type": "POST"
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
            "columnDefs": [{
                "target": 0,
                "orderable": false,
            },
            {
                "target": 3,
                "orderable": false,
            },
            {
                "target": -1,
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

    function getImage(additionalId) {
        $.ajax({
            type: "post",
            url: "/mobil/download/additionalreceipt",
            data: {
                additionalId: additionalId,
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