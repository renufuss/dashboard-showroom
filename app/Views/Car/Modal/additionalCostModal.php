<div class="modal fade" id="additionalCostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="additionalCostModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="additionalCostModalLabel"><?= $titleModal; ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<?php helper('form'); ?>
			<!-- end modalheader -->
			<?= form_open('/mobil/biaya/update', ['id' => 'formSetAdditionalCost']); ?>
			<div class="modal-body">
				<!--begin::Input group-->
				<div class="row g-9">
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Nama Pengeluaran</span>
						</label>
						<!--end::Label-->
						<input type="text" class="form-control mb-2" name="description" id="description"
							autocomplete="off" value="<?= ($additionalCost) ? $additionalCost->description : ''; ?>" />
						<div class="invalid-feedback" id="description-feedback"></div>
					</div>
					<!-- end::col -->
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Jumlah Pengeluaran</span>
						</label>
						<!--end::Label-->
						<input type="text" class="form-control mb-2" name="amount_of_money" id="amount_of_money"
							autocomplete="off"
							value="<?= ($additionalCost) ? $additionalCost->amount_of_money : ''; ?>" />
						<div class="invalid-feedback" id="amount_of_money-feedback"></div>
					</div>
					<!-- end::col -->
					<!-- begin::col -->
					<div class="col-md-12 fv-row">
						<!--begin::Label-->
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Bukti Pengeluaran</span>
						</label>
						<!--end::Label-->
						<input type="file" class="form-control mb-2" placeholder="Masukkan nama belakang"
							name="additional_receipt" id="additional_receipt" autocomplete="off" />
						<div class="invalid-feedback" id="additional_receipt-feedback"></div>
					</div>
					<!-- end::col -->
					<!--begin::Input group-->
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Pembayaran</label>
						<select class="form-select form-select-solid cursor-pointer mb-2" data-control="select2"
							data-hide-search="false" data-placeholder="Pilih Pembayaran" id="paid_by" name="paid_by">
							<option value="">Pilih Pembayaran</option>
							<option value="Sam un"
								<?= ($additionalCost) ? ($additionalCost->paid_by == "Sam un") ? 'selected' : '' : ''; ?>>
								Sam un</option>
							<option value="Hereansyah"
								<?= ($additionalCost) ? ($additionalCost->paid_by == "Hereansyah") ? 'selected' : '' : ''; ?>>
								Hereansyah</option>
						</select>
						<div class="invalid-feedback" id="paid_by-feedback"></div>
					</div>
					<!-- end::Input group -->
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
		// load File to Input Form
		loadURLToInputField('data:image/png;base64,<?= ($additionalCost) ? $additionalCost->additional_receipt : ''; ?>','<?= ($additionalCost) ? '#additional_receipt' : '#additionalCostModalLabel' ?>', '<?= ($additionalCost) ? $additionalCost->description : ''; ?>_receipt.jpg')
		autoNumeric();
	});
	$('#btnSave').click(function (e) {
		e.preventDefault();
		saveAdditionalCost();
	});

	// load File to Input Form
	function loadURLToInputField(url, idFileInput, fileNames) {
		getImgURL(url, (imgBlob) => {
			// Load img blob to input
			// WIP: UTF8 character error
			let fileName = fileNames
			let file = new File([imgBlob], fileName, {
				type: "image/jpeg",
				lastModified: new Date().getTime()
			}, 'utf-8');
			let container = new DataTransfer();
			container.items.add(file);
			document.querySelector(idFileInput).files = container.files;

		})
	}

	// xmlHTTP return blob respond
	function getImgURL(url, callback) {
		var xhr = new XMLHttpRequest();
		xhr.onload = function () {
			callback(xhr.response);
		};
		xhr.open('GET', url);
		xhr.responseType = 'blob';
		xhr.send();
	}
	//End load File to Input Form

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

	function saveAdditionalCost(){
		var form = $("#formSetAdditionalCost")[0]; // You need to use standard javascript object here
		
        var formData = new FormData(form);
		$.ajax({
			type: "post",
			url: "/mobil/biaya/<?= $car->id ?><?= ($additionalCost) ? "/".$additionalCost->id : '' ?>",
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
					additional_receipt,
					paid_by,
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


</script>