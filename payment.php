<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
   header('location:login.php');
   exit();
}

$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY placed_on DESC LIMIT 1") or die('query failed');

if(mysqli_num_rows($order_query) > 0) {
   $order_details = mysqli_fetch_assoc($order_query);
} else {
   header('location:checkout.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Payment</title>

   <!-- Add your Instamojo payment integration script here -->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         background-color:lightblue;
         font-size: 18px;
      }
      .payment-details {
         margin-bottom: 20px;
      }
      .payment-details h2 {
         font-size: 24px;
         margin-bottom: 10px;
      }
      .payment-details p {
         margin-bottom: 5px;
      }
      .payment-methods {
         margin-top: 20px;
      }
      .payment-methods h2 {
         font-size: 24px;
         margin-bottom: 10px;
      }
      .payment-methods button {
         font-size: 20px;
         padding: 10px 20px;
         margin-right: 10px;
      }
   </style>
</head>
<body>

<div class="heading">
   <h1>PAYMENT</h1>
</div>

<section class="payment-details">
   <h2>Order Details</h2>
   <p><b>Name: </b><?php echo htmlspecialchars($order_details['name']); ?></p>
   <p><b>Number: </b><?php echo htmlspecialchars($order_details['number']); ?></p>
   <p><b>Email: </b><?php echo htmlspecialchars($order_details['email']); ?></p>
   <p><b>Address: </b><?php echo htmlspecialchars($order_details['address']); ?></p>
   <p><b>Total Products: </b><?php echo htmlspecialchars($order_details['total_products']); ?></p>
   <p><b>Total Price: </b>&#8377;<?php echo htmlspecialchars($order_details['total_price']); ?>/-</p>
</section>

<section class="payment-methods">
   <h2>Choose Payment Method</h2>
   <form action="payment.html" method="POST">
      <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_details['id']); ?>">
      <!-- Button for Cash on Delivery -->
      <button type="submit" name="payment_method" value="cash_on_delivery">Cash on Delivery</button>
      <!-- Button for Credit Card Payment -->
      <button type="submit" name="payment_method" value="credit_card">Pay by Credit Card</button>
      <!-- Button for Debit Card Payment -->
      <button type="submit" name="payment_method" value="debit_card">Pay by Debit Card</button>
      <!-- Add more payment methods/buttons as needed -->
   </form>
</section>


</body>
</html>
