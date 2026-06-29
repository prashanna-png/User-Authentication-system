<?php
session_start();
require_once 'includes/db.php';
$firstname='';
$lastname = "";
$email = "";
$age = "";
$gender = "";
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $firstname = trim($_POST['fname']);
  $lastname = trim($_POST['lname']);
  $email = trim($_POST['email']);
  $age = trim($_POST['age']);
  $gender = $_POST['gender'] ?? '';
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if($firstname === '' || $lastname === '' ||
    $email === '' || $age === '' ||
    $gender === '' || $password === '' ||
    $confirm === ''){
      $_SESSION['error'] = "All fields are required";
      header("Location: register.php");
      exit;
  }

  elseif(!preg_match("/^[A-Za-z]+$/", $firstname)){
    $error = "Only letters are allowed in first name";
  }

  elseif(!preg_match("/^[A-Za-z]+$/", $lastname)){
    $error = "Only letters are allowed in last name";
  }

  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['error'] = "Invalid email format";
    header("Location: register.php");
    exit;
  }

  elseif(!is_numeric($age) || $age < 1 || $age > 120){
    $error = "Please enter a valid age";
  }

  elseif($gender != "male" && $gender != "female"){
    $error = "Please select a valid gender";
  }

  elseif($password != $confirm){
    $error = "Passwords do not match";
  }

  else{
    $check_email = "SELECT * FROM users where email='$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
      $_SESSION['error'] = "Email already exists";
      header("Location: register.php");
      exit;
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
  <title>User Authentication</title>
  <link rel="stylesheet" href="./style.css">
</head>

<body>
  <div class="container">
    <h1>Register</h1>
    <?php if(!empty($error)): ?>
        <div class="error-message">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="name">
        <div>
          <label for="fname">First Name:</label>
          <input type="text" id="fname" name="fname">
        </div>
        <div>
          <label for="lname">Last Name:</label>
          <input type="text" id="lname" name="lname">
        </div>
      </div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">

      <label for="age">Age:</label>
      <input type="text" id="age" name="age">

      <div class="gender">
          <input type="radio" id="male" name="gender" value="male">
          <label for="male">Male</label>

          <input type="radio" id="female" name="gender" value="female">
          <label for="female">Female</label>
      </div>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password">

      <label for="confirm">Confirm Password:</label>
      <input type="password" id="confirm" name="confirm_password">

      <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Log in</a></p>
  </div>
</body>

</html>