<?php
include "sqlinfo.php";

$name = $_POST['name'];
$message = $_POST['message'];
$mail = $_POST['mail'];
$level = $_POST['level'];

if(isset($level) && isset($name) && isset($mail)) {
    switch ($level){
        case 'High':
            $name = stripcslashes($name);
            $name = htmlspecialchars($name);

            $message = stripcslashes($message);
            $message = htmlspecialchars($message);

            $mail = stripcslashes($mail);
            $mail = htmlspecialchars($mail);
            break;
        case 'Medium':
            $name = str_replace('<script>', '', $name);

            $message = trim(strip_tags(addslashes($message)));
            $message = htmlspecialchars($message);

            $mail = stripcslashes($mail);
            $mail = htmlspecialchars($mail);
            break;
        case 'Low':
            $message = stripslashes($message);
            break;
    }
}
?>

<!DOCTYPE hmtl>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Burkay Durdu">
    <meta name="keyword" content="html,css,javascript,php">
    <title>Web Security</title>
    <script src="index.js" type="text/javascript"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="div-style1 div-style2">
    <form action="xssstor.php" method="post">
        <input type="text" class="text-box-style1 text-box-center" placeholder="Name" name="name">
        <input type="text" class="text-box-style1 text-box-center" placeholder="Message" name="message">
        <input type="text" class="text-box-style1 text-box-center" placeholder="Mail" name="mail">
        <div class="text-box-center">
            <input type="radio" name="level" value="High"><label>HIGH</label>
            <input type="radio" name="level" value="Medium"><label>MEDIUM</label>
            <input type="radio" name="level" value="Low" checked="checked"><label>LOW</label>
            <input type="submit" value="Send" hidden="hidden"  >
        </div>
    </form>
</div>
<div class="">
    <table class="table-style1">
        <thead>
        <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Mail</th>
        </tr>
        </thead>
        <tbody id="body">
        <?php
        if(isset($level) && isset($name) && isset($mail)) {
            if ($sql->Message_Insert($name, $message, $mail)) {
                unset($name);
                unset($message);
                unset($mail);
                $sql->Message_Get();
            }
            else
                echo "<p>xss stored attack</p>";
        }
        else
            $sql->Message_Get();

        ?>
        </tbody>
    </table>
</div>
<a href="index.php" class="fixed-menu">MENU</a>
</body>
</html>
