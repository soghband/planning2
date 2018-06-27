<?php
View::setCachePage(false);
require("connectDB.php");
require("utils.php");
require("checksession.php");
if(isset($_POST['btnAddTask'])){
    $getTaskNoSql = "select task_running + 1 as task_no from trn_sprint where sprint_id = " . $_POST['txtSprintNo'];
    $queryTaskNo  = mysqli_query($conn,$getTaskNoSql);
    $rowTaskNo = mysqli_fetch_assoc($queryTaskNo);

    $update = Array();
    array_push($update , "task_running = ". $rowTaskNo['task_no']);

    $sql = "UPDATE trn_sprint SET  " . implode(",", $update) . " WHERE sprint_id = " . $_POST['txtSprintNo'];

    mysqli_query($conn,$sql) or die($conn);

    unset($insert);
    $insert['task_no'] = "'" . $rowTaskNo['task_no'] . "'";

    $insert['sprint_id'] = "'" .$_POST['txtSprintNo']  . "'";
    $insert['task_type_id'] = "'" .$_POST['ddlTaskType']  . "'";
    $insert['task_zone_id'] = "'". $_POST['ddlZone']."'";
    $insert['module_id'] = "'". $_POST['ddlModule']."'";
    $insert['task_detail'] = "'". str_replace(array("'"),array("\\'"),$_POST['taskDetails'])."'";

    $insert['script_database'] = "'". $_POST['ddlDBScript']."'";
    $insert['json'] = "'". $_POST['ddlJson']."'";
    $insert['estimate_manhours'] = "'". $_POST['txtEstMan']."'";
    $insert['actual_manhours'] = "'". $_POST['txtActMan']."'";


    if(isset($_POST['txtStart']) && trim($_POST['txtStart']) != '') {
        $insert['start_datetime'] = "'". ConvertDateToDB($_POST['txtStart'])."'";
    }else{
        $insert['start_datetime'] = " null ";
    }

    if(isset($_POST['txtEnd']) && trim($_POST['txtEnd'])!= '') {
        $insert['end_datetime'] = "'". ConvertDateToDB($_POST['txtEnd'])."'";
    }else {
        $insert['end_datetime'] = " null ";
    }

    //$insert['start_datetime'] = "'". ConvertDateToDB($_POST['txtStart'])."'";
    //$insert['end_datetime'] = "'". ConvertDateToDB($_POST['txtEnd'])."'";

    $insert['action_by'] = "'". $_POST['ddlActionBy']."'";
    $insert['status'] = "'". $_POST['ddlStatus']."'";
    $insert['remark'] = "'". $_POST['txtRemark']."'";
    $insert['priority'] = "'". $_POST['txtPriority']."'";

    $insert['create_date'] = "NOW()";
    $insert['create_by'] = "'". $_SESSION['USER']."'";

    $sql = "INSERT INTO  trn_task (" . implode(",", array_keys($insert)) . ") VALUES (" . implode(",", array_values($insert)) . ")";

    mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $retrunID = mysqli_insert_id($conn);

    echo "<script>
        alert('Save Complete'); 
        window.location='/';
        </script>";
    //header('Location: ' . $returnPage);
}

?>





