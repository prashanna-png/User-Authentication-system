<?php
session_start();
require_once 'includes/auth.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container dashboard">
    <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
    <p>You're successfully logged in.</p>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>
</body>
</html>