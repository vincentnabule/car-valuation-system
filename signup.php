<?php include_once 'inc/header.php'; ?>
<main class="container">
    <div class="text-center h3">
        Sign Up form <span class="h6 text-info mt-1"><br>Fill in your details in the form below to create an accountant</span>
    </div>

    <div class="card w-50 mx-auto mt-4 mb-3">
        <form class="p-1" action="" method="POST">
            <div class="text-danger text-center" style="margin-bottom: 5px;"><?= $errors; ?></div>
            <div class="form-group mt-2 row">
                <label for="" class="form-label col-6" >First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-input col-5" name="name_1" value="<?php if(isset($_POST['signup'])){ echo $_POST['name_1']; }?>" required>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-input col-5" name="name_2" value="<?php if(isset($_POST['signup'])){ echo $_POST['name_2']; }?>" required>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Gender: <span class="text-danger">*</span></label>
                <select name="gender" id="" class="col-5" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Residence <span class="text-danger">*</span></label>
                <select name="country" id="" class="col-5" required>
                    <option value="" disabled selected>Select Country</option>
                    <?php
                    $country = $datafetch->country();
                    foreach ($country as $con) {
                    ?>
                        <option value="<?= $con['country_id']; ?>"><?= $con['name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Contact <span class="text-danger">*</span></label>
                <input type="text" class="form-input col-5" name="phone" value="<?php if(isset($_POST['signup'])){ echo $_POST['phone']; }?>" required>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-input col-5" name="mail" value="<?php if(isset($_POST['signup'])){ echo $_POST['mail']; }?>" required>
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-input col-5" name="password_1" minlength="2">
            </div>
            <div class="form-group row">
                <label for="" class="form-label col-6">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-input col-5" name="password_2" minlength="2">
            </div>

            <div class="d-flex justify-content-center">
                <button class="btn btn-primary w-75" name="signup">Register</button>
            </div>
            <div class="d-flex mt-2 justify-content-center">Already have an account? Log in <a href="login.php">&#160; Here</a></div>
        </form>
    </div>
</main>
<?php include_once 'inc/footer.php'; ?>