<style>
	.header-wrapper {
		margin-bottom: 30px;
	}

	h4 {
		font-family: Inter, Helvetica, sans-serif;
		font-size: 25px;
		font-weight: 700;
		line-height: 35.1px;
		text-decoration: none solid rgb(63, 66, 84);
		word-spacing: 0px;
	}

	#name {
		font-family: Inter, Helvetica, sans-serif;
		font-size: 19.5px;
		font-weight: 600;
		line-height: 29.25px;
		text-decoration: none solid rgb(24, 28, 50);
		word-spacing: 0px;
	}

	#thankyou-text {
		font-family: Inter, Helvetica, sans-serif;
		font-size: 14.95px;
		font-weight: 600;
		line-height: 22.425px;
		text-decoration: none solid rgb(161, 165, 183);
		word-spacing: 0px;
		background-color: #FFFFFF;
		background-position: 0% 0%;
		color: #A1A5B7;
	}

	.table-detail-header {
		font-family: Inter, Helvetica, sans-serif;
		font-size: 13px;
		font-weight: 600;
		line-height: 19.5px;
		text-decoration: none solid rgb(161, 165, 183);
		word-spacing: 0px;
		background-color: #FFFFFF;
		background-position: 0% 0%;
		color: #A1A5B7;
	}

	.table-detail-data{
			/* Font & Text */
	font-family: Inter, Helvetica, sans-serif;
	font-size: 14.95px;
	font-style: normal;
	font-variant: normal;
	font-weight: 600;
	letter-spacing: normal;
	line-height: 22.425px;
	text-decoration: none solid rgb(24, 28, 50);
	text-align: start;
	text-indent: 0px;
	text-transform: none;
	vertical-align: baseline;
	white-space: normal;
	word-spacing: 0px;

	/* Color & Background */
	background-attachment: scroll;
	background-color: rgba(0, 0, 0, 0);
	background-image: none;
	background-position: 0% 0%;
	background-repeat: repeat;
	color: rgb(24, 28, 50);

	/* List */
	list-style-image: none;
	list-style-type: disc;
	list-style-position: outside;

	/* Table */
	border-collapse: separate;
	border-spacing: 0px 0px;
	caption-side: top;
	empty-cells: show;
	table-layout: auto;

	/* Miscellaneous */
	overflow: visible;
	cursor: auto;
	visibility: visible;
	}
</style>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print</title>
</head>

<body>
	<div class="header-wrapper">
		<h4>NND0202230001</h4>
		<span id="name">Dear Tes Nama,</span><br>
		<span id="thankyou-text">Here are your order details. We thank you for your purchase.</span>
	</div>
	<hr>
	<div class="order-detail-wrapper">
		<table style="width: 100%;">
			<tr>
				<th class="table-detail-header">Tanggal</th>
				<th class="table-detail-header">Nama lengkap</th>
				<th class="table-detail-header" style="width: 30%;">Alamat</th>
				<th class="table-detail-header">Nomor HP</th>
			</tr>
			<tr>
				<td class="table-detail-data" style="text-align: center;"><?= date('d-m-Y'); ?></td>
				<td class="table-detail-data" style="text-align: center;">Renanda Auzan Firdaus</td>
				<td class="table-detail-data" style="text-align: center;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus ducimus corrupti tenetur reiciendis nobis quidem sequi totam, hic itaque. Voluptate porro similique, a eum magnam architecto incidunt et dolorem nulla.</td>
				<td class="table-detail-data" style="text-align: center;">081234567890</td>

			</tr>
		</table>
	</div>

</body>

</html>