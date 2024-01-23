<?php
require_once "Connection.php";
function find_person($con){
    if(!isset($_POST["id"])){
        return "error: id required for find person request";
    }
    if(!isset($_POST["first_name"])){
        return "error: first_name required for find person request";
    }
    if(!isset($_POST["last_name"])){
        return "error: last_name required for find person request";
    }
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $result = $con->query("SELECT find_person($id, $first_name,$last_name) AS journal")->fetch();
    $jid = $result["journal"];
    $location_id = $con->query("SELECT МЕСТО_ПРОВЕДЕНИЯ FROM ВЕДОМОСТЬ WHERE ИД = $jid")->fetch();
    $location = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE ИД = $location_id");
    return array(
        "latitude" => $location["ШИРОТА"],
        "longitude" => $location["ДОЛГОТА"],
        "journal_id" => $jid
    );
}

return find_person($conn);
?>