
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Task Scrum Room: Planning 2</title>
        <?php include("meta.php"); ?>
        <style type="text/css">
        	tr > th{
        		text-align: center !important;
        		background: lightblue;
        		vertical-align: middle !important;

        	}

        </style>
	</head>
	<body>
		<div id="pjGasCalcContainer" class="container">
	<h2 class="text-center">Task Scrum Room: Planning 2</h2>
	
	<form id="pjGasCalcForm" action="?" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-4">Password</label>
          <div class="col-sm-4">
           <input  type="password" id="txtPassword" name="txtPassword" class="form-control number required"/>
                <div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
          </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-5 col-sm-8">
          <button type="submit" class="btn btn-primary" name="btnGen">gen</button>
        </div>
    </div>
	</form>
	</body>
</html>

<?php 
 if(isset($_POST['btnGen']))
 echo createPasswordHash($_POST['txtPassword']);
 function createPasswordHash($strPlainText) {
   return hash('sha512', $strPlainText);
 }

?>