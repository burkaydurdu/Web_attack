<?php
include "sqlinfo.php";

$no = $_POST['no'];
$level = $_POST['level'];

if(isset($no)) {
    switch ($level){
        case 'High':
            $no = trim(addslashes(stripslashes($no)));
            break;
        case 'Medium':
            $no = str_replace("or","",$no);
            $no = stripslashes($no);
            break;
        case 'Low':
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Burkay Durdu">
    <meta name="keyword" content="html,css,javascript,php">
    <title>Web Security</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="div-style1">
    <form action="found.php" method="post">
        <input type="text"  class="text-box-style1 text-box-center" name="no" placeholder="User No"></br>
        <div class="text-box-center">
            <input type="radio" name="level" value="High"><label>HIGH</label>
            <input type="radio" name="level" value="Medium"><label>MEDIUM</label>
            <input type="radio" name="level" value="Low" checked="checked"><label>LOW</label>
        </div>
    </form>
</div>

<div class="div-style1">
    <table class="table-style1">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Mail</th>
        </tr>
        </thead>
        <tbody id="body">
        <?php
        if(isset($no))
            $sql->Student_found($no);
        ?>

        </tbody>
    </table>
</div>
<a href="index.php" class="fixed-menu">MENU</a>
</body>
</html>