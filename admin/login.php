<?php
session_start(); // Start session at top of the page

// ✅ Include database connection
include('../config/constants.php'); 
// OR if your DB connection file is different:
// include('../config/db_connect.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <title>Login</title>
</head>
<body>

<?php 
if(isset($_SESSION['login'])) {
    echo $_SESSION['login'];
    unset($_SESSION['login']);
}
?>

<div class="container">
    <div class="brand-logo"></div>
    <div class="brand-title">Admin Panel</div>

    <form action="" class="inputs" method="POST" name="form1">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="submit" value="login">Login</button>
    </form>
</div>
</body>
</html>

<?php 
if(isset($_POST['submit']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1)
    {
        $_SESSION['login']  = "<div class='success'>Login Successful</div>";
        $_SESSION['user-admin'] = $username;
        header('location:'.SITEURL.'admin/dashboard.php'); // ✅ update destination
    }
    else
    {
        echo "<script>
            alert('Wrong Username or Password'); 
            window.location.href='login.php';
        </script>";
    }
}
?>
