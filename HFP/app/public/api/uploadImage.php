<?php
header("Content-Type: application/json");

$page = $_POST["page"] ?? "default";
$page = preg_replace("/[^a-zA-Z0-9_-]/", "", strtolower($page)); // Sanitize

$uploadDir = __DIR__ . "/../assets/images/{$page}/";
$uploadUrl = "/assets/images/{$page}/";

// Ensure the folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES["file"];
$filename = time() . "_" . basename($file["name"]);
$targetPath = $uploadDir . $filename;

if (move_uploaded_file($file["tmp_name"], $targetPath)) {
    echo json_encode(["success" => true, "fileUrl" => $uploadUrl . $filename]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to upload image"]);
}
?>
