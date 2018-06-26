<?php
View::setCachePage(false);
require("connectDB.php");
require("checksession.php");
unset($_SESSION["USER"]);
unset($_SESSION["FIRST_NAME"]);
unset($_SESSION["USER_ID"]);
echo "<script> alert('Logout Complete'); window.location='/login/';</script>";

?>