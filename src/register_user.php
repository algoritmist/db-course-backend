<?php
require_once "Connection.php";

function register_user($con)
{
    if (!$con) {
        return "error: database service not available";
    }
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data["first_name"])) {
        return array(
            "result" => "fail",
            "error" => "first name required"
        );
    }
    if (!isset($data["last_name"])) {
        return array(
            "result" => "fail",
            "error" => "last name required"
        );
    }
    if (!isset($data["latitude"]) || !isset($data["longitude"])) {
        return array(
            "result" => "fail",
            "error" => "coordinates required for registration"
        );
    }
    if (!isset($data["sold_soul"])) {
        return "error: selling soul required";
    }
    $first_name = $data["first_name"];
    $last_name = $data["last_name"];
    $latitude = $data["latitude"];
    $longitude = $data["longitude"];
    try {
        $con->query("INSERT INTO МЕСТОПОЛОЖЕНИЕ(ИД,СТРАНА,ГОРОД,ШИРОТА,ДОЛГОТА) VALUES (101,'NA', 'NA', $latitude,$longitude)");
        $sold_soul = $data["sold_soul"];
        $stmt = $con->query("INSERT INTO ЧЕЛОВЕК(ИМЯ,ФАМИЛИЯ,ПОЛ,СТАТУС_ИД,БАЛАНС,ПРОДАЖА_ДУШИ,МЕСТОПОЛОЖЕНИЕ)
            VALUES ($first_name, $last_name, gender, 0, $sold_soul, $con->lastInsertId())");
        return $stmt->lastInsertId();
    } catch (PDOException $e) {
        error_log($e, 0);
        return array(
            "result" => "failed to process query",
            "error" => "error: server database exception"
        );
    }
}

echo json_encode(register_user($conn));