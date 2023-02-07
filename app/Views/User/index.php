<?= $this->extend('Layout/index'); ?>


<?= $this->section('content'); ?>

<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?php require 'Toolbar/toolbar.php' ?>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card Header-->
                <div class="card-header border-0 pt-5">
                    <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-docs-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Cari Satuan" id="search">
                    </div>
                    <div class="card-toolbar">
                        <!-- begin::Tambah Item -->
                        <button class="btn btn-sm btn-light-primary m-3" data-bs-toggle="modal"
                            data-bs-target="#userModal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Tambah Pengguna
                        </button>
                        <!-- end::Tambah Item -->
                    </div>
                </div>
                <!--end::Card Header-->
                <!--begin::Card Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive" id="tableUser"></div>
                    <!--end::Table container-->
                </div>
                <!--end::Card Body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
<!-- UserModal -->
<?php include('Modals/userModal.php'); ?>

<script>
    function showTable() {
        $.ajax({
            type: "post",
            url: "/pengguna/table",
            data: "",
            dataType: "json",
            beforeSend: function () {
                $("#tableUser").html(`
                <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
	                <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
	                <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
	                <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
	                <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                </svg>
                `);
            },
            success: function (response) {
                $('#tableUser').html(response.tableUser);
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    $(document).ready(function () {
        showTable();
    });


    function toastOptions() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function removeFeedback(form) {
        Object.entries(form).forEach(entry => {
            const [key, value] = entry;
            $(`#${key}`).removeClass('is-invalid');
            $(`#${key}-feedback`).html('');
        });

        return true;
    }

    function saveUser() {
        $.ajax({
            type: "post",
            url: "/pengguna/save",
            data: {
                username: $('#username').val(),
                email: $('#email').val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                role: $('#role').val(),
            },
            dataType: "json",
            beforeSend: function () {
                $("#btnSimpan").html(`
                <div class="loader">
    			<span class="bar"></span>
    			<span class="bar"></span>
    			<span class="bar"></span>
				</div>
                `);
            },
            success: function (response) {
                $("#btnSimpan").html(`Simpan`);

                toastOptions();

                // Remove Feedback
                form = {
                    username,
                    email,
                    first_name,
                    last_name,
                    role
                };
                removeFeedback(form);

                if (response.error) {
                    // Add Feedback
                    Object.entries(response.error).forEach(entry => {
                        const [key, value] = entry;
                        $(`#${key}`).addClass('is-invalid');
                        $(`#${key}-feedback`).html(value);
                    });

                    toastr.error(response.errormsg, "Error");
                }

                if (response.sukses) {
                    Object.entries(form).forEach(entry => {
                        const [key, value] = entry;
                        $(`#${key}`).val('');
                    });
                    toastr.success(response.sukses, "Sukses");
                    showTable();
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    function deleteUser(userId) {
        $.ajax({
            type: "POST",
            url: "/pengguna/delete",
            data: {
                userId
            },
            dataType: "json",
            success: function (response) {
                toastOptions();
                if (response.error) {
                    toastr.error(response.error, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    showTable();
                }
            }
        });
    }

    function confirmDelete(userId) {
        $.ajax({
            type: "POST",
            url: "/pengguna/confirm",
            data: {
                userId
            },
            dataType: "json",
            success: function (response) {
                if (!response.error) {
                    Swal.fire({
                        html: `Apakah kamu yakin ingin menghapus ${response.username} ?`,
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
                            deleteUser(userId);
                        }
                    });
                } else {
                    toastOptions();
                    toastr.error(response.error, "Error");
                }
            }
        });
    }
</script>

<?= $this->endSection(); ?>