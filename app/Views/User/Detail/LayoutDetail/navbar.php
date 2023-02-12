<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="row">
            <!--begin: Pic-->
            <div class="col-lg-3 col-xxl-2 col-md-3 col-12 mb-3" id="picDetailPengguna">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <?php if($user->image_profile != null) : ?>
                        <img src="data:image/png;base64,<?= $user->image_profile; ?>" class="" alt="" />
                    <?php else : ?>
                        <div class="symbol symbol-50px">
                            <div class="symbol-label fs-3x fw-semibold bg-<?= $user->badge; ?> text-inverse-danger"><?= strtoupper(substr($user->first_name, 0, 1)); ?><?= strtoupper(substr($user->last_name, 0, 1)); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="col-md-9 col-12">
                <!--begin::Title-->
                <!--begin::User-->
                <div class="d-flex flex-column">
                    <!--begin::Name-->
                    <div class="col-md-12 col-12 mb-4" id="namaLengkapDetailPengguna">
                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= ucwords(strtolower($user->first_name)); ?>
                            <?= ucwords(strtolower($user->last_name)); ?></a>
                    </div>
                    <!--end::Name-->
                    <!--begin::Info-->
                    <div class="row">
                        <div class="col-md-12 col-12 mb-3 infoDetailPengguna">
                            <a href="#" class="text-gray-400 text-hover-primary me-5 mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                            fill="currentColor" />
                                        <path
                                            d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                            fill="currentColor" />
                                        <rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <?= ucwords(strtolower($user->role)); ?>
                            </a>
                        </div>
                        <div class="col-md-12 col-12 infoDetailPengguna">
                            <a href="#" class="text-gray-400 text-hover-primary mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                            fill="currentColor" />
                                        <path
                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon--><?= ucwords(strtolower($user->email)); ?>
                            </a>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::User-->
                <!--end::Title-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Navs-->
        <!-- desktop -->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=($navDetail) ? 'active' : '' ?>" href="<?= base_url(); ?>/pengguna/detail/<?= $user->username; ?>">Detail</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=($navPengaturan) ? 'active' : '' ?>" href="<?= base_url(); ?>/pengguna/setting/<?= $user->username; ?>">Pengaturan</a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--begin::Navs-->
    </div>
</div>