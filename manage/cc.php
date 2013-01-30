<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Stripe Getting Started Form</title>
  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_V67pDOZ0wU2bEnfjc59lrK0l');

    function stripeResponseHandler(status, response) {
      if (response.error) {
        // Show the errors on the form
        $('.payment-errors').text(response.error.message);
        $('.submit-button').prop('disabled', false);
      } else {
        var $form = $('#payment-form');
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="text" name="stripeToken" />').val(token));
        // and submit
        //$form.get(0).submit();
      }
    }

    $(function() {
      $('#payment-form').submit(function(event) {
        // Disable the submit button to prevent repeated clicks
        $('.submit-button').prop('disabled', true);

        Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
      });
    });
  </script>
</head>
<body>
  <h1>Charge $10 with Stripe</h1>
  <!-- to display errors returned by createToken -->
  <span class="payment-errors"></span>

  <form action="" method="POST" id="payment-form">
    <div class="form-row">
      <label>
        <span>Card Number</span>
        <input type="text" size="20" autocomplete="off" class="card-number"/>
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>CVC</span>
        <input type="text" size="4" autocomplete="off" class="card-cvc"/>
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>Expiration (MM/YYYY)</span>
        <input type="text" size="2" class="card-expiry-month"/>
      </label>
      <span> / </span>
      <input type="text" size="4" class="card-expiry-year"/>
    </div>

    <button type="submit" class="submit-button">Submit Payment</button>
  </form>
</body>
</html>
