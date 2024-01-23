<?php
require_once "Connection.php";
function war($con){
    if(!isset($_POST["id"])){
        return "error: id required for find person request";
    }
    if(!isset($_POST["opponent_id"])){
        return "error: opponent id required for find person request";
    }
    $id = $_POST["id"];
    $opponent_id = $_POST["opponent_id"];
    $result = $con->query("SELECT war($id, $opponent_id) AS coordinates_id")->fetch();
    $coordinates_id = $result["coordinates_id"];
    $coordinates = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE МЕСТОПОЛОЖЕНИЕ.ИД = $coordinates_id")->fetch();
    return array(
        "latitude" => $coordinates["ШИРОТА"],
        "longitude" => $coordinates["ДОЛГОТА"]
    );
}

return war($conn);
?>