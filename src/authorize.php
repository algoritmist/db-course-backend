<?php
require_once "Connection.php";

function authorize($con)
{
    if (!$con) {
        return "error: database service not available";
    }
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    $data = json_decode(filedata_contents('php://input'), true);
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
            "error" => "last_name required"
        );
    }
    $id = $data["id"];
    $fname = $data["first_name"];
    $lname = $data["last_name"];
    try {
        $q = $con->query("SELECT ИМЯ, ФАМИЛИЯ FROM ЧЕЛОВЕК WHERE ИД = $id")->fetch();
        if ($q == false) {
            return array(
                "result" => "server error: try again later",
                "error" => $GLOBALS["DB_RETURNED_NO_ROWS"]
            );
        }
        if ($fname == $q["ИМЯ"] && $lname == $q["ФАМИЛИЯ"]) {
            return array(
                "result" => "success",
                "authorized" => true
            );
        }
        return array(
            "result" => "authorization failed",
            "authorized" => false
        );
    } catch (PDOException $e) {
        error_log($e, 0);
        return array(
            "result" => "failed to process query",
            "error" => "error: server database exception"
        );
    }
}
echo json_encode(authorize($conn));