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

<table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="reportTable">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="text-center">Tanggal</th>
            <th class="text-center">Keterangan</th>
            <th class="text-end">Aksi</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600" id="tbody">
        <?php foreach($reports as $report) : ?>
        <tr>
            <td class="text-center">
                <?= $report->report_date; ?>
            </td>
            <td class="text-center">
                <?= $report->report_receipt; ?>
            </td class="text-center">
            <td class="text-end">
                <a href="<?= base_url('laporan/'.$report->report_receipt); ?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" target="__blank">
                    <!--begin::Svg Icon | path: C:/wamp64/www/keenthemes/core/html/src/media/icons/duotune/files/fil024.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3"
                                d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z"
                                fill="currentColor" />
                            <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="currentColor" />
                            <rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447"
                                transform="rotate(45 13.6993 13.6656)" fill="currentColor" />
                            <path
                                d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
    <!--end::Table body-->
</table>

<script>
    $(document).ready(function () {
        const table = $('#reportTable').DataTable({
            "aaSorting": [],
            "scrollX": true,
            "responsive": true,
            "destroy": true,
            'columnDefs': [{
                    'responsivePriority': 1,
                    'targets': 1
                },
                {
                    'responsivePriority': 2,
                    'targets': -1
                }
            ],
        });

        $('#search').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>