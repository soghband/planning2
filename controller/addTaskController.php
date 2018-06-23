<?php
require("connectDB.php");
require("utils.php");
require("checksession.php");
View::addJS("addTask");
?>
<div id="pjGasCalcContainer" class="container">
    <h2 class="text-center">Add Task</h2>

    <form id="pjGasCalcForm" action="/actionAdd/" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2">Service Name</label>
            <div class="col-sm-3">
                <select id="ddlServiceName" name="ddlServiceName" class="form-control" disabled="true">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getServiceNameSql = "select * from mst_param_value where param_type_code = 'SERVICE_NAME'";
                    $queryServiceName = mysqli_query($conn,$getServiceNameSql);
                    while ($rowServiceName = mysqli_fetch_assoc($queryServiceName)) {
                        $checked = '';
                        if ($rowServiceName['param_value_code'] == 'DEVICE_MASTER')
                            $checked = 'selected';
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
                    $querySrpintNo = mysqli_query($conn,$getSrpintNoSql);
                    while ($rowSprintNo = mysqli_fetch_assoc($querySrpintNo)) {
                        $checked = '';
                        if ($rowSprintNo['sprint_no'] == '12') {
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
                <input type="textbox" id="txtPriority" name="txtPriority" class="form-control number required"/>
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
                    $queryModule = mysqli_query($conn,$getModuleSql);
                    while ($rowModule = mysqli_fetch_assoc($queryModule)) {
                        ?>
                        <option value="<?= $rowModule['param_value_id'] ?>"><?= $rowModule['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Task Type</label>
            <div class="col-sm-3">
                <select id="ddlTaskType" name="ddlTaskType" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getTaskTypeSql = "select * from mst_param_value where param_type_code = 'TASK_TYPE'";
                    $queryTaskType = mysqli_query($conn,$getTaskTypeSql);
                    while ($rowTaskType = mysqli_fetch_assoc($queryTaskType)) {
                        ?>
                        <option value="<?= $rowTaskType['param_value_id'] ?>"><?= $rowTaskType['param_value_name'] ?></option>
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
                    $queryZone = mysqli_query($conn,$getZoneSql);
                    while ($rowZone = mysqli_fetch_assoc($queryZone)) {
                        ?>
                        <option value="<?= $rowZone['param_value_id'] ?>"><?= $rowZone['param_value_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Status</label>
            <div class="col-sm-3">
                <select id="ddlStatus" name="ddlStatus" class="form-control">
                    <option value="0">--Please Select--</option>
                    <?php
                    $getStatusSql = "select * from mst_param_value where param_type_code = 'TASK_STATUS'";
                    $queryStatus = mysqli_query($conn,$getStatusSql);
                    while ($rowStatus = mysqli_fetch_assoc($queryStatus)) {
                        $checked = '';
                        if ($rowStatus['param_value_code'] == 'TODO')
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
                <textarea id="taskDetails" name="taskDetails" class="form-control required"></textarea>
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
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select>
            </div>
            <label class="control-label col-sm-2">JSON Required</label>
            <div class="col-sm-3">
                <select id="ddlJson" name="ddlJson" class="form-control">
                    <option value="0">--Please Select--</option>
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Estimate Manhours</label>
            <div class="col-sm-3">
                <input type="textbox" id="txtEstMan" name="txtEstMan" class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
            <label class="control-label col-sm-2">Actual Manhours</label>
            <div class="col-sm-3">
                <input type="textbox" id="txtActMan" name="txtActMan" class="form-control number required"/>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Start Date/Time</label>
            <div class="col-sm-3">
                <div class='input-group date' id='txtStart'>
                    <input type='text' class="form-control" name='txtStart'/>
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
                    <input type='text' class="form-control" name='txtEnd'/>
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
                    $queryUser = mysqli_query($conn,$getUserSql);
                    while ($rowUser = mysqli_fetch_assoc($queryUser)) {
                        ?>
                        <option value="<?= $rowUser['user_id'] ?>"><?= $rowUser['user_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="control-label col-sm-2">Remark</label>
            <div class="col-sm-3">
                <textarea id="txtRemark" name="txtRemark" class="form-control required"></textarea>
                <div class="help-block with-errors">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-8">
                <button type="submit" class="btn btn-primary" name="btnAddTask">Add</button>
                <button type="reset" class="btn btn-primary">Clear</button>
                <a href="/" class="btn btn-default pjGcBtnReset">Back</a>
            </div>
        </div>
    </form>
</div>
