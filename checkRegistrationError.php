<?php

$error = "";
$name = "";
$email = "";
$password = "";
$confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    if ($name == "" || $email == "" || $password == "" || $confirmPassword == "") {
        $error = "All fields are required";

    } elseif ($password != $confirmPassword) {
        $error = "Password does not match";
    } else {
        
        $checkStmt = mysqli_prepare($conn, "SELECT id FROM user WHERE email = ?");
        if ($checkStmt) {
            mysqli_stmt_bind_param($checkStmt, "s", $email);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_store_result($checkStmt);

            if (mysqli_stmt_num_rows($checkStmt) > 0) {
                $error = "Email already registered";
            } else {
                mysqli_stmt_close($checkStmt);

                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                
                $insertStmt = mysqli_prepare($conn, "INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
                
                if ($insertStmt) {
                    mysqli_stmt_bind_param($insertStmt, "sss", $name, $email, $hashedPassword);

                    if (mysqli_stmt_execute($insertStmt)) {
                        session_start();

                        $_SESSION["user_id"] = mysqli_stmt_insert_id($insertStmt);
                        $_SESSION["user_name"] = $name;
                        $_SESSION["user_email"] = $email;

                        mysqli_stmt_close($insertStmt);
                        header("Location: index.php");
                        exit();
                    } else {
                        $error = "Error occurred while storing data";
                    }
                    mysqli_stmt_close($insertStmt);
                } else {
                    $error = "Database error. Please try again.";
                }
            }
        } else {
            $error = "Database error. Please try again.";
        }
    }
}

?>
