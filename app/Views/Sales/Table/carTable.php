<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="carTable">
    <thead>
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Mobil</th>
            <th class="text-end">Harga</th>
            <th class="text-end">Aksi</th>
        </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        getCar();
    });

    function getCar() {
        setTimeout(function () {
            if (DataTable.isDataTable('#carTable')) {
            $('#carTable').DataTable().destroy();
            // Loading
            $('#tbody').html(`<i class='fa fa-refresh fa-spin'></i>`);
        }
        let table = $('#carTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/mobil/getcar",
                "type": "POST",
                "data": {
                    "status" : 0,
                    "keyword" : $('#keyword').val(),
                    "sales": true,
                },
                "error": function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                },
            },
            'columnDefs': [{
                    'responsivePriority': 1,
                    'targets': 0
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
                    "target": 1,
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
        },500)
    }

    function selectItem(licenseNumber) {
        $('#keyword').val(licenseNumber);
        checkLicenseNumber();
        $('#carModal').modal('hide');

    }
</script>