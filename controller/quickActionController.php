<?php
View::setCachePage(false);
if (isset($_SESSION['USER'])) {
    require("connectDB.php");
    $taskNo = Route::getParam("taskNo");
    $sprintId = Route::getParam("sprintId");
    $type = Route::getParam("type");
    $time = Route::getParam("time");

    $currentTime = date("Y-m-d H:i:s");
    $userId = Session::get("USER_ID");
    if  ($type == "startTask") {
        $updateQuery = "UPDATE trn_task SET start_datetime=NOW(),action_by=".$userId.",status=27 WHERE  task_no=$taskNo AND sprint_id=$sprintId";
    } else if ($type == "endTask") {
        $updateQuery = "UPDATE trn_task SET end_datetime=NOW(),actual_manhours=".$time.",status=28 WHERE  task_no=$taskNo AND sprint_id=$sprintId";;
    }
    $result = mysqli_query($conn,$updateQuery);
    $json["taskNo"] = $taskNo;
    $json["sprintId"] = $sprintId;
    $json["type"] = $type;
    $json["query"] = $updateQuery;
    $json["time"] = $currentTime;
    $json["username"] = $_SESSION['FIRST_NAME'];
    $json["esTime"] = number_format($time,2);
    $json["status"] = ($result == true ? "success" : "fail");
    echo json_encode($json);
}