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
            <th class="text-end">Harga</th>
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
    function getCar() {
        if(DataTable.isDataTable('#carTable')){
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
                "data" : {
                    "status" : $('#status').val(),
                    "brandId" : $('#car_brand').val(),
                    "keyword" : null,
                }
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
                "target": 4,
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

    function deleteCar(carId) {
        $.ajax({
            type: "post",
            url: "/mobil/delete",
            data: {
                carId
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                  getCar();
                }
            }
        });
    }

    function alertCarDelete(carId) {
        $.ajax({
            type: "POST",
            url: "/mobil/alertDelete",
            data: {
                carId
            },
            dataType: "json",
            success: function (response) {
                if (!response.error) {
                    Swal.fire({
                        html: `Apakah kamu yakin ingin menghapus ${response.carName} ?`,
                        icon: "warning",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Iya, Hapus",
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteCar(carId);
                        }
                    });
                } else {
                    toastConfig();
                    toastr.error(response.error, "Error");
                }
            }
        });
    }


    $(document).ready(function () {
        getCar();
    });
</script>