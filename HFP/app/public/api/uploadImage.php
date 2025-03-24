<?php
header("Content-Type: application/json");

$uploadDir = __DIR__ . "/../assets/uploads/";
$uploadUrl = "/assets/uploads/";

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
