
$(function () {
    if ($('#group_table').length > 0) {
        try {
            $('#group_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": false,
                "info": true,
                "searching": false,
                "autoWidth": false,
                "pageLength": 15
            });
        } catch (error) {

        }

    }
});

function updateStartTime(element) {
    var taskNo = $(element).attr("task_no");
    var sprintId = $(element).attr("sprint_id");
    callAction("startTask",taskNo,sprintId,0);
}

function updateEndTime(element) {
    var time = prompt("Actual Manhours:", "");
    if (time != null && time.match(/^(\d|.)*$/) && time > 0) {
        var taskNo = $(element).attr("task_no");
        var sprintId = $(element).attr("sprint_id");
        callAction("endTask",taskNo,sprintId,time);
    }
}

function callAction(type,taskNo,sprintId,time) {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "/quickAction/",
        data: {
            type:type,
            taskNo:taskNo,
            sprintId:sprintId,
            time:time
        },
        format: "json"
    }).done(function(data ) {
        if (data.status == "success") {
            if (data.type == "startTask") {
                startSuccessProcess(data);
            } else if (data.type == "endTask") {
                endSuccessProcess(data);
            } else {
                alert("Update task fail");
            }
        }
    });
}
function startSuccessProcess(data){
    var startBtnID = "#stBtn_"+data.taskNo+"_"+data.sprintId;
    var targetElement  = $(startBtnID);
    var parent = $(targetElement.parent()[0]);
    targetElement.remove();
    var startTimeCell = $("#startTime_"+data.taskNo+"_"+data.sprintId);
    startTimeCell.html(data.time);
    var statusCell = $("#status_"+data.taskNo+"_"+data.sprintId);
    statusCell.html("Doing");
    var actionByCell = $("#actionBy_"+data.taskNo+"_"+data.sprintId);
    actionByCell.html(data.username);
    var endBtn = $("<div>");
    endBtn.attr("id","enBtn_"+data.taskNo+"_"+data.sprintId);
    endBtn.attr("class","endTime");
    endBtn.attr("task_no",data.taskNo);
    endBtn.attr("sprint_id",data.sprintId);
    endBtn.attr("onclick","updateEndTime(this)");
    endBtn.html("End");
    parent.append(endBtn);
}
function endSuccessProcess(data){
    var endBtnID = "#enBtn_"+data.taskNo+"_"+data.sprintId;
    var targetElement  = $(endBtnID);
    targetElement.remove();
    var startTimeCell = $("#endTime_"+data.taskNo+"_"+data.sprintId);
    startTimeCell.html(data.time);
    var statusCell = $("#status_"+data.taskNo+"_"+data.sprintId);
    statusCell.html("Done");
    var esTimeCell = $("#actTime_"+data.taskNo+"_"+data.sprintId);
    esTimeCell.html(data.esTime);
}