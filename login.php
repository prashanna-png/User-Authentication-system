<?php
require_once 'includes/db.php';
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
    $check_email = "SELECT * FROM users where email='$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
      $error = "Email already exists";
    }
    else{
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users
      (first_name, last_name, email, age, gender, password_hash)
      VALUES
      ('$firstname', '$lastname', '$email', '$age', '$gender', '$hashed_password')";

      if (mysqli_query($conn, $sql)) {
        header("Location: login.php?registered=1");
        exit;
      } 
      else {
        $error = "Error: " . mysqli_error($conn);
      }
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

      <input type="submit" value="Register">

    </form>
  </div>
</body>
</html>