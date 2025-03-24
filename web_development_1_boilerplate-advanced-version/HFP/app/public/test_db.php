<?php
$serverName = "tcp:haarlemfestival.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "haarlemprojectdatabase",
    "Uid" => "HaarelmFestival",
    "PWD" => "Haarlem1234"
);

// Establishes the connection
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=haarlemprojectdatabase", "HaarelmFestival", "Haarlem1234");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to Azure SQL Server!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
