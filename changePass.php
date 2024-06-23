<?php
  session_start();
  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['newPassword'])) {
    // No need to fetch and verify the current password
    $newPasswordHash = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
    $update = $conn->prepare('UPDATE users SET password = :newPassword WHERE email = :email');
    $update->bindParam(':newPassword', $newPasswordHash);
    $update->bindParam(':email', $_POST['email']);
    
    if ($update->execute()) {
      $message = 'Password successfully updated';
    } else {
      $message = 'There was a problem updating your password';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require 'partials/header.php'?>



<h1>Password change</h1>
<span>or <a href="login.php">Login</a></span>

<?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

  <form action="changePass.php" method="post">
    <input type="text" name="email" placeholder="Enter your email">
    <input type="password" name="newPassword" placeholder="Enter your new password">
    <input type="submit" value="Update Password">
  </form>

</body>
</html>