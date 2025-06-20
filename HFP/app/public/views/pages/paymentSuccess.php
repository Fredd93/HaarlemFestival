<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/paymentSuccess.css">
    <link rel="stylesheet" href="/assets/css/navBarStyle.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <title>Document</title>
</head>
<body>
    <?php
    $activePage = 'dance';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>

    <div class="page-wrapper">
        <main class="container">
            <h1>🎉 Payment Successful!</h1>
            <h2>Check your email for your ticket.</h2>
            <a href="/" class="btn">Go to Homepage</a>
        </main>

        <?php require(__DIR__ . "/../partials/footer.php"); ?>
    </div>
</body>
</html>