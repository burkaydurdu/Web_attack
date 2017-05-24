<?php

$level = $_POST['level'];
$search = $_POST['search'];

if(isset($level) && isset($search)) {
    switch ($level){
        case 'High':
            $search = htmlspecialchars($search);
            break;
        case 'Medium':
            $search = str_replace("<script>","",$search);
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
    <form action="xssref.php" method="post">
        <input type="text"  class="text-box-style1 text-box-center" name="search" placeholder="Search"></br>
        <div class="text-box-center">
            <input type="radio" name="level" value="High"><label>HIGH</label>
            <input type="radio" name="level" value="Medium"><label>MEDIUM</label>
            <input type="radio" name="level" value="Low" checked="checked"><label>LOW</label>
        </div>
    </form>
</div>

<div class="div-style1">
    <?=$search ?>
</div>
<a href="index.php" class="fixed-menu">MENU</a>
</body>
</html>