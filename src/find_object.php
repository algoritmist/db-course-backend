<?php
require_once "Connection.php";
function find_object($con)
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data["id"])) {
        return array(
            "result" => "fail",
            "error" => "person id required"
        );
    }
    if (!isset($data["object_name"])) {
        return array(
            "result" => "fail",
            "error" => "object name required for find person request"
        );
    }
    $id = $data["id"];
    $object_name = $data["object_name"];
    try {
        $result = $con->query("SELECT find_object($id, '$object_name') AS owner_id")->fetch();
        if ($result == false || $result < 0) {
            return array(
                "result" => "failed to execute find_object",
                "error" => $result ? $result : $GLOBALS["DB_RETURNED_NO_ROWS"]
            );
        }
        $owner_id = $result["owner_id"];
        $owner_info = $con->query("SELECT ИМЯ, ФАМИЛИЯ,МЕСТОПОЛОЖЕНИЕ FROM ЧЕЛОВЕК WHERE ИД = $owner_id")->fetch();
        if ($owner_info == false) {
            return array(
                "result" => "faild to find owner info",
                "error" => "person doesn't extist"
            );
        }
        $location_id = $owner_info["МЕСТОПОЛОЖЕНИЕ"];
        $coordinates = $con->query("SELECT ШИРОТА, ДОЛГОТА FROM МЕСТОПОЛОЖЕНИЕ WHERE ИД = $location_id")->fetch();
        /*
            Info about the previous owner and location of buy
        */
        return array(
            "result" => "success",
            "first_name" => $owner_info["ИМЯ"],
            "last_name" => $owner_info["ФАМИЛИЯ"],
            "latitude" => $coordinates["ШИРОТА"],
            "longitude" => $coordinates["ДОЛГОТА"]
        );
    } catch (PDOException $e) {
        error_log($e, 0);
        return array(
            "result" => "failed to process query",
            "error" => "error: server database exception"
        );
    }
}

echo json_encode(find_object($conn));