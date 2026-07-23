<?php

$error = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email == "" || $password == "") {
        $error = "All fields are required";
    } else {
        

        $loginStmt = mysqli_prepare($conn, "SELECT id, name, email, password FROM user WHERE email = ?");
        
        if ($loginStmt) {
            mysqli_stmt_bind_param($loginStmt, "s", $email);
            mysqli_stmt_execute($loginStmt);
            $result = mysqli_stmt_get_result($loginStmt);
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user["password"])) {
                session_start();

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                mysqli_stmt_close($loginStmt);
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password";
            }
            mysqli_stmt_close($loginStmt);
        } else {
            $error = "Database error. Please try again.";
        }
    }
}

?>
