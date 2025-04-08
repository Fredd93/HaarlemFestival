<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Page</title>
  <link rel="stylesheet" href="../../assets/css/paymentPage.css">
</head>
<body>

  <?php   $activePage = 'tickets'; require_once(__DIR__ . "/../partials/navbar.php"); ?>

  <div class="progress-bar-wrapper">
    <script src="../../assets/js/progress-bar.js"></script>
  </div>

  <div class="payment-container">
    <div class="payment-form">
      <h2>Complete your payment</h2>

      <div class="payment-methods">
        <button class="payment-method active"><img src="../../assets/images/payment/card.jpg" alt="Card"><span>Card</span></button>
        <button class="payment-method"><img src="../../assets/images/payment/Ideal.jpg" alt="iDeal"><span>iDeal</span></button>
        <button class="payment-method"><img src="../../assets/images/payment/PayPal.jpg" alt="PayPal"><span>PayPal</span></button>
      </div>

      <form id="paymentForm">
        <input type="email" id="email" placeholder="Email" required><br><br>

        <div style="position: relative;">
          <div id="card-number" style="padding-right: 120px;"></div>
          <div id="card-brand-icons" style="position: absolute; right: 10px; top: 10px; display: flex; gap: 6px; align-items: center;">
            <img class="brand-icon visa" src="../../assets/images/payment/visa.jpg" alt="Visa" style="height: 24px;">
            <img class="brand-icon mastercard" src="../../assets/images/payment/mastercard.jpg" alt="Mastercard" style="height: 24px;">
            <img class="brand-icon amex" src="../../assets/images/payment/amex.jpg" alt="Amex" style="height: 24px;">
            <img class="brand-icon discover" src="../../assets/images/payment/discover.jpg" alt="Discover" style="height: 24px;">
          </div>
        </div>

        <div id="card-expiry"></div><br>
        <div id="card-cvc"></div><br>
        <div id="card-errors" role="alert"></div><br>

        <button id="submitBtn" class="pay-btn">Confirm and Pay</button>
      </form>
    </div>

    <div class="personal-program">
      <h2>Personal program</h2>
    </div>
  </div>

  <script src="https://js.stripe.com/v3/"></script>
  <script>
    const stripe = Stripe("pk_test_51R7EjiPumD0Cps48MMPPpgpELGqn0zzvGk1PxgE0j5s5v0LEBOvUtxo78ICboNCL3ZVaOSnU01H3xXgWWjoXVIEY00k0Y9yIVn");
    const elements = stripe.elements();
    const style = {
      base: { fontSize: '16px', color: '#32325d', '::placeholder': { color: '#a0aec0' }},
      invalid: { color: '#fa755a' }
    };

    const cardNumber = elements.create('cardNumber', { style });
    const cardExpiry = elements.create('cardExpiry', { style });
    const cardCvc = elements.create('cardCvc', { style });

    cardNumber.mount('#card-number');
    cardExpiry.mount('#card-expiry');
    cardCvc.mount('#card-cvc');

    cardNumber.on('change', function(event) {
      const allIcons = document.querySelectorAll('#card-brand-icons .brand-icon');
      allIcons.forEach(icon => {
        icon.style.display = event.brand && event.brand !== 'unknown' && icon.classList.contains(event.brand)
          ? 'inline-block' : 'none';
      });
    });

    document.querySelectorAll('.payment-method').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.payment-method').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
      });
    });

    document.getElementById("paymentForm").addEventListener("submit", async (e) => {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const userId = 1; 
      const method = document.querySelector(".payment-method.active span").textContent;
      console.log("Selected payment method:", method);
      try {
        const sessionRes = await fetch("/api/create-checkout-session.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email })
        });
        
        const { clientSecret, error } = await sessionRes.json();
        if (error) {
          alert("Stripe error: " + error);
          return;
        }

        const result = await stripe.confirmCardPayment(clientSecret, {
          payment_method: {
            card: cardNumber,
            billing_details: { email }
          }
        });

        if (result.error) {
          document.getElementById("card-errors").textContent = result.error.message;
          return;
        }

        if (result.paymentIntent.status === "succeeded") {
          const paymentData = {
            user_id: 1,
            email: email,
            total_price: 100,
            payment_method: method
          };

          console.log("Sending payment data:", paymentData);
          const saveRes = await fetch("/api/handle-payment-success.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(paymentData)
          });

          let responseText;
          try {
            responseText = await saveRes.text(); // read it as plain text first
            saveResult = JSON.parse(responseText); // try converting to JSON manually
          } catch (e) {
            console.error("Invalid JSON response:", responseText);
            alert("An error occurred. Check the console for details.");
            return;
          }


          if (saveRes.ok) {
            window.location.href = "/paymentSuccess";
          } else {
            alert("Order failed: " + saveResult.error);
            console.error(saveResult);
          }
        }
      } catch (err) {
        console.error(err);
        alert("An unexpected error occurred.");
      }
    });
    </script>
</body>
</html>