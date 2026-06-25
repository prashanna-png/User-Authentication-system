<?php
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
    else{
      if($password != $confirm){
        echo "Passwords do not match";
      } 
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email format";
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