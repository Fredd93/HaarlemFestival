<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scan QR Code</title>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <link rel="stylesheet" href="../../assets/css/qrScanStyle.css">
</head>
<body>

<h1>Scan QR Code</h1>
<div id="reader"></div>
<div id="result"></div>

<script>
    //https://www.geeksforgeeks.org/javascript/create-a-qr-code-scanner-or-reader-in-html-css-javascript/
    //Seems safe
    const resultEl = document.getElementById("result");

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        resultEl.textContent = `Scanned: ${decodedText}`;
    };

    const html5QrCode = new Html5Qrcode("reader");
    html5QrCode.start(
        { facingMode: "environment" },
        {
        fps: 10,
        qrbox: 250
        },
        qrCodeSuccessCallback
    ).catch(err => {
        resultEl.textContent = "Failed to start camera: " + err;
        resultEl.style.color = "red";
    });
</script>