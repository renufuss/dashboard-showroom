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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="carTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>Mobil</th>
            <th>Warna</th>
            <th>Tahun</th>
            <th>Plat Nomor</th>
            <th>Status</th>
            <th class="text-end">Modal</th>
            <th class="text-center">Actions</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">

    </tbody>
    <!--end::Table body-->
</table>

<script>
    function getCar() {
        let table = $('#carTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/mobil/getcar",
                "type": "POST",
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
            // "columnDefs": [{
            //     "target": 0,
            //     "orderable": false,
            // }],
        })

        $('#search').on('keyup', function () {
            table.search(this.value).draw();
        });

    }

    $(document).ready(function () {
        getCar();
    });
</script>