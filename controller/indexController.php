<?php
View::addJS("indexPage");
View::setCachePage(false);
View::addCSS("indexPage");
require("connectDB.php");
require("utils.php");
require("checksession.php");
$whereCause = '';

$serviceValue = '12';
$sprintValue = '1';
$moduleValue = '0';
$taskTypeValue = '0';
$zoneValue = '0';
$actionValue = '0';
$statusValue = '0';
$priorityValue = '';
$minValue = '';
$maxValue = '';
if (isset($_POST['btnSearch'])) {
    $whereCause = '';
    if ($_POST['ddlServiceName'] != 0) {
        $whereCause .= " and ts.service_name_id = '" . $_POST['ddlServiceName'] . "'";
        $serviceValue = $_POST['ddlServiceName'];
    }

    if ($_POST['ddlSprintNo'] != 0) {
        $whereCause .= " and tt.sprint_id = '" . $_POST['ddlSprintNo'] . "'";
        $sprintValue = $_POST['ddlSprintNo'];
    }

    if ($_POST['ddlModule'] != 0) {
        $whereCause .= " and tt.module_id = '" . $_POST['ddlModule'] . "'";
        $moduleValue = $_POST['ddlModule'];
    }

    if ($_POST['ddlTaskType'] != 0) {
        $whereCause .= " and tt.task_type_id = '" . $_POST['ddlTaskType'] . "'";
        $taskTypeValue = $_POST['ddlTaskType'];
    }

    if ($_POST['ddlZone'] != 0) {
        $whereCause .= " and tt.task_zone_id = '" . $_POST['ddlZone'] . "'";
        $zoneValue = $_POST['ddlZone'];
    }

    if ($_POST['ddlActionBy'] != 0) {
        $whereCause .= " and tt.action_by = '" . $_POST['ddlActionBy'] . "'";
        $actionValue = $_POST['ddlActionBy'];
    }

    if ($_POST['ddlStatus'] != 0) {
        $whereCause .= " and tt.status = '" . $_POST['ddlStatus'] . "'";
        $statusValue = $_POST['ddlStatus'];
    }
    if ($_POST['txtPriority'] != '') {
        $whereCause .= " and tt.priority = '" . $_POST['txtPriority'] . "'";
        $priorityValue = $_POST['txtPriority'];
    }
    if ($_POST['txtMin'] != '' && $_POST['txtMax'] != '') {
        $whereCause .= " and tt.task_no BETWEEN " . $_POST['txtMin'] . " and " . $_POST['txtMax'];
        $minValue = $_POST['txtMin'];
        $maxValue = $_POST['txtMax'];
    }
} else {
    $whereCause .= " and ts.service_name_id = " . $serviceValue;
    $whereCause .= " and tt.sprint_id = " . $sprintValue;
}

?>


<div id="pjGasCalcContainer" class="container">
    <form id="logoutForm" action="/actionLogout/" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div style="margin-top: 0.5em;text-align: right;">
            <span style="padding-right:0.5em ">สวัสดีคุณ <?= $_SESSION['USER'] ?></span>
            <button type="submit" name="btnLogout" class="btn btn-primary" style="float: right;">Logout</button>
        </div>
    </form>
    <h2 class="text-center">Task List</h2>
    <br>
    <form id="pjGasCalcForm" action="?" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2">Service Name</label>
            <div class="col-sm-3">
                <select id="ddlServiceName" name="ddlServiceName" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getServiceNameSql = "select * from mst_param_value where param_type_code = 'SERVICE_NAME'";
                    $queryServiceName = mysqli_query($conn, $getServiceNameSql);
                    while ($rowServiceName = mysqli_fetch_assoc($queryServiceName)) {
                        $checked = '';
                        if ($rowServiceName['param_value_id'] == $serviceValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowServiceName['param_value_id'] ?>"><?= $rowServiceName['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Sprint No</label>
            <div class="col-sm-3">
                <select id="ddlSprintNo" name="ddlSprintNo" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $selectedValue = '';
                    $getSrpintNoSql = "select * from trn_sprint order by sprint_no";
                    $querySrpintNo = mysqli_query($conn, $getSrpintNoSql);
                    while ($rowSprintNo = mysqli_fetch_assoc($querySrpintNo)) {
                        $checked = '';
                        if ($rowSprintNo['sprint_id'] == $sprintValue) {
                            $checked = 'selected';
                            $selectedValue = $rowSprintNo['sprint_id'];
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowSprintNo['sprint_id'] ?>"><?= $rowSprintNo['sprint_no'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Module Name</label>
            <div class="col-sm-3">
                <select id="ddlModule" name="ddlModule" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getModuleSql = "select * from mst_param_value where param_type_code = 'MODULE_NAME'";
                    $queryModule = mysqli_query($conn, $getModuleSql);
                    while ($rowModule = mysqli_fetch_assoc($queryModule)) {
                        $checked = '';
                        if ($rowModule['param_value_id'] == $moduleValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowModule['param_value_id'] ?>"><?= $rowModule['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Task Type</label>
            <div class="col-sm-3">
                <select id="ddlTaskType" name="ddlTaskType" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getTaskTypeSql = "select * from mst_param_value where param_type_code = 'TASK_TYPE'";
                    $queryTaskType = mysqli_query($conn, $getTaskTypeSql);
                    while ($rowTaskType = mysqli_fetch_assoc($queryTaskType)) {
                        $checked = '';
                        if ($rowTaskType['param_value_id'] == $taskTypeValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowTaskType['param_value_id'] ?>"><?= $rowTaskType['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Zone</label>
            <div class="col-sm-3">
                <select id="ddlZone" name="ddlZone" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getZoneSql = "select * from mst_param_value where param_type_code = 'ZONE'";
                    $queryZone = mysqli_query($conn, $getZoneSql);
                    while ($rowZone = mysqli_fetch_assoc($queryZone)) {
                        $checked = '';
                        if ($rowZone['param_value_id'] == $zoneValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowZone['param_value_id'] ?>"><?= $rowZone['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Action By</label>
            <div class="col-sm-3">
                <select id="ddlActionBy" name="ddlActionBy" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getUserSql = "select * from user_profile";
                    $queryUser = mysqli_query($conn, $getUserSql);
                    while ($rowUser = mysqli_fetch_assoc($queryUser)) {
                        $checked = '';
                        if ($rowUser['param_value_id'] == $actionValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?> value="<?= $rowUser['user_id'] ?>"><?= $rowUser['user_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Status</label>
            <div class="col-sm-3">
                <select id="ddlStatus" name="ddlStatus" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getStatusSql = "select * from mst_param_value where param_type_code = 'TASK_STATUS'";
                    $queryStatus = mysqli_query($conn, $getStatusSql);
                    while ($rowStatus = mysqli_fetch_assoc($queryStatus)) {
                        $checked = '';
                        if ($rowStatus['param_value_id'] == $statusValue) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowStatus['param_value_id'] ?>"><?= $rowStatus['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Priority</label>
            <div class="col-sm-3">
                <input value="<?= $priorityValue ?>" type="textbox" id="txtPriority" name="txtPriority"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">No. Min</label>
            <div class="col-sm-3">
                <input value="<?= $minValue ?>" type="textbox" id="txtMin" name="txtMin"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
            <label class="control-label col-sm-2">No. Max</label>
            <div class="col-sm-3">
                <input value="<?= $maxValue ?>" type="textbox" id="txtMax" name="txtMax"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-8">
                <button type="submit" name="btnSearch" class="btn btn-primary">Search</button>
                <a href="/" class="btn btn-default pjGcBtnReset">Clear</a>
                <a href="/addTask/" class="btn btn-default pjGcBtnReset">Add</a>
            </div>
        </div>

    </form>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-bordered" id="group_table" style="width: 800px">
            <thead runat="server" id="headerGrid">
            <tr>
                <th>Action</th>
                <!-- 	                  		  <th>Sprint</th>
                                            <th>Servie Name</th> -->
                <th>No.</th>
                <th>Pri</th>
                <th>Task Type</th>
                <th>Zone</th>
                <th>Module</th>
                <th>Backlog</th>
                <th>Status</th>
                <th>By</th>
                <th>DB</th>
                <th>JSON</th>
                <th>Est MH</th>
                <th>Act MH</th>
                <th>Start</th>
                <th>End</th>
                <th>Remark</th>
            </tr>
            </thead>
            <tbody id="Tbody1">
            <?php
            $getTaskQuerySql = "SELECT
													ts.sprint_no,
													serv.param_value_name AS service_name,
													tt.task_no,
													tt.sprint_id,
													task.param_value_name AS task_type,
													zone.param_value_name AS zone,
													modu.param_value_name AS module,
													tt.task_detail,
                          tt.priority,
												IF (	tt.script_database = 'Y',	'Yes',	'No') AS script_database,
												IF (tt.json = 'Y', 'Yes', 'No') AS json,
												 tt.estimate_manhours,
												 tt.actual_manhours,
												 tt.start_datetime,
												 tt.end_datetime,
												 up.user_name AS action_by,
												 stt.param_value_name AS status,
												 tt.remark,
												 tt.create_date,
												 tt.create_by,
												 tt.update_date,
												 tt.update_by
												FROM
													trn_task tt
												LEFT OUTER JOIN trn_sprint ts ON tt.sprint_id = ts.sprint_id
												LEFT OUTER JOIN mst_param_value serv ON ts.service_name_id = serv.param_value_id
												LEFT OUTER JOIN mst_param_value task ON tt.task_type_id = task.param_value_id
												LEFT OUTER JOIN mst_param_value zone ON tt.task_zone_id = zone.param_value_id
												LEFT OUTER JOIN mst_param_value modu ON tt.module_id = modu.param_value_id
												LEFT OUTER JOIN mst_param_value stt ON tt.status = stt.param_value_id
												LEFT OUTER JOIN user_profile up ON tt.action_by = up.user_id 
											 WHERE 1=1 ";
            $getTaskQuerySql .= $whereCause;
            // ts.service_name_id =  ". $_POST['ddlServiceName']
            // 		." and tt.sprint_id = ". $_POST['txtSprintNo'];
            $queryTaskQuery = mysqli_query($conn, $getTaskQuerySql);
            while ($rowTask = mysqli_fetch_assoc($queryTaskQuery)) {
                ?>

                <tr>
                    <td>
                        <a href="editTask/<?= $rowTask['task_no'] ?>/<?= $rowTask['sprint_no'] ?>">Edit</a>
                        <?php
                            if ($rowTask['start_datetime'] == "") {
                                echo "<div id='stBtn_".$rowTask['task_no']."_".$rowTask['sprint_id']."' class='startTime' task_no='".$rowTask['task_no']."'  sprint_id='".$rowTask['sprint_id']."' onclick='updateStartTime(this)'>Start</div>";
                            } else if ($rowTask['end_datetime'] == "") {
                                echo "<div  id='enBtn_".$rowTask['task_no']."_".$rowTask['sprint_id']."' class='endTime' task_no='".$rowTask['task_no']."'  sprint_id='".$rowTask['sprint_id']."' onclick='updateEndTime(this)'>End</div>";
                            }
                        ?>
                    </td>

                    <!--                         <td style="text-align:center;">
                            <?= $rowTask['sprint_no'] ?>
                        </td>
                        <td>
                             <?= $rowTask['service_name'] ?>
                        </td> -->
                    <td width="10px">
                        <?= $rowTask['task_no'] ?>
                    </td>
                    <td width="10px">
                        <?= $rowTask['priority'] ?>
                    </td>
                    <td width="70px">
                        <?= $rowTask['task_type'] ?>
                    </td>
                    <td width="30px">
                        <?= $rowTask['zone'] ?>
                    </td>
                    <td width="70px">
                        <?= $rowTask['module'] ?>
                    </td>
                    <td width="100px">
                        <?= $rowTask['task_detail'] ?>
                    </td>
                    <td width="50px"  id="status_<?=$rowTask['task_no']?>_<?= $rowTask['sprint_id']?>" >
                        <?= $rowTask['status'] ?>
                    </td>
                    <td width="50px">
                        <?= $rowTask['action_by'] ?>
                    </td>
                    <td width="30px">
                        <?= $rowTask['script_database'] ?>
                    </td>
                    <td width="30px">
                        <?= $rowTask['json'] ?>
                    </td>
                    <td width="30px" id="esTime_<?=$rowTask['task_no']?>_<?= $rowTask['sprint_id'] ?>">
                        <?= $rowTask['estimate_manhours'] ?>
                    </td>
                    <td width="30px">
                        <?= $rowTask['actual_manhours'] ?>
                    </td>
                    <td width="60px"  id="startTime_<?=$rowTask['task_no']?>_<?= $rowTask['sprint_id'] ?>">
                        <?= $rowTask['start_datetime'] ?>
                    </td>
                    <td width="60px"  id="endTime_<?=$rowTask['task_no']?>_<?= $rowTask['sprint_id'] ?>">
                        <?= $rowTask['end_datetime'] ?>
                    </td>
                    <td width="60px">
                        <?= $rowTask['remark'] ?>
                    </td>
                </tr>

            <?php } ?>


            </tbody>
        </table>
    </div>
</div>