<?php
require 'main.php';
$errors = null;

// Sign up
if(isset($_POST['signup'])){
    $first_name = htmlentities($_POST['name_1']);
    $last_name = htmlentities($_POST['name_2']);
    $email = htmlentities($_POST['mail']);
    $country =  $_POST['country'];
    $phone = htmlentities($_POST['phone']);
    $password_1 = htmlentities($_POST['password_1']);
    $password_2 = htmlentities($_POST['password_2']);
    $gender = $_POST['gender'];

    if($password_1 !== $password_2){
        $errors .= "Password 1 and 2 DON'T match!!";
    }else{
        $register = "SELECT * FROM users where user_email = ? Limit 1";
        $stmt = $connect->prepare($register);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $results = $stmt->get_result();
        $rnum = $results->num_rows;

        if($rnum  === 0){
            $pswdF = password_hash($password_1, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(50));
            $role = 'User';
            $name = $first_name.' '.$last_name;
            $date = date('Y-m-d');

            // insert into user table
            $user = "INSERT INTO users (user_names, user_gender, user_region, user_email, user_phone, registration_date) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt0 = $connect->prepare($user);
            $stmt0->bind_param("ssssss", $name, $gender, $country, $email, $phone, $date);
            
            // insert into log in table
            if ($stmt0->execute()) {
                $user_id = "SELECT user_ids FROM users WHERE user_email = '$email'";
                $stmt = $connect->query($user_id);
                $result = $stmt->fetch_assoc();

                $log_in = "INSERT INTO log_in (users_id, user_email, user_password, user_session, user_role) VALUES(?, ?, ?, ?, ?)";
                $stmt1 = $connect->prepare($log_in);
                $stmt1->bind_param("sssss", $result['user_ids'], $email,  $pswdF, $token, $role);
                if ($stmt1->execute()) {
                    $_SESSION['id'] = $token;
                    $_SESSION['userkey'] = $result['user_ids'];
                    $_SESSION['role'] = $role;

                    header('location: index.php');

                    $stmt1->close();
                    exit();
                }
            }
            else {
                $errors .= 'First table connection error';
            }
        }else{
            $errors .= 'Somebody else already registered using that email address';
        }
    }
}

// Logging in
else if(isset($_POST['login'])){
    $pEml = htmlentities($_POST['mail']);
    $Pswd = htmlentities($_POST['passwordz']);

    $SELECT = "SELECT * FROM log_in WHERE user_email = ? LIMIT 1";
    $stmt = $connect->prepare($SELECT);
    $stmt->bind_param("s", $pEml);
    $stmt->execute();
    $reslts = $stmt->get_result();
    $rnum = $reslts->num_rows;
    $user = $reslts->fetch_assoc();

    if (password_verify($Pswd, $user['user_password'])) {
        $_SESSION['id'] = $user['user_session'];
        $_SESSION['role'] = $user['user_role'];
        $_SESSION['userkey'] = $user['users_id'];

        header('location: index.php');
        $stmt->close();
        exit();
    } else {
        $errors = 'Incorrect email address or Password';
    }
}

// Change password
elseif(isset($_POST['clientchange'])){
    $newpassword = htmlentities($_POST['newpass']);
    $newpassword2 = htmlentities($_POST['newpass2']);
    if($newpassword !== $newpassword2){
        $errors = "The new password don't match";
    }else{
        $id = $_SESSION['userkey'];
        $old = htmlentities($_POST['oldpass']);

        $SELECT = "SELECT user_password FROM log_in WHERE users_id = ? LIMIT 1";
        $stmt = $connect->prepare($SELECT);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $reslts = $stmt->get_result();
        $rnum = $reslts->num_rows;
        $user = $reslts->fetch_assoc();

        if(password_verify($old, $user['user_password'])){
            $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
            $updatepassord = "UPDATE log_in SET user_password = ? WHERE users_id = '$id'";
            $query = $connect->prepare($updatepassord);
            $query->bind_param('s', $newpassword);
            if($query->execute()){
                ?>
                <script>
                    alert("Password Updated Successfully");
                </script>
                <?php
                $query->close();
                header('refresh: 0, profile.php');
                exit();
            }
        }else{
            $errors .= "Your old passwords do not match";
        }
    }

}

// User comments
elseif(isset($_POST['comments'])){
    $name = htmlentities($_POST['userFirst']).' '.htmlentities($_POST['userLast']);
    $mail = htmlentities($_POST['userMail']);
    $phone = htmlentities($_POST['userPhone']);
    $comment = htmlentities($_POST['userComment']);

    $load = $datafetch->save_comments($name, $mail, $phone, $comment);
    ?>
    <script>
        alert('Comment Submitted successfully you will get a feedback soon from the admin.')
    </script>
    <?php
    header('refresh: 0, index.php');
}

// Log Out
elseif (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['role']);
    unset($_SESSION['userKey']);

    header('location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Valuation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"> 
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/print.css" media="print"> 
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
    <header class="sticky-top mb-2">
        <nav class="navbar navbar-expand-md navbar-dark bg-light">
            <div class="container shadow">
                <img src="assets/images/valautions.jpg" alt="valuation" id="hImage1" class="nav-brand mx-5" width="50px" height="50px">
                <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#thisOne1"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="thisOne1">
                    <ul class="navbar-nav ms-auto">
                        <li class="navbar-item">
                            <a href="index.php" class="nav-link active text-dark">&#160; Home</a>
                        </li>                        
                        <?php
                            // User Logged In
                            if(isset($_SESSION['id'])){
                                if($_SESSION['role'] === "Admin"){
                                    ?>
                                    <li class="navbar-item">
                                        <a href="clients.php" class="nav-link text-dark">&#160; Clients</a>
                                    </li>
                                    <li class="navbar-item">
                                        <a href="comments.php" class="nav-link text-dark">&#160; Comments</a>
                                    </li>
                                    <?php
                                }elseif(isset($_SESSION['id'])){
                                    ?>
                                        <li class="navbar-item">
                                            <a href="contact.php" class="nav-link text-dark">&#160; Contact</a>
                                        </li>
                                    <?php
                                }
                                ?>
                                    <li class="navbar-item">
                                        <a href="valuations.php" class="nav-link text-dark">&#160; Valuations</a>
                                    </li>
                                    <li class="navbar-item">
                                        <a href="profile.php" class="nav-link text-dark">&#160; Profile</a>
                                    </li>
                                    <li class="navbar-item">
                                        <form action="" method="GET">
                                            <button class="btn btn-xs btn-outline-danger" name="logout">Log Out</button>
                                        </form>
                                    </li>
                                    &#160;
                                <?php
                            }
                            else{
                                ?>
                                    <li class="navbar-item">
                                        <a href="contact.php" class="nav-link text-dark">&#160; Contact</a>
                                    </li>
                                    <li class="navbar-item">
                                        <a href="login.php" class="nav-link text-dark">&#160; Log in</a>
                                    </li>
                                    <li class="navbar-item">
                                        <a href="signup.php" class="nav-link text-dark">&#160; Sign Up</a>
                                    </li>                           
                                    &#160;
                                <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>