<?php include_once 'inc/header.php'?>

<main class="container">
    <section class="page-title be-printed" hidden>
        <div class="d-flex justify-content-around">
            <div>
                <img src="assets/images/valautions.jpg" alt="no" width="200px" height="150px">
            </div>
            <div class="h1 text-center text-info" style="font-family: Algerian; font-size: 70px; margin-top: 30px;"><i> Car Valuation System.</i></div>
        </div>
        <hr class="mb-2 w-75 mx-auto bg-primary" style="height: 10px;">
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

    <section>
        <div class="h1 text-info text-center">System Users</div>
        <div class="not-printed">
            <div class="d-flex justify-content-end mb-1">
                <button class="btn btn-primary pt-0 mr-3  print-btn btn-sm">Print<i class="fa-sharp fa-solid fa-print p-2 val_links"></i></button>
            </div>
        </div>
        <table class="table table-striped">
            <thead class="table-success">
                <th>User</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Registration Date</th>
                <th>Evaluations Done</th>
            </thead>
            <tbody>
                <?php
                $users = $datafetch->get_data('users');
                foreach($users as $user){
                    ?>
                    <tr>
                        <td><?= $user['user_names']?></td>
                        <td><?= $user['user_gender']?></td>
                        <td><?= $user['user_phone']?></td>
                        <td><?= $user['user_email']?></td>
                        <td><?= $user['registration_date']?></td>
                        <td><?= $datafetch->count_valuations($user['user_ids'])?></td>
                    </tr>
                    <?php
                }

                ?>
            </tbody>
        </table>
    </section>
</main>
<footer style="font-weight: bold;">
    <div class="cRights d-block fixed-bottom">
        <div class="container blackBGy">
            <p class="text-dark"><i>© 2022 Copyright.</i><br>
                Terms and Conditions apply.
            </p>
        </div>
    </div>
</footer>
<!-- Printing -->
<script>
    $('.print-btn').click(function() {
        $('.be-printed').prop('hidden', false);
        $('.not-printed').addClass('d-none');
        window.print();
        $('.be-printed').prop('hidden', true);
        $('.not-printed').removeClass('d-none');
    });
</script>
