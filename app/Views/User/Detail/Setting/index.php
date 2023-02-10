<?= $this->extend('MyProfile/LayoutDetail/index'); ?>

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
                        <div class="image-input image-input-outline <?= ($user->image_profile == null) ? 'image-input-empty' : ''; ?>" data-kt-image-input="true" style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                            <!--begin::Preview existing avatar-->
                            <?php if ($user->image_profile != null) : ?>
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url(/assets/images/users/<?= $user->image_profile; ?>)">
                                </div>
                            <?php else : ?>
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: none"></div>
                            <?php endif; ?>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" class="is-invalid" name="image_profile" id="image_profile" accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="avatar_remove">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-kt-initialized="1">
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
                                <input type="text" name="first_name" id="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nama Depan" value="<?= ucwords(strtolower($user->first_name)); ?>" autocomplete="off">
                                <div class="fv-plugins-message-container invalid-feedback" id="first_name-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                <input type="text" name="last_name" id="last_name" class="form-control form-control-lg form-control-solid" placeholder="Nama Belakang" value="<?= ucwords(strtolower($user->last_name)); ?>" autocomplete="off">
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
                    <label class="col-lg-4 fw-semibold fs-6">Role</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <span class="fw-bold fs-6 text-gray-800"><?= ucwords(strtolower($user->role)); ?></span>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" class="btn btn-primary" id="btnSimpanProfil">Simpan</button>
            </div>
            <div class="role" id="role"><span id="role-feedback"></span></div>
            <!--end::Actions-->
            <input type="hidden" name="myprofile" id="myprofile" value="true">
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
            <div class="d-flex flex-wrap align-items-center mb-10" id="gantiPassword">
                <!--begin::Label-->
                <div id="password">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <!--end::Label-->
                <!--begin::Edit-->
                <div id="ganti_pass" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="passwordLama" class="form-label fs-6 fw-bold mb-3">Password Saat Ini</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="passwordLama" id="passwordLama" />
                                    <div class="fv-plugins-message-container invalid-feedback" id="passwordLama-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="passwordBaru" class="form-label fs-6 fw-bold mb-3">Password Baru</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="passwordBaru" id="passwordBaru" />
                                    <div class="fv-plugins-message-container invalid-feedback" id="passwordBaru-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirmPassword" class="form-label fs-6 fw-bold mb-3">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmPassword" id="confirmPassword" />
                                    <div class="fv-plugins-message-container invalid-feedback" id="confirmPassword-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">Password minimal 8 karakter kombinasi huruf dan angka</div>
                        <div class="d-flex">
                            <button id="btnSimpanPass" type="button" class="btn btn-primary me-2 px-6">Simpan Password</button>
                            <button id="btnCancelPass" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    <!--end::Form-->
                </div>
                <!--end::Edit-->
                <!--begin::Action-->
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary" id="btnGantiPass">Ganti Password</button>
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
    let username = <?= json_encode($user->username); ?>
</script>
<script src="<?= base_url(); ?>/assets/ajax/ajaxPengguna.js"></script>
<!-- end::Script -->

<?= $this->endSection(); ?>