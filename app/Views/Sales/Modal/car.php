<div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="modalProduk" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordkode" id="keywordkode" value="0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" width="100%" id="carTable">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Mobil</th>
                            <th>Harga</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // $(document).ready(function() {
    //     var table = $('#databarang').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "order": [],
    //         "ajax": {
    //             "url": "<?php echo base_url('kasir/listDataBarang') ?>",
    //             "type": "POST",
    //             "data": {
    //                 keywordkode: $('#keywordkode').val(),
    //             }
    //         },
    //         "columnDefs": [{
    //             "targets": [0],
    //             "orderable": false,
    //         }, ],
    //     });
    // });

    function pilihitem(kode, nama) {
        $('#kodebarcode').val(kode);
        $('#namaproduk').val(nama);
        $('#modalProduk').on('hidden.bs.modal', function(event) {
            $('#kodebarcode').focus();
            cekKode();
        })
        $('#modalProduk').modal('hide');
    }
</script>