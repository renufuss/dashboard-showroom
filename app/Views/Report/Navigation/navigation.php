<div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
    <!--begin:::Tabs-->
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
        <!--begin:::Tab item-->
        <li class="nav-item">
            <button class="nav-link text-active-primary pb-4 active" id="navCar">Mobil</button>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
        <button class="nav-link text-active-primary pb-4" id="navRefund">Refund</button>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <button class="nav-link text-active-primary pb-4" id="navGeneralIncome">Masuk Umum</button>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <button class="nav-link text-active-primary pb-4" id="navGeneralOutcome">Keluar Umum</button>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <button class="nav-link text-active-primary pb-4" id="navCalculation">Perhitungan</button>
        </li>
        <!--end:::Tab item-->
    </ul>
    <!--end:::Tabs-->
</div>

<script>
    $('#navCar').click(function (e) { 
        e.preventDefault();
        openTable('profitTableContainer','navCar', 'profitTable', 'searchProfit');
    });

    $('#navRefund').click(function (e) { 
        e.preventDefault();
        openTable('refundTableContainer','navRefund', 'refundTable', 'searchRefund');
    });

    $('#navGeneralIncome').click(function (e) { 
        e.preventDefault();
        openTable('generalIncomeTableContainer','navGeneralIncome', 'generalIncomeTable', 'searchGeneralIncome');
    });

    $('#navGeneralOutcome').click(function (e) { 
        e.preventDefault();
        openTable('generalOutcomeTableContainer','navGeneralOutcome', 'generalOutcomeTable', 'searchGeneralOutcome');
    });

    $('#navCalculation').click(function (e) { 
        e.preventDefault();
        hideAllTable();
        $('#generalCalculationContainer').removeClass('d-none');
        $('#navCalculation').addClass('active');
    });
</script>