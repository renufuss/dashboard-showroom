<style>
table {
    border-left: 0.01em solid #ccc;
    border-right: 0;
    border-top: 0.01em solid #ccc;
    border-bottom: 0;
    border-collapse: collapse;
}
table td,
table th {
    border-left: 0;
    border-right: 0.01em solid #ccc;
    border-top: 0;
    border-bottom: 0.01em solid #ccc;
}

td{
    text-align: center;
}

.text-end {
  text-align:right;
}

h1{
    text-align: center;
    font-family:Verdana, Geneva, Tahoma, sans-serif;
}


.image-car{
    width: 500px;
    height: 290px;
    border-radius: 20px;
}

.detail-mobil{
    position: absolute;
    top: 80;
    right: 0;
    left: 400;
}

.text{
    margin-top: 20px;
}

.text-detail{
    left:70;
    position: absolute;
}

.text-bold{
    font-weight: 600;
}

h2{
    text-align: center;
    font-family:Verdana, Geneva, Tahoma, sans-serif;
    font-size: 15pt;
}

.image-receipt-wrapper{
    width: 100%;
    text-align: center;
}

.image-receipt{
    border-radius: 10px;
    height: 240px;
    width: 60%;
}

.pengeluaran-tambahan{
    margin-bottom: 20px;
}

.total-pengeluaran-tambahan{
    text-align: center;
    margin-bottom: 20px;
}

.total{
    text-align: center;
}
    
</style>

<div class="wrapper">
    <div class="wrapper-general">
        <div class="title">
            <h1>Detail Mobil</h1>
        </div>
        <div style="font-size: 12pt; text-align:center; margin-bottom:10px;">Dicetak Pada <?php echo date('d-m-Y H:i:s'); ?></div>
        <div class="image-car-wrapper">
            <img class="image-car" src="data:image/png;base64,<?php echo $car->car_image; ?>" alt="Car Image">
        </div>
        <div class="detail-mobil">
            <div class="text">
                <div class="text-title">Nama Mobil
                    <span class="text-detail"> : <span class="text-bold"><?php echo $car->car_name; ?></span></span>
                </div>
            </div>
            <div class="text">
                <div class="text-title">Warna
                    <span class="text-detail"> : <span class="text-bold"><?php echo $car->car_color; ?></span></span>
                </div>
            </div>
            <div class="text">
                <div class="text-title">Tahun
                    <span class="text-detail"> : <span class="text-bold"><?php echo $car->car_year; ?></span></span>
                </div>
            </div>
            <div class="text">
                <div class="text-title">Plat Nomor
                    <span class="text-detail"> : <span class="text-bold"><?php echo $car->license_number; ?></span></span>
                </div>
            </div>
            <div class="text">
                <div class="text-title">Brand
                    <span class="text-detail"> : <span class="text-bold"><?php echo $car->car_brand; ?></span></span>
                </div>
            </div>
            <div class="text">
                <div class="text-title">Harga
                    <span class="text-detail"> : <span class="text-bold">Rp <?php echo number_format($car->capital_price, '0', ',', '.'); ?></span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="bukti-pembelian">
        <h2>
            Bukti Pembelian
        </h2>
        <div class="image-receipt-wrapper">
            <img class="image-receipt" src="data:image/png;base64,<?php echo $car->receipt; ?>" alt="Car Image">
        </div>
    </div>
    <div class="pengeluaran-tambahan">
        <h2>
            Pengeluaran Tambahan
        </h2>
        <div class="table-pengeluaran-tambahan">
            <?php require APPPATH.'Views/Car/Detail/Table/additionalCostTable.php'; ?>
        </div>
    </div>
    <div class="total-pengeluaran-tambahan">Total Pengeluaran Tambahan : <?php echo 'Rp '.number_format(($car->totalAdditionalCost), '0', ',', '.'); ?></div>
    <div class="text-bold total">Total : <?php echo 'Rp '.number_format(($car->totalAdditionalCost + $car->capital_price), '0', ',', '.'); ?></div>
    
</div>
