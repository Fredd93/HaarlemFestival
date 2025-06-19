<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Page</title>
  <link rel="stylesheet" href="../../assets/css/paymentPage.css">
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../../assets/js/stripePayment.js"></script>
</head>
<body>

  <?php   $activePage = 'tickets'; require_once(__DIR__ . "/../partials/navbar.php"); ?>
  <div class="payment-container">
    
  <button id="checkout" class="pay-btn">Confirm and Pay</button>

  <script>
    var stripe = Stripe(
      "pk_test_51RP6DB2NUICtS7JXogct449MpayKlKOCM1FnNQ8IIBe7ZLZNXqclG2nkGh3OOj54id5xiziOLCEgWHA9dTH0HuRy00i9r8HfXd"
    );

    document.getElementById("checkout").addEventListener("click")
  </script>

    <div class="personal-program">
      <h2>Personal program</h2>
    </div>
  </div>

  
</body>
</html>