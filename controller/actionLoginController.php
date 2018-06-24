<?php
View::setCachePage(false);
require("connectDB.php");
require("utils.php");
$getUserSql = "select * from user_profile where user_name = '" . $_POST['txtUserName'] . "'";
$getUserQuery = mysqli_query($conn, $getUserSql);
$getuserCount = mysqlI_num_rows($getUserQuery);


if ($getuserCount == 0) {
    echo '<script type="text/javascript">alert("ไม่พบผู้ใช้งานี้ในระบบ");
				window.location.href = "/login/";
			</script>';
} else {
    $getUserRow = mysqlI_fetch_assoc($getUserQuery);
    if ($getUserRow['password'] == createPasswordHash($_POST['txtPassword'])) {
        $_SESSION['USER'] = $_POST['txtUserName'];
        $_SESSION['USER_ID'] = $getUserRow['user_id'];
        echo '<script type="text/javascript">
				window.location.href = "/";
			</script>';
    } else {
        echo '
            <script type="text/javascript">
                alert("รหัสผ่านไม่ถูกต้อง");
				window.location.href = "/login/";
			</script>';
    }
}

function createPasswordHash($strPlainText)
{
    return hash('sha512', $strPlainText);
}


?>