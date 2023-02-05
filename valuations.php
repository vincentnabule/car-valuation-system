<?php include_once 'inc/header.php' ?>

<main class="container">
    <section class="page-title be-printed" hidden>
        <div class="d-flex justify-content-around">
            <div>
                <img src="assets/images/valautions.jpg" alt="no" width="200px" height="150px">
            </div>
            <div class="h1 text-center text-info" style="font-family: Algerian; font-size: 70px; margin-top: 30px;"><i> Car Valuation System.</i></div>
        </div>
        <hr class="mb-2 w-75 mx-auto bg-primary" style="height: 5px;">

        <?php
        $users = $datafetch->user_profile($_SESSION['userkey']);
        foreach ($users as $user) {
        ?>
            <div class="d-flex justify-content-end report-info">
                <ul class="d-block">
                    <li>User: <?= $user['user_names']; ?></li>
                    <li>Report Date: <?= date('d / m / Y'); ?></li>
                    <li>Report Time: <?= date('h : i A', strtotime('+3 hours')); ?></li>
                </ul>
            </div>
        <?php
        }
        ?>
    </section>
    <div class="card h1 text-center text-info">My Evaluations <br>
        <span class="h5 text-dark">All Evaluation Done: <?= $datafetch->count_valuations($_SESSION['userkey'])?></span>
    </div>
    <section class="row not-printed">
        <div class="col-7">
            <form action="" class="mb-2 card">
                <div class="h3 p-2 text-center">Filter valuations</div>
                <div class="d-flex justify-content-around mt-2 mb-3">
                    <div class="form-layout d-block">
                        <div class="form-label">From Date <i class="fa-regular fa-calendar-days" style="font-size: 20px;"></i></div>
                        <input type="date" class="form-input" id="start_date" min="<?= date("2022-10-10")?>" max="<?= date("Y-m-d")?>" value="<?php if (isset($_GET['filter'])) { echo $_GET['start_date']; } ?>" onchange="show_two();">
                    </div>
                    <div class="form-layout d-block">
                        <div class="form-label">To Date <i class="fa-regular fa-calendar-days" style="font-size: 20px;"></i></div>
                        <input type="date" class="form-input" id="stop_date" min="<?= date("2022-10-10")?>" max="<?= date("Y-m-d")?>"  value="<?php if (isset($_GET['filter'])) { echo $_GET['stop_date']; } ?>" onchange="show_three();" disabled>
                    </div>
                    
                </div>
                <div class="d-block mx-auto">
                    <p class="btn btn-primary" id="filter_dt" hidden>Filter Valuations</p>
                </div>
            </form>
        </div>
        <div class="col-5">
            <div class="h3 p-2 text-center mb-0">Print & Download</div>
            <hr class="mt-0 w-75 bg-primary mx-auto">
            <div class="d-flex justify-content-around">
                <!-- <button class="btn btn-danger pt-0 mr-3 md">Pdf<i class="fa-sharp fa-solid fa-file-pdf p-2 val_links"></i></button> -->
                <!-- <button class="btn btn-success pt-0 mr-3 md">Excel<i class="fa-sharp fa-solid fa-file-excel p-2 val_links"></i></button> -->
                <button class="btn btn-primary pt-0 mr-3 md print-btn">Print<i class="fa-sharp fa-solid fa-print p-2 val_links"></i></button>
            </div>
        </div>
    </section>
    
    <section>
        <div class="table_section"></div>
        <table class="table table-striped table-bordered table_one">
            <thead class="table-primary">
                <th scope="col">Car Make</th>
                <th scope="col">Car Model</th>
                <th scope="col">Year</th>
                <th scope="col">Engine</th>
                <th scope="col">Mileage</th>
                <th scope="col">Power</th>
                <th scope="col">Fuel Type</th>
                <th scope="col">Transmission</th>
                <th scope="col">Seats</th>
                <th scope="col">Price</th>
            </thead>
            <tbody>
                <?php
                $valuations = $datafetch->my_valuation($_SESSION['userkey']);
                foreach ($valuations as $val) {
                ?>
                    <tr>
                        <td><?= ucfirst(strtolower($val['car_make'])); ?></td>
                        <td><?= ucfirst(strtolower($val['car_model'])); ?></td>
                        <td><?= $val['manufacture_year']; ?></td>
                        <td><?= number_format($val['car_engine'], 0, '.', ','); ?> CC</td>
                        <td><?= number_format($val['mileage'], 0, '.', ','); ?></td>
                        <td><?= $val['car_power']; ?> bhp</td>
                        <td><?= $val['fuel_type']; ?></td>
                        <td><?= $val['transmission']; ?></td>
                        <td><?= $val['seats']; ?></td>
                        <td><?= number_format($val['predicted_amount'], 2, '.', ','); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</main>
<footer style="font-weight: bold;" class="be-printed" hidden>
    <div class="cRights d-block fixed-bottom">
        <div class="container blackBGy">
            <p class="text-dark"><i>© 2022 Copyright.</i><br>
                Terms and Conditions apply.
            </p>
        </div>
    </div>
</footer>

<script>
    $('#filter_dt').click(function() {
        var start_date = $('#start_date').val();
        var stop_date = $('#stop_date').val();
        var date_range = start_date + ' ' + stop_date;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('.table_section').html(this.responseText);
                console.log(this.responseText);
            }
        };

        xmlhttp.open("GET", "value.php?t=" + date_range, true);
        xmlhttp.send();
        $('.table_one').prop('hidden', true);
    });

    function show_two() {
        $('#stop_date').prop('disabled', false);
    }

    function show_three() {
        $('#filter_dt').prop('hidden', false);
    }
</script>
<!-- Printing -->
<script>
    $('.print-btn').click(function() {
        $('.be-printed').prop('hidden', false);
        $('.not-printed').addClass('d-none');
        $('footer .not-printed').addClass('d-none');
        window.print();
        $('.be-printed').prop('hidden', true);
        $('.not-printed').removeClass('d-none');
        $('footer .not-printed').removeClass('d-none');
    });
</script>