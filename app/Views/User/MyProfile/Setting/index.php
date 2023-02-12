<?= $this->extend('User/MyProfile/LayoutDetail/index'); ?>

<?= $this->section('boxBawah'); ?>

<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Detail Profil</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="formDetailProfil" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto Profil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline <?= ($user->image_profile == null) ? 'image-input-empty' : ''; ?>"
                            data-kt-image-input="true"
                            style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                            <!--begin::Preview existing avatar-->
                            <?php if ($user->image_profile != null) : ?>
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: url(data:image/png;base64,<?= $user->image_profile; ?>)">
                            </div>
                            <?php else : ?>
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: none"></div>
                            <?php endif; ?>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" class="is-invalid" name="image_profile" id="image_profile"
                                    accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="avatar_remove">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        <div class="form-text" style="color: red;" id="image_profile-feedback"></div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                <input type="text" name="first_name" id="first_name"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Nama Depan" value="<?= ucwords(strtolower($user->first_name)); ?>"
                                    autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="first_name-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                <input type="text" name="last_name" id="last_name"
                                    class="form-control form-control-lg form-control-solid" placeholder="Nama Belakang"
                                    value="<?= ucwords(strtolower($user->last_name)); ?>" autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="last_name-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold fs-6 required">Role</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <span class="fw-bold fs-6 text-gray-800"><?= ucwords(strtolower($user->role)); ?></span>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" class="btn btn-primary" id="btnSaveProfile">Simpan</button>
            </div>
            <div class="role" id="role"><span id="role-feedback"></span></div>
            <!--end::Actions-->
            <div></div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
<!--begin::Sign-in Method-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Informasi Akun</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_signin_method" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Username-->
            <div class="d-flex flex-wrap align-items-center">
                <!--begin::Label-->
                <div id="username_label">
                    <div class="fs-6 fw-bold mb-1">Username</div>
                    <div class="fw-semibold text-gray-600"><?= ucwords(strtolower($user->username)); ?></div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Username-->
            <br>
            <!--begin::Email Address-->
            <div class="d-flex flex-wrap align-items-center">
                <!--begin::Label-->
                <div id="email_address">
                    <div class="fs-6 fw-bold mb-1">Alamat Email</div>
                    <div class="fw-semibold text-gray-600"><?= ucwords(strtolower($user->email)); ?></div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Email Address-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-6"></div>
            <!--end::Separator-->
            <!--begin::Password-->
            <div class="d-flex flex-wrap align-items-center mb-10">
                <!--begin::Label-->
                <div id="passwordShow">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <!--end::Label-->
                <!--begin::Edit-->
                <div id="formChangePassword" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <div class="row mb-1">
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="oldPassword" class="form-label fs-6 fw-bold mb-3">Password Saat Ini</label>
                                <input type="password" class="form-control form-control-lg form-control-solid"
                                    name="oldPassword" id="oldPassword" />
                                <div class="fv-plugins-message-container invalid-feedback" id="oldPassword-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="newPassword" class="form-label fs-6 fw-bold mb-3">Password Baru</label>
                                <input type="password" class="form-control form-control-lg form-control-solid"
                                    name="newPassword" id="newPassword" />
                                <div class="fv-plugins-message-container invalid-feedback" id="newPassword-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="confirmPassword" class="form-label fs-6 fw-bold mb-3">Konfirmasi Password
                                    Baru</label>
                                <input type="password" class="form-control form-control-lg form-control-solid"
                                    name="confirmPassword" id="confirmPassword" />
                                <div class="fv-plugins-message-container invalid-feedback"
                                    id="confirmPassword-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-text mb-5">Password minimal 8 karakter kombinasi huruf dan angka</div>
                    <div class="d-flex">
                        <button id="btnSavePassword" type="button" class="btn btn-primary me-2 px-6">Simpan Password</button>
                        <button id="btnCancelPass" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Edit-->
                <!--begin::Action-->
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary" id="btnChangePassword">Ganti Password</button>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Password-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
<!--end::Sign-in Method-->


<!-- begin::Script -->
<script type="text/javascript">

    function toastConfig() {
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
        };
    }

    function removeFeedback(form) {
        Object.entries(form).forEach(entry => {
            const [key, value] = entry;
            $(`#${key}`).removeClass('is-invalid');
            $(`#${key}-feedback`).html('');
        });

        return true;
    }

    function addFeedback(responseError) {
        Object.entries(responseError).forEach(entry => {
            const [key, value] = entry;
            $(`#${key}`).addClass('is-invalid');
            $(`#${key}-feedback`).html(value);
        });
    }

    function updateProfile() {
        var form = $("#formDetailProfil")[0]; // You need to use standard javascript object here
        var formData = new FormData(form);

        $.ajax({
            type: "post",
            url: `/profile/setting`,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function () {
                $("#btnSaveProfile").prop("disabled", true);
                $("#btnSaveProfile").html(`
                <div class="loader">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </div>`);
            },
            complete: function () {
                $("#btnSaveProfile").prop("disabled", false);
                $("#btnSaveProfile").html("Simpan");
            },
            success: function (response) {
                toastConfig();

                // Remove Feedback
                form = {
                    first_name,
                    last_name,

                };
                removeFeedback(form);

                if (response.error) {
                    // Add Feedback
                    addFeedback(response.error);
                    toastr.error(response.errorMsg, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    setTimeout(function () {
                        location.reload();
                    }, 1200);
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    function savePassword(){
        $.ajax({
            type: "post",
            url: `/profile/setting/password`,
            data: {
                oldPassword : $('#oldPassword').val(),
                newPassword : $('#newPassword').val(),
                confirmPassword : $('#confirmPassword').val(),
            },
            dataType: "json",
            beforeSend: function () {
                $("#btnSavePassword").prop("disabled", true);
                $("#btnSavePassword").html(`
                <div class="loader">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </div>`);
            },
            complete: function () {
                $("#btnSavePassword").prop("disabled", false);
                $("#btnSavePassword").html("Simpan Password");
            },
            success: function (response) {
                toastConfig();

                // Remove Feedback
                form = {
                    oldPassword,
                    newPassword,
                    confirmPassword,

                };
                removeFeedback(form);

                if (response.error) {
                    // Add Feedback
                    addFeedback(response.error);
                    toastr.error(response.errorMsg, "Error");
                }

                if (response.success) {
                    toastr.success(response.success, "Sukses");
                    setTimeout(function () {
                        location.reload();
                    }, 1200);
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }

    function showChangePassword(){
        $('#passwordShow').addClass('d-none');
        $('#formChangePassword').removeClass('d-none');
        $('#btnChangePassword').addClass('d-none');
    }

    function closeChangePassword(){
        $('#passwordShow').removeClass('d-none');
        $('#formChangePassword').addClass('d-none');
        $('#btnChangePassword').removeClass('d-none');
    }

    $('#btnChangePassword').click(function (e) { 
        e.preventDefault();
        showChangePassword();
    });

    $('#btnCancelPass').click(function (e) { 
        e.preventDefault();
        closeChangePassword();
    });

    $('#btnSaveProfile').click(function (e) {
        e.preventDefault();
        updateProfile();
    });

    $('#btnSavePassword').click(function (e) { 
        e.preventDefault();
        savePassword();
    });
</script>
<!-- end::Script -->

<?= $this->endSection(); ?>