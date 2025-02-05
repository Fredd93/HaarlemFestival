<?php

class BaseModel
{
    protected static $pdo;

    function __construct()
    {
        if (!self::$pdo) {
            // Fetch environment variables
            $driver = $_ENV["DB_DRIVER"] ?? "sqlsrv"; // Default to sqlsrv if not set
            $host = $_ENV["DB_HOST"] ?? "localhost";
            $db = $_ENV["DB_NAME"] ?? "database";
            $user = $_ENV["DB_USER"] ?? "sa";
            $pass = $_ENV["DB_PASSWORD"] ?? "";
            $port = $_ENV["DB_PORT"] ?? "1433"; // Default SQL Server port

            // SQL Server DSN
            $dsn = "$driver:Server=$host,$port;Database=$db";

            // PDO options
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::SQLSRV_ATTR_ENCODING    => PDO::SQLSRV_ENCODING_UTF8, // Ensure UTF-8 support
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("❌ Database Connection Failed: " . $e->getMessage());
            }
        }
    }
}
