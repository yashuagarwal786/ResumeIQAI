<?php

session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("Please login first.");
}

$resume = trim($_POST["resume"] ?? "");
$hasPdf = isset($_FILES["resume_pdf"]) && $_FILES["resume_pdf"]["error"] == UPLOAD_ERR_OK;

if ($resume == "" && !$hasPdf) {
    exit("No resume received.");
}

if ($hasPdf && $_FILES["resume_pdf"]["type"] != "application/pdf") {
    exit("Please upload only PDF file.");
}



$apiKey = getenv("GEMINI_API_KEY");
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey;





$prompt = "
You are an ATS Resume Analyzer.

Analyze this resume.

Return the answer in this format only.

ATS Score : __/100

Strengths
- Point 1
- Point 2
- Point 3

Weaknesses
- Point 1
- Point 2
- Point 3

Suggestions
- Point 1
- Point 2
- Point 3

Resume:




$resume
";

$parts = [
    [
        "text" => $prompt
    ]
];

if ($hasPdf) {
    $pdfData = base64_encode(file_get_contents($_FILES["resume_pdf"]["tmp_name"]));

    $parts[] = [
        "inline_data" => [
            "mime_type" => "application/pdf",
            "data" => $pdfData
        ]
    ];
}

$data = [
    "contents" => [
        [
            "parts" => $parts
        ]
    ]
];

$json = json_encode($data);






$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [


"Content-Type: application/json"

]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
$response = curl_exec($ch);

if ($response === false) {
    curl_close($ch);
    exit("Unable to connect with AI API.");
}

curl_close($ch);



$response = json_decode($response, true);
$result = $response["candidates"][0]["content"]["parts"][0]["text"] ?? "Unable to generate response.";


$userId = $_SESSION["user_id"];

$resumeTextForDB = $resume;

if ($hasPdf && $resumeTextForDB == "") {
    $resumeTextForDB = "PDF Uploaded: " . $_FILES["resume_pdf"]["name"];
} elseif ($hasPdf) {
    $resumeTextForDB .= "\n\nPDF Uploaded: " . $_FILES["resume_pdf"]["name"];
}

$insertHistory = mysqli_prepare(
    $conn,
    "INSERT INTO ao_history(user_id, resume_text, ai_response) VALUES(?, ?, ?)"
);

if (!$insertHistory) {
    http_response_code(500);
    exit("AI response generated, but history could not be saved: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($insertHistory, "iss", $userId, $resumeTextForDB, $result);

if (!mysqli_stmt_execute($insertHistory)) {
    http_response_code(500);
    exit("AI response generated, but history could not be saved: " . mysqli_stmt_error($insertHistory));
}

mysqli_stmt_close($insertHistory);


echo nl2br(htmlspecialchars($result));

?>
