<?php
include "sqlinfo.php";

$no = $_POST["no"];
$pass = $_POST["pass"];
$level = $_POST['level'];

if(isset($no) && isset($pass)) {
    switch ($level){
        case 'High':
               $no = trim(addslashes($no));
               $pass =trim(addslashes($pass));
               $pass = md5($pass);
            break;
        case 'Medium':
               $no =  str_replace("or",'',$no);
               $pass = str_replace("or",'',$pass);
               $pass = md5($pass);
            break;
        case 'Low':
            break;
    }
    if ($sql->Student_Login($no, $pass))
        echo "<script> alert('login Success'); </script>";
    else
        echo "<script> alert('Error'); </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="index.js" type="text/javascript"></script>
</head>
<body>

<div class="div-style1">
    <form  method="post" action="login.php">
        <input type="text" class="text-box-style1" placeholder="No" name="no">
        <input type="password" class="text-box-style1" placeholder="Password" name="pass">
        <button type="submit" class="btn-center">Sign-in</button>
        <button type="reset" class="btn-center">Clear</button>

        <input type="radio" name="level" value="High"><label>HIGH</label>
        <input type="radio" name="level" value="Medium"><label>MEDIUM</label>
        <input type="radio" name="level" value="Low" checked="checked"><label>LOW</label>
    </form>
</div>
<a href="index.php" class="fixed-menu">MENU</a>
</body>
</html>

<!-- { ' or '1'='1  }-->
