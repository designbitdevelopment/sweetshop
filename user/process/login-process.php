<?php
session_start();
include('./admin/inculde/function.php');


pr($_REQUEST);
die;

$sql = "SELECT * FROM `max_member` WHERE `phone`='".mysqli_real_escape_string($conn,trim($_POST['phone']))."' AND `password`='" . base64_encode(trim(mysqli_real_escape_string($conn, $_POST['password']))) . "' AND `block` = 0";
$res = query_with_log($conn, $sql);
$num = numrows($res);

if ($num > 0) {
    $fetch = fetcharray($res);
    $_SESSION['mid'] = $fetch['id'];
    redirect('../index.php?popup=1');
} else {
    $_SESSION['msg'] = 'Invalid Credentials!';
    redirect('../login.php');
}

redirect('../login.php');