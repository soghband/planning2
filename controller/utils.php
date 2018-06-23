<?php 
function ConvertDateToDB($str) {
  
  $date = date("Y-m-d H:i:s", strtotime(trim($str)));
  
 return $date;
}

?>