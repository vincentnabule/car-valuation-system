<?php include_once 'inc/header.php' ?>
    <main class="container mb-5">
        <div class="card mb-2 w-50 mx-auto shadow-sm" style="margin-top: 100px;">
            <form action="" method="post" class="mt-2">
                <div class="text-danger text-center" style="margin-bottom: 5px;"><?= $errors; ?></div>
                <div class="form-group d-flex justify-content-around">
                    <label for="#" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-input row-cols-5" name="mail" value="<?php if(isset($_POST['login'])){ echo $_POST['mail']; }?>" required>
                </div>
                <div class="form-group d-flex justify-content-around">
                    <label for="" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-input row-cols-5" name="passwordz" required>
                </div>
                <div class="d-flex justify-content-around">
                    <button class="btn btn-primary w-75" name="login">Log In</button>
                </div>
                <div class="d-flex justify-content-around">
                    <p class="mt-3"><a href="#">Foget Password?</a></p>
                    <p>Don't have an account? <br><a href="signup.php">Create account</a></p>
                </div>
            </form>
        </div>
    </main>