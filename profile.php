<?php include_once 'inc/header.php'; ?>

<main class="container">
    <section>
        <center>
            <div class="imgcontainer">
                <img src="assets/images/P.png" alt="Avatar" class="avatar">
            </div>
        </center>
        <section id="infos" class="card mx-auto w-50">
            <?php
            $users = $datafetch->user_profile($_SESSION['userkey']);
            foreach ($users as $user) {
                $country = $datafetch->my_country($user['user_region']);
            ?>
                <div id="info">
                    <p>Name: <?= $user['user_names']; ?></p>
                    <p>Gender: <?= $user['user_gender']; ?></p>
                    <p>Country: <?= $country; ?></p>
                    <p>Contact: <?= $user['user_phone']; ?></p>
                    <p>Email: <?= $user['user_email']; ?></p>
                    <p>Registration Date: <?= $user['registration_date']; ?></p>
                </div>

            <?php
            }
            ?>
        </section>
        <section>
            <div class="row g-2 mb-5">
                <div class="col-4 card">
                    <h6 class="text-center h3">Change password</h6>
                    <div class="signup-form mb-2">
                        <form action="" method="post">
                            <div class="text-center" style="color: red;">
                                <?= $errors; ?>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 form-label">Old password <b class="text-danger">*</b></label>
                                <input type="password" class="form-input col-6" name="oldpass" required="required">
                            </div>
                            <div class="form-group row">
                                <label class="col-6 form-label">New password <b class="text-danger">*</b></label>
                                <input type="password" class="form-input col-6" name="newpass" required="required" minlength="8">
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-6">Confirm password <b class="text-danger">*</b></label>
                                <input type="password" class="form-input col-6" name="newpass2" required="required" minlength="8">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-lg bg-primary mt-2" name="clientchange">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-8 card">
                    <h6 class="text-center h2">Update user details</h6>
                    <div class="signup-form">
                        <form action="" method="POST">
                            <?php
                            $users = $datafetch->user_profile($_SESSION['userkey']);
                            foreach ($users as $user) {
                            ?>
                                <div class="form-group row">
                                    <label class="col-5">Username (First and Last) <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control col-5" name="username" required="required" value="<?= $user['user_names']; ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="formFileMultiple" class="form-label col-5">Gender <b class="text-danger">*</b></label>
                                    <select name="gender" class="form-select col-5" aria-label="Disabled select example" required>
                                        <option selected value="<?= $user['user_gender']; ?>"><?= $user['user_gender']; ?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-5">Phone Number <b class="text-danger">*</b></label>
                                    <input type="text" class="form-input col-5" name="phone" required="required" value="<?= $user['user_phone']; ?>">
                                </div>
                                <div class="form-group row">
                                    <label class="col-5">Email Address <b class="text-danger">*</b></label>
                                    <input type="email" class="form-input col-5" name="email" required="required" value="<?= $user['user_email']; ?>">
                                </div>
                            <?php
                            }
                            ?>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-blocky btn-lg mt-2 mb-2 w-50" name="updateDetails">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</main>

<?php include_once 'inc/footer.php'; ?>