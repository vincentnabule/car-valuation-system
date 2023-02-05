<?php
include_once 'inc/header.php';

if (isset($_POST['get_value'])) {
    $make = $_POST['c_make'];
    $model = $_POST['c_model'];
    $year = $_POST['years'];
    $fuel = $_POST['fuel_t'];
    $transmission = $_POST['auto_t'];
    $mileage = $_POST['mileage'];
    $engine = $_POST['engine'];
    $power = $_POST['power'];
    $seats = $_POST['seats'];
    $in_use = date('Y') - $year;

    // Calling the python script to load the model
    $fetch = escapeshellcmd("model.py $make $model $year $mileage $fuel $transmission  $engine $power $seats");
    $output = shell_exec($fetch);
    if ($output == null || $output == " ") {
        $output = "<p>Evaluation Failed</p>";
    }

    // Saving the valuation if user is logged in
    if (isset($_SESSION['id'])) {
        $datafetch->save_evaluation($make, $model, $year, $engine, $mileage, $power, $fuel, $transmission, $seats, $output);
    }
    ?>
        <section class="container">
            <div class="info_pop card">
                <div class="card-header  mb-0 w-100 d-flex justify-content-between">
                    <div class="h2 text-center ml-5"> Car Details </div>
                    <div class="mr-2 mt-1">
                        <button type="button" class="btn btn-danger btn-sm" id="close-pop">Close</button>
                    </div>
                </div>

                <div class="card-body mt-0">
                    <ul type="star" class="mx-auto text-center h5">
                        <li hidden>In use: <span class="text-primary" ><?= $in_use; ?></span></li>
                        <li>Car Make: <span class="text-primary"><?= $make; ?></span></li>
                        <li>Car Model: <span class="text-primary"><?= $model; ?></span></li>
                        <li>Manufacture Year:<span class="text-primary"> <?= $year; ?></span></li>
                        <li>Car Mileage: <span class="text-primary"><?= $mileage; ?></span></li>
                        <li>Fuel Type: <span class="text-primary"><?= $fuel; ?></span></li>
                        <li>Transmission: <span class="text-primary"><?= $transmission; ?></span></li>
                        <li>Engine Capacity: <span class="text-primary"><?= $engine; ?></span></li>
                        <li>Horse Power: <span class="text-primary"><?= $power; ?></span></li>
                        <li>Seats Number: <span class="text-primary"><?= $seats; ?></span></li>
                        <li>Predicted Value: <span class="h4 text-danger"><?= $output; ?></span> Kshs</li>
                    </ul>
                </div>
            </div>
            <style>
                .info_pop {
                    position: fixed;
                    z-index: 200;
                    width: 50%;
                    opacity: 0.9;
                    margin-left: 15%;
                }
            </style>
            <!-- Disabling the valuation button if user not logged in -->
            <?php
            if (!isset($_SESSION['id'])) {
                ?>
                    <script>
                        $('#close-pop').click(function() {
                            $('.info_pop').addClass('d-none');
                            $('#valuate').attr('hidden', true);
                            $('.more-valuation').prop('hidden', false);
                            $('.valuate-form .form-layout').prop('disabled', true);
                        });
                    </script>
                <?php
            } else {
                ?>
                    <script>
                        $('#close-pop').click(function() {
                            $('.info_pop').addClass('d-none');
                        });
                    </script>
                <?php
            }
            ?>
        </section>
    <?php
}
?>
<main class="container">
    <!-- Intro -->
    <section>
        <div class="row">
            <div class="col-md-5">
                <div class=" h2 text-center text-info">Car Valuation</div>
                <p class="mx-auto text-danger">Do you want to know the current market vale of your car ? <br>
                    <span class="text-dark mx-auto">Then you are in the right place</span>
                </p>
                <article>
                    Our system uses a machine learning model to predict the current market value of your car using some feature of your car. <br>
                    The system generates value with an accurancy of around <em>90%</em>.

                </article>

            </div>
            <div class="col-md-7">
                <div class="imgDiv">
                    <img src="assets/images/car-valuation.jpg" class="slideImage" alt="Car image">
                </div>
            </div>
        </div>
    </section>
    <!-- Valuation -->
    <section class="mt-2 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="h2 text-center mx-auto px-2">Get Valuation</div>
            </div>
            <form action="" class="mx-auto mt-2" method="POST">
                <div class="form-layout valuate-form">
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Car Make <span class="text-danger text-bold">*</span></label>
                        <select name="c_make" id="c_mk" class="form-input col-6" onchange="showmodels(this.value)" required>
                            <option value="" disabled selected>Select Make</option>
                            <?php
                                $makes = $datafetch->car_make();
                                foreach ($makes as $car) {
                                    ?>
                                        <option value="<?= $car['car_make'] ?>"><?= $car['car_make'] ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group row m-1" id="models">
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Year <span class="text-danger text-bold">*</span></label>
                        <input type="number" class="form-input col-6" name="years" max="<?= date("Y")?>" min="2005" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Engine CC <span class="text-danger text-bold">*</span></label>
                        <input type="text" class="form-input col-6" name="engine" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Car Mileage/KM <span class="text-danger text-bold">*</span></label>
                        <input type="text" class="form-input col-6" name="mileage" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Power(bhp) <span class="text-danger text-bold">*</span></label>
                        <input type="text" class="form-input col-6" name="power" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Fuel Type <span class="text-danger text-bold">*</span></label>
                        <select name="fuel_t" id="" class="form-input col-6" required>
                            <option value="">Select Fuel</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                            <option value="CNG">CNG</option>
                        </select>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Transmission <span class="text-danger text-bold">*</span></label>
                        <select name="auto_t" id="" class="form-input col-6" required>
                            <option value="" class="px-0">Select Transmission</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-6">Seats Number<span class="text-danger text-bold">*</span></label>
                        <input type="text" class="form-input col-6" name="seats" required>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-primary btn-md w-25" name="get_value" id="valuate">Valuate</button>
                    <button class="btn btn-secondary btn-md w-25 my-valuation more-valuation" hidden>My Valuations</button>
                </div>
            </form>
            <section>
                <div class="more-valuation" hidden>
                    <h4 class="text-danger text-center">To do more valuations, <a href="login.php">Log in</a> to your account or <a href="signup.php">sign up</a> if you are a new member.</h4>
                </div>
            </section>
        </div>
    </section>
</main>

<?php include_once 'inc/footer.php' ?>