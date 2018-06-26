<?php
require("connectDB.php");
require("utils.php");
require("checksession.php");
View::setCachePage(false);
View::addJS("editTask");
$whereCause = '';
$tno = Route::getParam("tno");
$spno = Route::getParam("spno");
if (isset($tno) && isset($spno)) {
    $whereCause .= " and tt.task_no = '" . $tno. "'";
    $whereCause .= " and ts.sprint_no = '" . $spno . "'";
    $getTaskQuerySql = "SELECT
													ts.sprint_no,
													serv.param_value_name AS service_name,
													serv.param_value_id as service_id,
													tt.task_no,
													task.param_value_name AS task_type,
													task.param_value_id AS task_type_id,
													zone.param_value_name AS zone,
													zone.param_value_id AS zone_id,
													modu.param_value_name AS module,
													modu.param_value_id as module_id,
													tt.task_detail,
													tt.priority,
												IF (tt.script_database = 'Y',	'Yes',	'No') AS script_database,
												IF (tt.json = 'Y', 'Yes', 'No') AS json,
												 tt.estimate_manhours,
												 tt.actual_manhours,
												 tt.start_datetime,
												 tt.end_datetime,
												 up.user_name AS action_by,
												 up.user_id,
												 stt.param_value_name AS status,
												 stt.param_value_id AS status_id,
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
    $queryTaskQuery = mysqli_query($conn, $getTaskQuerySql);
    $rowTask = mysqli_fetch_assoc($queryTaskQuery);
}
?>
<div id="pjGasCalcContainer" class="container">
    <h2 class="text-center">Edit Task</h2>

    <form id="pjGasCalcForm" action="/actionEdit/" method="post" enctype="multipart/form-data"
          class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2">Service Name</label>
            <div class="col-sm-3">
                <select id="ddlServiceName" name="ddlServiceName" class="form-control" disabled="true">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getServiceNameSql = "select * from mst_param_value where param_type_code = 'SERVICE_NAME'";
                    $queryServiceName = mysqli_query($conn, $getServiceNameSql);
                    while ($rowServiceName = mysqli_fetch_assoc($queryServiceName)) {
                        $checked = '';
                        if ($rowServiceName['param_value_id'] == $rowTask['service_id']) {
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
                <select id="ddlSprintNo" name="ddlSprintNo" class="form-control" disabled="true">
                    <option value="0">--Please Select--</option>
                    <?php
                    $selectedValue = '';
                    $getSrpintNoSql = "select * from trn_sprint order by sprint_no";
                    $querySrpintNo = mysqli_query($conn, $getSrpintNoSql);
                    while ($rowSprintNo = mysqli_fetch_assoc($querySrpintNo)) {
                        $checked = '';
                        if ($rowSprintNo['sprint_no'] == $rowTask['sprint_no']) {
                            $checked = 'selected';
                            $selectedValue = $rowSprintNo['sprint_id'];
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowSprintNo['sprint_id'] ?>"><?= $rowSprintNo['sprint_no'] ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" id="txtSprintNo" name="txtSprintNo" value="<?= $selectedValue ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Priority</label>
            <div class="col-sm-3">
                <input value="<?= $rowTask['priority'] ?>" type="textbox" id="txtPriority" name="txtPriority"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
            <label class="control-label col-sm-2">Task No</label>
            <div class="col-sm-3">
                <input readonly="true" value="<?= $rowTask['task_no'] ?>" type="textbox" id="txtTaskNo" name="txtTaskNo"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Module Name</label>
            <div class="col-sm-3">
                <select id="ddlModule" name="ddlModule" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getModuleSql = "select * from mst_param_value where param_type_code = 'MODULE_NAME'";
                    $queryModule = mysqli_query($conn, $getModuleSql);
                    while ($rowModule = mysqli_fetch_assoc($queryModule)) {
                        $checked = '';
                        if ($rowModule['param_value_id'] == $rowTask['module_id']) {
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
                    <option value="0">--Please Select--</option>
                    <?php
                    $getTaskTypeSql = "select * from mst_param_value where param_type_code = 'TASK_TYPE'";
                    $queryTaskType = mysqli_query($conn, $getTaskTypeSql);
                    while ($rowTaskType = mysqli_fetch_assoc($queryTaskType)) {
                        $checked = '';
                        if ($rowTaskType['param_value_id'] == $rowTask['task_type_id']) {
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
                    <option value="0">--Please Select--</option>
                    <?php
                    $getZoneSql = "select * from mst_param_value where param_type_code = 'ZONE'";
                    $queryZone = mysqli_query($conn, $getZoneSql);
                    while ($rowZone = mysqli_fetch_assoc($queryZone)) {
                        $checked = '';
                        if ($rowZone['param_value_id'] == $rowTask['zone_id']) {
                            $checked = 'selected';
                        }
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowZone['param_value_id'] ?>"><?= $rowZone['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Status</label>
            <div class="col-sm-3">
                <select id="ddlStatus" name="ddlStatus" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getStatusSql = "select * from mst_param_value where param_type_code = 'TASK_STATUS'";
                    $queryStatus = mysqli_query($conn, $getStatusSql);
                    while ($rowStatus = mysqli_fetch_assoc($queryStatus)) {
                        $checked = '';
                        if ($rowStatus['param_value_id'] == $rowTask['status_id'])
                            $checked = 'selected';
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowStatus['param_value_id'] ?>"><?= $rowStatus['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Task Details</label>
            <div class="col-sm-8">
                <textarea id="taskDetails" name="taskDetails"
                          class="form-control required"><?= $rowTask['task_detail'] ?></textarea>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Database Script</label>
            <div class="col-sm-3">
                <select id="ddlDBScript" name="ddlDBScript" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getYesNoSql = "select * from mst_param_value where param_type_code = 'YES_NO_TYPE'";
                    $queryYesNo = mysqli_query($conn, $getYesNoSql);
                    while ($rowYesNo = mysqli_fetch_assoc($queryYesNo)) {
                        $checked = '';
                        if ($rowYesNo['param_value_name'] == $rowTask['script_database'])
                            $checked = 'selected';
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowYesNo['param_value_code'] ?>"><?= $rowYesNo['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">JSON Required</label>
            <div class="col-sm-3">
                <select id="ddlJson" name="ddlJson" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getYesNoSql = "select * from mst_param_value where param_type_code = 'YES_NO_TYPE'";
                    $queryYesNo = mysqli_query($conn, $getYesNoSql);
                    while ($rowYesNo = mysqli_fetch_assoc($queryYesNo)) {
                        $checked = '';
                        if ($rowYesNo['param_value_name'] == $rowTask['json'])
                            $checked = 'selected';
                        ?>
                        <option <?= $checked ?>
                                value="<?= $rowYesNo['param_value_code'] ?>"><?= $rowYesNo['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Estimate Manhours</label>
            <div class="col-sm-3">
                <input type="textbox" id="txtEstMan" value="<?= $rowTask['estimate_manhours'] ?>" name="txtEstMan"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
            <label class="control-label col-sm-2">Actual Manhours</label>
            <div class="col-sm-3">
                <input type="textbox" id="txtActMan" value="<?= $rowTask['actual_manhours'] ?>" name="txtActMan"
                       class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Start Date/Time</label>
            <div class="col-sm-3">
                <div class='input-group date' id='txtStart'>
                    <input type='text' class="form-control" name='txtStart' value="<?= $rowTask['start_datetime'] ?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>

                <!-- 	<input type="textbox" id="txtStart" name="txtStart" class="form-control number required"/>
                  <div class="help-block with-errors"><ul class="list-unstyled"></ul></div> -->
            </div>
            <label class="control-label col-sm-2">End Date/Time</label>
            <div class="col-sm-3">
                <div class='input-group date' id='txtEnd'>
                    <input type='text' class="form-control" name='txtEnd' value="<?= $rowTask['end_datetime'] ?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>

                <!-- <input type="textbox" id="txtEnd" name="txtEnd" class="form-control number required"/>
              <div class="help-block with-errors"><ul class="list-unstyled"></ul></div> -->
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Action By</label>
            <div class="col-sm-3">
                <select id="ddlActionBy" name="ddlActionBy" class="form-control">
                    <option value="0">Select All</option>
                    <?php
                    $getUserSql = "select * from user_profile";
                    $queryUser = mysqli_query($conn, $getUserSql);
                    while ($rowUser = mysqli_fetch_assoc($queryUser)) {
                        $checked = '';
                        if ($rowUser['user_id'] == $rowTask['user_id'])
                            $checked = 'selected';
                        ?>
                        <option <?= $checked ?> value="<?= $rowUser['user_id'] ?>"><?= $rowUser['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Remark</label>
            <div class="col-sm-3">
                <textarea id="txtRemark" name="txtRemark"
                          class="form-control required"><?= $rowTask['remark'] ?></textarea>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-8">
                <button type="submit" class="btn btn-primary" name="btnEditTask">Save</button>
                <a href="/" class="btn btn-default pjGcBtnReset">Back</a>
            </div>
        </div>
    </form>
</div>