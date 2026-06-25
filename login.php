<?php

require_once 'includes/db.php';
session_start();

$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if($email === '' || $password === ''){
    $error = "All fields are required";
  }
  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "Invalid email format";
  }

  else{
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) ==1) {
      $user = mysqli_fetch_assoc($result);
      
      if(password_verify($password,$user['password_hash'])){
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['first_name'];

        header("Location: dashboard.php");
        exit;
      }
      else{
        $error = "Incorrect Password";
      }
    }
    else{
      $error = "User does not exist";
    }
  }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
    <h1>Login</h1>
    <?php if(!empty($error)): ?>
        <div class="error-message">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">

      <label for="password">Password:</label>
      <input type="password" id="password" name="password">

      <input type="submit" value="Login">

    </form>
  </div>
</body>
</html>