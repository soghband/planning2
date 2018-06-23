<?php
View::setCachePage(false);
require("connectDB.php");
require("utils.php");
require("checksession.php");
if (isset($_POST['btnEditTask'])) {
    $update = "";

    $update = [];
    array_push($update, "sprint_id = '" . $_POST['txtSprintNo'] . "'");
    array_push($update, "task_type_id = '" . $_POST['ddlTaskType'] . "'");
    array_push($update, "task_zone_id = '" . $_POST['ddlZone'] . "'");
    array_push($update, "module_id = '" . $_POST['ddlModule'] . "'");
    array_push($update, "task_detail = '" . $_POST['taskDetails'] . "'");
    array_push($update, "script_database = '" . $_POST['ddlDBScript'] . "'");
    array_push($update, "json = '" . $_POST['ddlJson'] . "'");
    array_push($update, "estimate_manhours = '" . $_POST['txtEstMan'] . "'");
    array_push($update, "actual_manhours = '" . $_POST['txtActMan'] . "'");


    if (isset($_POST['txtStart']) && trim($_POST['txtStart']) != '') {
        $update[] = "start_datetime = '" . ConvertDateToDB($_POST['txtStart']) . "'";
    } else {
        $update[] = "start_datetime = null ";
    }

    if (isset($_POST['txtEnd']) && trim($_POST['txtEnd']) != '') {
        $update[] = "end_datetime = '" . ConvertDateToDB($_POST['txtEnd']) . "'";
    } else {
        $update[] = "end_datetime = null ";
    }

    //$update[] = "start_datetime = '". ConvertDateToDB($_POST['txtStart'])."'";
    //$update[] = "end_datetime = '". ConvertDateToDB($_POST['txtEnd'])."'";

    $update[] = "action_by = '" . $_POST['ddlActionBy'] . "'";
    $update[] = "status = '" . $_POST['ddlStatus'] . "'";
    $update[] = "remark = '" . $_POST['txtRemark'] . "'";
    $update[] = "priority = '" . $_POST['txtPriority'] . "'";

    $update[] = "update_date = NOW()";
    $update[] = "update_by = '" . $_SESSION['USER'] . "'";

    $sql = "UPDATE trn_task SET  " . implode(",", $update) . " WHERE task_no = " . $_POST['txtTaskNo']
        . " and sprint_id = " . $_POST['txtSprintNo'];

    mysqli_query($conn,$sql) or die(mysqli_error($conn));

    echo "<script> alert('Update Complete'); window.location='/';</script>";
    //header('Location: ' . $returnPage);

}

?>





