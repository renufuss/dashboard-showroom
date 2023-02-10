<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="userModalLabel">Tambah Pengguna</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<!-- end modalheader -->
					<div class="modal-body">
						<!--begin::Input group-->
						<div class="row g-9 mb-8">
							<!-- begin::col -->
							<div class="col-md-6 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
									<span class="required">Username</span>
								</label>
								<!--end::Label-->
								<input type="text" class="form-control form-control-solid" placeholder="Masukkan username"
									name="username" id="username" autocomplete="off" />
								<div class="invalid-feedback" id="username-feedback"></div>
							</div>
							<!-- end::col -->
							<!-- begin::col -->
							<div class="col-md-6 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
									<span class="required" autocomplete="off">Email</span>
								</label>
								<!--end::Label-->
								<input type="email" class="form-control form-control-solid" placeholder="Masukkan email"
									name="email" id="email" autocomplete="off" />
									<div class="invalid-feedback" id="email-feedback"></div>
							</div>
							<!-- end::col -->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row g-9">
							<!-- begin::col -->
							<div class="col-md-6 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
									<span class="required">Nama Depan</span>
								</label>
								<!--end::Label-->
								<input type="text" class="form-control form-control-solid" placeholder="Masukkan nama depan"
									name="first_name" id="first_name" autocomplete="off" />
									<div class="invalid-feedback" id="first_name-feedback"></div>
							</div>
							<!-- end::col -->
							<!-- begin::col -->
							<div class="col-md-6 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
									<span class="required">Nama Belakang</span>
								</label>
								<!--end::Label-->
								<input type="text" class="form-control form-control-solid"
									placeholder="Masukkan nama belakang" name="last_name" id="last_name" autocomplete="off" />
									<div class="invalid-feedback" id="last_name-feedback"></div>
							</div>
							<!-- end::col -->
							<!--begin::Input group-->
							<div class="d-flex flex-column mb-8 fv-row">
								<label class="required fs-6 fw-semibold mb-2">Role</label>
								<select class="form-select form-select-solid" name="role" id="role" data-control="select2"
									data-hide-search="true" data-placeholder="Pilih Role...">
									<option value="">Pilih Role...</option>
									<?php foreach($role as $row): ?>
									<option value="<?= $row->name; ?>"><?= $row->name; ?></option>
									<?php endforeach; ?>
								</select>
								<div class="invalid-feedback" id="role-feedback"></div>
							</div>
							<!-- end::Input group -->
						</div>
						<!--end::Input group-->

					</div>
					<!-- end modalbody -->
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
					</div>
					<!-- end modalfooter -->
				</div>
			</div>
		</div>

		<script>
			$('#btnSimpan').click(function (e) { 
				e.preventDefault();
				saveUser();
			});
		</script>

