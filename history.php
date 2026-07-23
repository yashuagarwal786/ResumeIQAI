<?php

session_start();

if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$userId = $_SESSION["user_id"];


$historyStmt = mysqli_prepare($conn, "SELECT * FROM ao_history WHERE user_id = ? ORDER BY id DESC");
if ($historyStmt) {
    mysqli_stmt_bind_param($historyStmt, "i", $userId);
    mysqli_stmt_execute($historyStmt);
    $historyResult = mysqli_stmt_get_result($historyStmt);
} else {
    $historyResult = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Analysis | ResumeIQ AI</title>

    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body class="app-bg">

    <nav class="navbar navbar-expand-lg app-navbar border-bottom shadow-sm">
        <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary" href="index.php">
            <img src="logo.png" alt="ResumeIQ AI logo" width="48" height="48" class="rounded">
            
            <span>
                <span class="d-block">ResumeIQ AI</span>
                <small class="text-muted fw-normal">ATS Resume Analyzer</small>
            </span>
        </a>

        <div class="navbar-nav ms-auto flex-row gap-2">

            <a class="nav-link" href="index.php">Analyzer</a>
            <a class="btn btn-primary" href="logout.php">Logout</a>

        </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">

            <h1>My Resume Analysis</h1>

            <p class="text-muted mb-0">All resume reports saved under your account.</p>
            </div>
        </div>

        <?php if (mysqli_num_rows($historyResult) == 0) { ?>
            <div class="card shadow-sm">
                <div class="card-body">
                <p class="mb-0">No analysis found. <a href="index.php">Analyze your resume</a>.</p>
                </div>
            </div>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($historyResult)) { ?>

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                <h2>Analysis Result</h2>

                <pre class="bg-light border rounded p-3"><?php echo htmlspecialchars($row["ai_response"]); ?></pre>
                
                <details>

                    <summary>View Resume Text</summary>
                    <pre class="bg-light border rounded p-3 mt-2"><?php echo htmlspecialchars($row["resume_text"]); ?></pre>
                </details>
                </div>

            </div>
        <?php } ?>
    </main>

    <footer class="container py-3 text-muted small">

        <div class="d-md-flex justify-content-between">
            <div>

                <strong class="text-dark">ResumeIQ AI</strong>
                <span class="d-block">Your saved resume reports stay connected to your account.</span>
            </div>
            
            <p class="mb-0">2026 | Copyrights Reserved By Yash Agarwal</p>
        </div>
    </footer>
</body>
</html>
