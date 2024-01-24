<?php

require_once "Connection.php";

function become_warrior($con){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    $data = json_decode(file_get_contents('php://input'), true);

    if(!isset($data["id"])){
        return "error: id required for find person request";
    }
    if(!isset($data["warrior_type"])){
        return "error: warrior type required";
    }
    $id = $data["id"];
    $warrior_type = $data["warrior_type"];
    $who = $warrior_type == "soldier" ? "warrior" : "leader";
    try{
        $result = $con->query("SELECT be_$who($id) as satisfied")->fetch();
        return $result["satisfied"];
    }
    catch(PDOException $e){
        return "functions error!";
    }
}

echo become_warrior($conn);

?>