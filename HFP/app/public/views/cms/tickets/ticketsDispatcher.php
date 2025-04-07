<?php
if (!isset($eventType)) {
    echo "Fout: Geen event type opgegeven.";
    exit;
}

$eventType = strtolower(trim($eventType));

if (!preg_match('/^[a-z0-9_-]+$/', $eventType)) {
    echo "Fout: Ongeldige tekens in event type.";
    http_response_code(400);
    exit;
}

$pagePath = __DIR__ . "/$eventType.php";

// Check if file exists
if (file_exists($pagePath)) {
    require_once $pagePath;
} else {
    echo "Fout: Ticketpagina '$eventType.php' bestaat niet.";
    http_response_code(404);
}
?>
