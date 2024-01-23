<?php
require_once "Connection.php";

function authorize($con){
    if(!$con){
        return "error: database service not available";
    }
    if(!isset($_POST["id"])){
        return "error: id requried";
    }
    if(!isset($_POST["first_name"])){
        return "error: first name required";
    }
    if(!isset($_POST["last_name"])){
        return "error: last name required";
    }
    $id = $_POST["id"];
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $q = $con->query("SELECT ИМЯ, ФАМИЛИЯ FROM ЧЕЛОВЕК WHERE ИД = $id")->fetch();
    if($fname == $q["ИМЯ"] && $lname == $q["ФАМИЛИЯ"]){
        return true;
    }
    return false;
}

return authorize($conn);
?>