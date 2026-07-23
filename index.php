<?php

session_start();

if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResumeIQ AI</title>
    <link rel="stylesheet" href="bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

            <a class="nav-link" href="#analyzer">Analyzer</a>

            <a class="nav-link" href="history.php">My Analysis</a>
            <a class="btn btn-primary" href="logout.php">Logout</a>

        </div>

        </div>
    </nav>

    <main class="container py-4" id="analyzer">

        <section class="mb-4">

            <p class="text-primary fw-semibold text-uppercase small mb-2">Welcome, <?=$_SESSION["user_name"]?></p>

            <h1 class="fw-bold">Improve your resume with instant AI-powered ATS analysis.</h1>
            <p class="text-muted">

                Paste your resume, check the score, review strengths and weaknesses, and make your next application sharper.
            </p>

            <div class="row g-3">

                <div class="col-md-4">
                    <div class="bg-white border rounded p-3">

                        <strong class="d-block fs-5">ATS</strong>
                        <span class="text-muted small">Score</span>

                    </div>
                </div>
                <div class="col-md-4">

                    <div class="bg-white border rounded p-3">

                        <strong class="d-block fs-5">3x</strong>

                        <span class="text-muted small">Feedback Areas</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bg-white border rounded p-3">

                        <strong class="d-block fs-5">AI</strong>

                        <span class="text-muted small">Suggestions</span>
                    </div>
                </div>
            </div>

        </section>

        <div class="card shadow-sm mb-4">

            <div class="card-body">

            <h2 class="card-title">AI Resume Feedback Helper</h2>

            <p class="text-muted">
                Upload your resume PDF or paste your resume text below to get an instant AI analysis.
            </p>

            <label class="form-label " for="resumePdf">Upload Resume PDF</label>
            <input class="form-control mb-2" type="file" id="resumePdf" accept="application/pdf">

            <div id="selectedFile" class="text-muted small mb-3">No PDF selected</div>

            <div class="text-center text-muted small fw-semibold mb-3">OR</div>

            <textarea id="resume" class="form-control" rows="10" placeholder="Paste your Resume Here..."></textarea>
            <button id="analyzeBtn" class="btn btn-primary btn-lg w-100 mt-3">
                Analyze Resume
            </button>
            <div id="loading" class="alert alert-info mt-3 text-center">
                 AI is analyzing your resume...
            </div>
            </div>
        </div>

        <div class="card shadow-sm" id="resultPanel">

            <div class="card-body">

            <h2 class="card-title">Analysis Result</h2>
            <pre id="result" class="bg-light border rounded p-3 mb-0">Your AI response will appear here...</pre>
            </div>
        </div>
    </main>

    <footer class="container py-3 text-muted small">
        <div class="d-md-flex justify-content-between">
            <div>
                <strong class="text-dark">ResumeIQ AI</strong>

                <span class="d-block">AI-powered ATS insights, strengths, weaknesses, and suggestions.</span>
            </div>
            <p class="mb-0">2026 | Copyrights Reserved By Yash Agarwal</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
