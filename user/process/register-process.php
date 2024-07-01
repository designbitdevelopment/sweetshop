<?php
session_start();
include('./admin/inculde/function.php');

pr($_REQUEST);
die;
$checkStatus = (
    isset($_POST['name']) && $_POST['name'] &&
    isset($_POST['phone']) && $_POST['phone'] &&
    isset($_POST['email']) && $_POST['email'] &&
    isset($_POST['password']) && $_POST['password'] 
) ? true : false;

if ($checkStatus) {
    if ($_SESSION['with_otp'] != $_POST['token']) {
        $_SESSION['msg'] = 'Invalid request!';
        redirect('../register.php');
    }
    unset($_SESSION['with_otp']);


    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $signUpBonus = 81;
 

    $sqlsp = "SELECT * FROM `max_member` WHERE `userid` = '" . $sponsorid . "'";
    $ressp = query_with_log($conn, $sqlsp);
    $numsp = numrows($ressp);
    if ($numsp > 0) {
        $time = time();
        $a = substr($time, -6);
        $userid = $projectShortCode . $a;

        /*check existing user*/
        $sqlspd22334 = "SELECT * FROM `max_member` where `userid` = '" . $userid . "'";
        $resspd22334 = query_with_log($conn, $sqlspd22334);
        $numd22334 = numrows($resspd22334);
        if ($numd22334 > 0) {
            $_SESSION['msg'] ='Try later, userid issue!';
            redirect('../register.php');
        }
        /*end check existing user*/

        /*check existing phone*/
        $sqlspd22334 = "SELECT * FROM `max_member` where `phone` = '" . $phone . "'";
        $resspd22334 = query_with_log($conn, $sqlspd22334);
        $numd22334 = numrows($resspd22334);
        if ($numd22334 > 0) {
            $_SESSION['msg'] ='Phone number already used!';
            redirect('../register.php');
        }
        /*end check existing phone*/

        /*check existing email*/
        $sqlspd22334 = "SELECT * FROM `max_member` where `email` = '" . $email . "'";
        $resspd22334 = query_with_log($conn, $sqlspd22334);
        $numd22334 = numrows($resspd22334);
        if ($numd22334 > 0) {
            $_SESSION['msg'] ='Email already used!';
            redirect('../register.php');
        }
        /*end check existing email*/

        $sqsdsdlin = "INSERT INTO `max_member` (`userid`,`sponsorid`,`name`,`phone`,`email`,`password`,`signupbonus`,`wallet`,`date`,`status`,`walletpass`,`register_time`,`register_by`) VALUES('" . $userid . "','" . $sponsorid . "','" . $name . "','" . $phone . "','" . $email . "','" . base64_encode($password) . "','" . $signUpBonus . "','" . $signUpBonus . "','".date('Y-m-d')."','I','" . $walletPass . "','".date('Y-m-d H:i:s')."','User')";
        $ressdsin = query_with_log($conn, $sqsdsdlin);

        if($ressdsin){

            if ($signUpBonus > 0){
                $sqldsinp = "INSERT INTO `max_wallet_history` (`userid`,`toid`,`amount`,`type`,`datetime`) VALUES('".$userid."','".$userid."','".$signUpBonus."','Signup Reward','".date('Y-m-d H:i:s')."')";
                $redsinp = query_with_log($conn, $sqldsinp);

                $sqddl13 = "INSERT INTO `max_commission_pool1` (`userid`,`fromid`,`level`,`commission`,`date`,`datetime`) VALUES('".$userid."','".$userid."','Signup Reward','".$signUpBonus."','" . date('Y-m-d') . "','" . date('Y-m-d H:i:s') . "')";
                $ress13 = query_with_log($conn, $sqddl13);
            }

            if (isset($sponsorid) && $sponsorid && $referralIncome > 0){
                $jhdfhujd = "UPDATE `max_member` SET `wallet`=`wallet`+'".$referralIncome."',`total_income`=`total_income`+'".$referralIncome."',`refferal_income`=`refferal_income`+'".$referralIncome."' WHERE `userid` = '".$sponsorid."'";
                $hjfjhrf = query_with_log($conn,$jhdfhujd);

                $sqlinp = "INSERT INTO `max_wallet_history` (`userid`,`toid`,`amount`,`type`,`datetime`) VALUES('".$userid."','".$sponsorid."','".$referralIncome."','Referral Bouns','".date('Y-m-d H:i:s')."')";
                $resinp = query_with_log($conn, $sqlinp);

                $sql13 = "INSERT INTO `max_commission_pool1` (`userid`,`fromid`,`level`,`commission`,`date`,`datetime`) VALUES('".$sponsorid."','".$userid."','Referral Bouns','".$referralIncome."','" . date('Y-m-d') . "','" . date('Y-m-d H:i:s') . "')";
                $res13 = query_with_log($conn, $sql13);
            }

            /*direct team count*/
            $team_Spon = $sponsorid;
            $t1 = 1;
            while (isset($team_Spon) && $team_Spon) {
                if ($t1 <= 10) {
                    $level_member_1_field = getMemberUserid($conn, $team_Spon, 'level_member_' . $t1);
                    if (!(isset($level_member_1_field) && $level_member_1_field)) {
                        $oksqlTeam = "UPDATE `max_member` SET `level_member_$t1`='" . $userid . "',`inactive_team`=`inactive_team`+1,`inactive_direct_$t1`=`inactive_direct_$t1`+1 WHERE `userid` = '" . $team_Spon . "'";
                        $oksqlqueryTeam = query_with_log($conn, $oksqlTeam);
                    } else {
                        $oksqlTeam = "UPDATE `max_member` SET `level_member_$t1`=concat(`level_member_$t1`,',$userid'),`inactive_team`=`inactive_team`+1,`inactive_direct_$t1`=`inactive_direct_$t1`+1 WHERE `userid` = '" . $team_Spon . "'";
                        $oksqlqueryTeam = query_with_log($conn, $oksqlTeam);
                    }
                } else {
                    $oksqlTeam = "UPDATE `max_member` SET `inactive_team`=`inactive_team`+1 WHERE userid = '" . $team_Spon . "'";
                    $oksqlqueryTeam = query_with_log($conn, $oksqlTeam);
                }

                $nextSponsor1 = getMemberUserid($conn, $team_Spon, 'sponsorid');
                if (isset($nextSponsor1) && $nextSponsor1) {
                    $team_Spon = $nextSponsor1;
                } else {
                    break;
                }

                $t1++;
            }
            /*direct team count*/

            $_SESSION['msg'] = 'Register successfully !!';
            redirect('../register.php');
        }else{
            $_SESSION['msg'] = "Something went wrong, try later!";
            redirect('../register.php');
        }
    } else {
        $_SESSION['msg'] = 'Sponsor not found!';
        redirect('../register.php');
    }
}else{
    $_SESSION['msg'] = 'All fields required!';
    redirect('../register.php');
}