<div class="modal fade" id="addPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPaymentModalLabel">Tambah Pembayaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<?php helper('form'); ?>
			<!-- end modalheader -->
			<?= form_open('/penjualan/riwayat/add', ['id' => 'formAddPayment']); ?>
			<div class="modal-body">
				<!--begin::Input group-->
				<div class="row g-9">
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Deskripsi Pembayaran</span>
						</label>
						<!--end::Label-->
						<input type="text" class="form-control mb-2" name="description" id="description"
							autocomplete="off" />
						<div class="invalid-feedback" id="description-feedback"></div>
					</div>
					<!-- end::col -->
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Jumlah Pembayaran</span>
						</label>
						<!--end::Label-->
						<input type="text" class="form-control mb-2" name="amount_of_money" id="amount_of_money"
							autocomplete="off" />
						<div class="invalid-feedback" id="amount_of_money-feedback"></div>
					</div>
					<!-- end::col -->
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span>Bukti Pembayaran</span>
						</label>
						<!--end::Label-->
						<input type="file" class="form-control mb-2" name="payment_receipt" id="payment_receipt"
							autocomplete="off" />
						<div class="invalid-feedback" id="payment_receipt-feedback"></div>
					</div>
					<!-- end::col -->
				</div>
				<!--end::Input group-->

			</div>
			<!-- end modalbody -->
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
			</div>
			<!-- end modalfooter -->
			<?= form_close(); ?>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		autoNumeric();
	});

	function autoNumeric() {
		[amount_of_money] = AutoNumeric.multiple(['#amount_of_money'], {
			digitGroupSeparator: '.',
			decimalPlaces: 0,
			decimalCharacter: ',',
			decimalCharacterAlternative: ',',
			currencySymbol: 'Rp ',
			minimumValue: 0,
			modifyValueOnWheel: false,
			currencySymbolPlacement: AutoNumeric.options.currencySymbolPlacement.prefix,
		});
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

	function savePayment() {
		var form = $("#formAddPayment")[0]; // You need to use standard javascript object here

		var formData = new FormData(form);
		$.ajax({
			type: "post",
			url: "/penjualan/riwayat/<?= $sales->receipt_number; ?>/pembayaran",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			beforeSend: function () {
				$("#btnSave").prop("disabled", true);
				$("#btnSave").html(`
                <div class="loader">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </div>`);
			},
			complete: function () {
				$("#btnSave").prop("disabled", false);
				$("#btnSave").html("Simpan");
			},
			success: function (response) {
				toastConfig();

				// Remove Feedback
				form = {
					description,
					amount_of_money,
					payment_receipt,
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

	$('#btnSave').click(function (e) { 
		e.preventDefault();
		savePayment();
	});
</script>