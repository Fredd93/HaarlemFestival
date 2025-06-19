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