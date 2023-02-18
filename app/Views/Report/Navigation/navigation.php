<div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
    <!--begin:::Tabs-->
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 <?= url_is('penjualan/riwayat/') ? 'active' : ''; ?>"
                href="<?= base_url().'/penjualan/riwayat/'; ?>">Mobil</a>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 <?= url_is('penjualan/riwayat/') ? 'active' : ''; ?>"
                href="<?= base_url().'/penjualan/riwayat/'; ?>">Refund</a>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 <?= url_is('penjualan/riwayat/*/pembayaran') ? 'active' : ''; ?>"
                href="<?= base_url().'/penjualan/riwayat/'.'/pembayaran'; ?>">Masuk Umum</a>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 <?= url_is('penjualan/riwayat/*/pembayaran') ? 'active' : ''; ?>"
                href="<?= base_url().'/penjualan/riwayat/'.'/pembayaran'; ?>">Keluar Umum</a>
        </li>
        <!--end:::Tab item-->
    </ul>
    <!--end:::Tabs-->
</div>