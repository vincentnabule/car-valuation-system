<?php include_once 'inc/header.php'?>
<main class="container">
    <div class="card h2 text-center text-info p-1">User Questions and Comments.</div>
    <table class="table table-striped">
        <thead class="table-success">
            <th>User</th>
            <th>Phone Number</th>
            <th>Date</th>
            <th>Comment</th>
        </thead>
        <tbody>
            <?php
            $comment = $datafetch->get_data('comments');
            foreach($comment as $cmt){
                ?>
                <tr>
                    <td><?= $cmt['user_names']?></td>
                    <td><?= $cmt['user_phone']?></td>
                    <td class="w-50"><?= $cmt['user_comment']?></td>
                    <td><?= $cmt['comment_date']?></td>
                </tr>
                <?php
            }

            ?>
        </tbody>
    </table>
</main>
<?php include_once 'inc/footer.php'?>