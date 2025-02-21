<?php

$_ENV["DB_HOST"] = "haarlemfestival.database.windows.net";  // Azure SQL Server
$_ENV["DB_NAME"] = "haarlemprojectdatabase";
$_ENV["DB_USER"] = "HaarelmFestival";
$_ENV["DB_PASSWORD"] = "Haarlem1234";
$_ENV["DB_DRIVER"] = "sqlsrv";  // ✅ Ensure SQLSRV is explicitly set
$_ENV["DB_PORT"] = "1433";  // Default SQL Server port
$_ENV["DB_CHARSET"] = "utf8";  // ✅ Fix Undefined array key error
$_ENV["ENV"] = "LOCAL";
