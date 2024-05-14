<?php
include 'config.php';

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    // Check if the email already exists in the database
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email ='$email'") or die(mysqli_error($conn));
    if(mysqli_num_rows($select_users) > 0){
       $message[] = 'User already exists!';
    } else {
       if($pass != $cpass){
          $message[] = 'Confirm password not matched!';
       } else {
          // Insert new user into the database
          mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$name', '$email', '$cpass', '$user_type')") or die(mysqli_error($conn));
          $message[] = 'Registered successfully!';
          header('location:login.php');
       }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!--custom css file link-->
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="register-page">
<?php
if(isset($message)){
    foreach($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>

<div class="form-container">
    <form action="" method="post">
        <h3>register now</h3>
        <input type="text" name="name" placeholder="Enter your name" required class="box">
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
        <select name="user_type" class="box">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <input type="submit" name="submit" value="Register now" class="btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>
</body>
</html>
