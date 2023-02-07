
<form class="form w-100" action="<?= url_to('login') ?>" method="post">
    <?= csrf_field() ?>
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Heading-->
        <div class="text-start mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3 fs-3x">
                Masuk
            </h1>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="text-gray-400 fw-semibold fs-7">
                Dashboard Kebab Turkiyem
            </div>
            <!--end::Link-->
        </div>
        <?= view('Myth\Auth\Views\_message_block') ?>
        <!--end::Heading-->
        <?php if ($config->validFields === ['email']): ?>
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="login" placeholder="Email" name="login" autocomplete="off"
                class="form-control form-control-solid <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" value="<?= old('login');?>" />
            <!--end::Email-->
            <div class="invalid-feedback">
                <?= session('errors.login') ?>
            </div>
        </div>
        <!--end::Input group=-->
        <?php else: ?>
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email or Username-->
            <input type="text" placeholder="Username atau Email" name="login" autocomplete="off" class="form-control form-control-solid <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" value="<?= old('login');?>" />
            <!--end::Email or Username-->
            <div class="invalid-feedback">
                <?= session('errors.login') ?>
            </div>
        </div>
        <!--end::Input group=-->
        <?php endif; ?>
        <div class="fv-row mb-7">
            <!--begin::Password-->
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control form-control-solid <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" />
            <!--end::Password-->
            <div class="invalid-feedback">
				<?= session('errors.password') ?>
			</div>
        </div>
        <!--end::Input group=-->
        <!--begin::Actions-->
        <div class="d-flex flex-stack">
            <!--begin::Submit-->
            <button type="submit" class="btn btn-primary me-2 flex-shrink-0">Masuk
            </button>
            <!--end::Submit-->
        </div>
        <!--end::Actions-->
    </div>
    <!--begin::Body-->
</form>