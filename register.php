<?php
include 'insert/db.php';
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
    echo "All fields are required";
  }

  elseif(!preg_match("/^[A-Za-z]+$/", $firstname)){
    echo "Only letters are allowed in first name";
  }

  elseif(!preg_match("/^[A-Za-z]+$/", $lastname)){
    echo "Only letters are allowed in last name";
  }

  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Invalid email format";
  }

  elseif(!is_numeric($age) || $age < 1 || $age > 120){
    echo "Please enter a valid age";
  }

  elseif($gender != "male" && $gender != "female"){
    echo "Please select a valid gender";
  }

  elseif($password != $confirm){
    echo "Passwords do not match";
  }

  else{
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $check_email = "SELECT * FROM users where email='$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
      echo "Email already exists";
    }
    else{
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "INSERT INTO users
    (first_name, last_name, email, age, gender, password_hash)
    VALUES
    ('$firstname', '$lastname', '$email', '$age', '$gender', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
      header("Location: login.php?registered=1");
      exit;
    } 
    else {
      echo "Error: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Authentication</title>
</head>

<body>
  <div>
    <form action="" method="POST">

      <label for="fname">First Name:</label><br>
      <input type="text" id="fname" name="fname"><br><br>

      <label for="lname">Last Name:</label><br>
      <input type="text" id="lname" name="lname"><br><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email"><br><br>

      <label for="age">Age:</label><br>
      <input type="number" id="age" name="age"><br><br>

      <input type="radio" id="male" name="gender" value="male">
      <label for="male">Male</label>

      <input type="radio" id="female" name="gender" value="female">
      <label for="female">Female</label><br><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password"><br><br>

      <label for="confirm">Confirm Password:</label><br>
      <input type="password" id="confirm" name="confirm_password"><br><br>

      <input type="submit" value="Register">

    </form>
  </div>
</body>

</html>