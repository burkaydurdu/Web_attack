<?php
include "sqlinfo.php";

$no = $_POST["no"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$pass = $_POST["pass"];
$pass2 = $_POST["pass2"];
$mail = $_POST["mail"];
if($pass === $pass2 && isset($no) && isset($fname) && isset($lname) && isset($pass) && isset($pass2) && isset($mail)) {
    if ($sql->Student_Insert($no, $fname, $lname, $pass, $mail))
        echo "<script> alert('Success'); </script>";
    else
        echo "<script> alert('Error'); </script>";
}
else
    //echo "<script> alert('Pass1 != Pass2'); </script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="index.js" type="text/javascript"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="div-style1">
    <form  method="post" action="insert.php">
        <input type="text" class="text-box-style1" placeholder="No" name="no">
        <input type="text" class="text-box-style1" placeholder="First Name" name="fname">
        <input type="text" class="text-box-style1" placeholder="Last Name" name="lname">
        <input type="password" class="text-box-style1" placeholder="Password" name="pass">
        <input type="password" class="text-box-style1" placeholder="Password" name="pass2">
        <input type="text" class="text-box-style1" placeholder="Mail" name="mail">
        <button type="submit" class="btn-center">Add</button>
    </form>
</div>
<a href="index.php" class="fixed-menu">MENU</a>
</body>
</html>