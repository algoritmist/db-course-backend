<?php
require_once "Connection.php";
function find_person($con)
{
    if ($con == false) {
        return "error: database service not available";
    }
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data["id"])) {
        return array(
            "result" => "fail",
            "error" => "person id required"
        );
    }
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
    $id = $data["id"];
    $first_name = $data["first_name"];
    $last_name = $data["last_name"];
    try {
        $result = $con->query("SELECT find_person($id, $first_name,$last_name) AS journal")->fetch();
        if ($result == false) {
            return array(
                "result" => "failed to execute find_person query",
                "error" => $GLOBALS["DB_RETURNED_NO_ROWS"]
            );
        }
        $jid = $result["journal"];
        if ($jid < 0) {
            return array(
                "result" => "failed to execute find_person query",
                "error" => $jid
            );
        }
        $location_id = $con->query("SELECT МЕСТО_ПРОВЕДЕНИЯ FROM ВЕДОМОСТЬ WHERE ИД = $jid")->fetch();
        if ($location_id == false) {
            return array(
                "result" => "failed to find location of person",
                "error" => $GLOBALS["DB_RETURNED_NO_ROWS"]
            );
        }
        $location = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE ИД = $location_id");
        return array(
            "result" => "success",
            "latitude" => $location["ШИРОТА"],
            "longitude" => $location["ДОЛГОТА"],
            "journal_id" => $jid
        );
    } catch (PDOException $e) {
        error_log($e, 0);
        return array(
            "result" => "failed to process query",
            "error" => "error: server database exception"
        );
    }
}

echo json_encode(find_person($conn));