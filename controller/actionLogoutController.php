<?php
View::setCachePage(false);
require("connectDB.php");
require("checksession.php");
unset($_SESSION["USER"]);
echo "<script> alert('Logout Complete'); window.location='/login/';</script>";

?>