<?php

include("db_connect.php");
include("checkRegistrationError.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ResumeIQ AI</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="app-bg">

    <nav class="navbar app-navbar border-bottom shadow-sm">
        <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary" href="registration.php">

            <img src="logo.png" alt="ResumeIQ AI logo" width="48" height="48" class="rounded">
            
            <span>
                <span class="d-block">ResumeIQ AI</span>
                <small class="text-muted fw-normal">ATS Resume Analyzer</small>
            </span>

        </a>

        <a class="btn btn-outline-primary" href="login.php">Login</a>
        </div>
    </nav>

    <main class="container py-5">

        <div class="row justify-content-center">

        <form action="registration.php" method="post" class="card shadow-sm col-12 col-sm-9 col-md-6 col-lg-5">
            <div class="card-body">

            <h3>Register</h3>

            <p class="text-muted">Create your account to save resume analysis history.</p>

            <?php if ($error != "") { ?>
                <div class="alert alert-danger py-2"><?=$error?></div>
            <?php } ?>

            <input type="text" class="form-control mb-3" placeholder="Name" name="name" value="<?=$name?>">
            <input type="email" class="form-control mb-3" placeholder="Email" name="email" value="<?=$email?>">
            <input type="password" class="form-control mb-3" placeholder="Password" name="password" value="<?=$password?>">
            <input type="password" class="form-control mb-3" placeholder="Confirm Password" name="confirmPassword" value="<?=$confirmPassword?>">

            <button class="btn btn-primary w-100">Register</button>

            <p class="text-center mt-3 mb-0">Already registered? <a href="login.php">Login</a></p>
            </div>
        </form>
        </div>

    </main>

    <footer class="container py-3 text-muted small">

        <div class="d-md-flex justify-content-between">
            <div>

                <strong class="text-dark">ResumeIQ AI</strong>
                <span class="d-block">Smarter resume analysis for better applications.</span>
            </div>
            <p class="mb-0">2026 | Copyrights Reserved By Yash Agarwal</p>
        </div>
        
    </footer>
</body>
</html>
