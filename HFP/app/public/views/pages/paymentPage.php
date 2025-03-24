<?php
$activePage = 'dance';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Page</title>
  <link rel="stylesheet" href="../../assets/css/paymentPage.css">
</head>
<body>
  <div class="progress-bar-wrapper">
    <script src="../../assets/js/progress-bar.js"></script>
  </div>

  <div class="payment-container">
    <div class="payment-form">
    <h2>Complete your payment</h2> 
    <div class="payment-methods">
      <button class="payment-method active">
        <img src="../../assets/images/payment/card.jpg" alt="Card">
        <span>Card</span>
      </button>
      <button class="payment-method">
        <img src="../../assets/images/payment/Ideal.jpg" alt="iDeal">
        <span>iDeal</span>
      </button>
      <button class="payment-method">
        <img src="../../assets/images/payment/PayPal.jpg" alt="PayPal">
        <span>PayPal</span>
      </button>
    </div>


      <form id="paymentForm">
          <input type="email" placeholder="Email" required>
          <input type="text" placeholder="1234 1234 1234 1234" maxlength="19" required>
          <div class="half-inputs">
            <input type="text" placeholder="MM / YY" maxlength="5" required>
            <input type="text" placeholder="CVC" maxlength="4" required>
          </div>
          <select required>
            <option value="Netherlands">Netherlands</option>
          </select>
          <input type="text" placeholder="Postal code" required>
          <button type="submit" class="pay-btn">Confirm and Pay</button>
      </form>
    </div>

    <div class="personal-program">
      <h2>Personal program</h2>
    </div>
  </div>
  <script src="../../assets/js/payment.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/country-list-js@2.2.0/dist/country-list.min.js"></script>
</body>
</html>
