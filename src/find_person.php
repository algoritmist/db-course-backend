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
    if($result == false){
        return array(
            "result" => "failed to execute find_person query",
            "error" => $GLOBALS["DB_RETURNED_NO_ROWS"]
        );
    }
    $jid = $result["journal"];
    if($jid < 0){
        return array(
            "result" => "failed to execute find_person query",
            "error" => $jid
        );
    }
    $location_id = $con->query("SELECT МЕСТО_ПРОВЕДЕНИЯ FROM ВЕДОМОСТЬ WHERE ИД = $jid")->fetch();
    if($location_id == false){
        return array("
            result" => "failed to find location of person",
            "error"=> $GLOBALS["DB_RETURNED_NO_ROWS"]
        );
    }
    $location = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE ИД = $location_id");
    return array(
        "result" => "success",
        "latitude" => $location["ШИРОТА"],
        "longitude" => $location["ДОЛГОТА"],
        "journal_id" => $jid
    );
}

return find_person($conn);
?>