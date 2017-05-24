<?php

class Sql extends mysqli {

    public function __construct($host, $username, $passwd, $dbname)
    {
        parent::__construct($host,$username,$passwd,$dbname);
    }
    public function Student_Insert($no, $firstname, $lastname, $password, $mail){
        $md5pass = md5($password);
        $query = "insert into Students (no,fname,lname,password,mail) values('$no', '$firstname', '$lastname', '$md5pass', '$mail')";
        if ($this->query($query) )
            return true;
        else
            return false;
    }
    public function Student_Login($no, $password){
        $query = "Select *from Students where no = '$no' and password = '$password'";
        if( $this->query($query)->num_rows > 0)
            return true;
        else
            return false;
    }
    public function Student_found($no){
        $query = "Select no, fname, lname, mail from Students WHERE no = '$no'";
        $result = $this->query($query);
        while($row = $result->fetch_assoc())
            echo "<tr><td>".$row['no']."</td><td>".$row['fname']."</td><td>".$row['lname']."</td><td>".$row['mail']."</td></tr>";
    }
    public function Message_Insert($name,$messasge,$mail){
        $name = $this->escape_string($name);
        $messasge = $this->escape_string($messasge);
        $mail = $this->escape_string($mail);
        $query = "insert into Messages (name,message,mail) values('$name','$messasge','$mail')";
        if ($this->query($query) )
            return true;
        else
            return false;
    }
    public function Message_Get(){
        $query = "Select name,message,mail from Messages";
        $result = $this->query($query);
        while ($row = $result->fetch_assoc())
            echo "<tr><td>".$row['name']."</td><td>".$row['message']."</td><td>".$row['mail']."</td></tr>";
    }
}