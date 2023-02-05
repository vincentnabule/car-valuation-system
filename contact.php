<?php include_once 'inc/header.php'?>
<main class="container">
    <!-- Submission -->
    <section class="mb-2">
        <div class="card">
            <div class="text-center h4 mx-auto w-75">
                For any question or inquiry, kindly fill all the requored details in the form below
                and our team will get back to you.
            </div>
            <form action="" class="mx-auto mt-2" method="POST">
                <div class="form-layout-2">
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-5">First Name <span class="text-danger text-bold">*</span></label>
                        <input type="text" name="userFirst" class="form-input col-7" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-5">Last Name <span class="text-danger text-bold">*</span></label>
                        <input type="text" name="userLast" class="form-input col-7" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-5">Email Address <span class="text-danger text-bold">*</span></label>
                        <input type="email" name="userMail" class="form-input col-7" required>
                    </div>
                    <div class="form-group row m-1">
                        <label for="" class="form-label col-5">Phone <span class="text-danger text-bold">*</span></label>
                        <input type="text" class="form-input col-7" name="userPhone" required>
                    </div>
                    <div class="form-group row m-1 mt-4">
                        <label for="" class="form-label col-8">Question/Comment <span class="text-danger text-bold">*</span></label>
                    </div>                    
                </div>
                <div class="form-group m-1 d-flex">
                        <textarea name="userComment" rows="4" col="12" class="form-input w-100" placeholder="Question/Comment ....." required></textarea>
                    </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary w-50 mx-auto mb-2 mt-1" name="comments">Submit</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Social Media -->
    <section>
        <div class="h4 text-center">Social media</div>
        <div class="contacts">
            <ul class="d-flex justify-content-around social-icons">
                <!-- <li><a href="#"><i class="fa fa-envelope"></i></a></li> -->
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <!-- <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li> -->
                <li><a href="#"><i class="fa fa-paper-plane"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa-solid fa-phone"></i></a></li>
            </ul>
        </div>
    </section>
</main>

<?php include_once 'inc/footer.php'; ?>