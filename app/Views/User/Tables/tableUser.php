<!-- begin :: DataTable CSS -->
<link href="<?= base_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<!-- end :: DataTable CSS -->

<table class="table align-middle gs-0 gy-4" id="userDataTable">
    <!--begin::Table head-->
    <thead>
        <tr class="fw-bold text-muted bg-light">
            <th class="text-center rounded-start ps-4">#</th>
            <th class="ps-4 min-w-200px">Pengguna</th>
            <th class="ps-4 min-w-150px text-center">Nama Depan</th>
            <th class="ps-4 min-w-150px text-center">Nama Belakang</th>
            <th class="ps-4 min-w-100px">Role</th>
            <th class="text-center rounded-end"></th>
        </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody>
        <?php $i = 1;
foreach($users as $user) :
    ?>
        <tr>
            <td class="text-center">
                <?= $i++; ?>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-50px me-5">
                        <?php if($user->image_profile != null) : ?>
                        <img src="<?= base_url(); ?>/assets/images/users/<?= $user->image_profile; ?>" class="" alt="" />
                        <?php else : ?>
                        <div class="symbol symbol-50px">
                            <div class="symbol-label fs-2 fw-semibold bg-<?= $user->badge; ?> text-inverse-danger"><?= strtoupper(substr($user->first_name, 0, 1)); ?><?= strtoupper(substr($user->last_name, 0, 1)); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                        <span class="text-dark fw-bold text-hover-primary mb-1 fs-6"><?= ucwords(strtolower($user->username)); ?></span>
                        <span class="text-muted fw-semibold text-muted d-block fs-7 "><?= ucwords(strtolower($user->email)); ?></span>
                    </div>
                </div>
            </td>
            <td class="text-center"><?= $user->first_name; ?></td>
            <td class="text-center"><?= $user->last_name; ?></td>
            <td class="ps-4">
                <span class="badge badge-light-<?= $user->badge; ?> fs-7 fw-bold"><?= $user->role; ?></span>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-end flex-shrink-0">
                    <a href="<?= base_url(); ?>/pengguna/detail/<?= $user->username; ?>" target="__blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class="svg-icon svg-icon-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z"
                                    fill="currentColor"></path>
                                <path opacity="0.3"
                                    d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="confirmDelete('<?= $user->id ?>')">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                        <span class="svg-icon svg-icon-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                    fill="currentColor"></path>
                                <path opacity="0.5"
                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                    fill="currentColor"></path>
                                <path opacity="0.5"
                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <!--end::Table body-->
</table>

<!-- begin :: DataTable Js -->
<script src="<?= base_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!-- end :: End DataTable Js -->

<script>
    $(document).ready(function () {
        const table = $('#userDataTable').DataTable({
            "aaSorting": [],
            "scrollX": true
        });

        $('#search').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>