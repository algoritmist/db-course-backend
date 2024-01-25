<?php

require_once "Connection.php";

function become_warrior($con)
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

    if (!isset($data["warrior_type"])) {
        return array(
            "result" => "fail",
            "error" => "warrior type required"
        );
    }

    $id = $data["id"];
    $warrior_type = $data["warrior_type"];
    $who = $warrior_type == "soldier" ? "warrior" : "leader";
    
    try {
        $result = $con->query("SELECT be_$who($id) as satisfied")->fetch();
        return array(
            "result" => "sucess",
            "satisfied" => $result["satisfied"]
        );
    } catch (PDOException $e) {
        error_log($e, 0);
        return array(
            "result" => "failed to process query",
            "error" => "error: server database exception"
        );
    }
}

echo json_encode(become_warrior($conn));