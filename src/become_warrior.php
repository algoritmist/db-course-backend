<?php

require_once "Connection.php";

function become_warrior($con){
    if(!isset($_GET["id"])){
        return "error: id required for find person request";
    }
    if(!isset($_GET["warrior_type"])){
        return "error: warrior type required";
    }
    $id = $_GET["id"];
    $warrior_type = $_GET["warrior_type"];
    $who = $warrior_type == "soldier" ? "warrior" : "leader";
    $result = $con->query("SELECT be_$who($id) as location_id")->fetch();
    $location_id = $result["location_id"];
    $coordinates = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE МЕСТОПОЛОЖЕНИЕ.ИД = $location_id")->fetch();
    return array(
        "latitude" => $coordinates["ШИРОТА"],
        "longitude" => $coordinates["ДОЛГОТА"]
    );
}

return become_warrior($conn);

?>