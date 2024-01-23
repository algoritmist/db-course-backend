<?php
require_once "Connection.php";

function register_user($con){
    if(!$con){
        return "error: database service not available";
    }
    if(!isset($_POST["first_name"])){
        return "error: first name required for registration";
    }
    if(!isset($_POST["last_name"])){
        return "error: last name required for registration";
    }
    if(!isset($_POST["latitude"]) || !isset($_POST["longitude"])){
        return "error: coordinates required for registration";
    }
    if(!isset($_POST["sold_soul"])){
        return "error: selling soul required";
    }
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $con->query("INSERT INTO МЕСТОПОЛОЖЕНИЕ(ИД,СТРАНА,ГОРОД,ШИРОТА,ДОЛГОТА) VALUES (101,'NA', 'NA', $latitude,$longitude)");
    $sold_soul = $_POST["sold_soul"];
    $stmt = $con->query("INSERT INTO ЧЕЛОВЕК(ИМЯ,ФАМИЛИЯ,ПОЛ,СТАТУС_ИД,БАЛАНС,ПРОДАЖА_ДУШИ,МЕСТОПОЛОЖЕНИЕ)
        VALUES ($first_name, $last_name, gender, 0, $sold_soul, $con->lastInsertId())");
    return $stmt->lastInsertId();
}

return register_user($conn);
?>