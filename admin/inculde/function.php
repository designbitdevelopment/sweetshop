<?php
// $conn = mysqli_connect('localhost', 'acemall_club', 'acemall_club@142365', 'acemall_club');
$conn = mysqli_connect('localhost', 'root', '', 'jackportcity29122023');


date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

include_once('config.php');



function getMemberTotalIncomeAllType($conn, $userid, $type)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%$type%' AND `level` NOT Like '%Upgrade_income%'  ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function levelMemberFunction($conn, $uid, $a, $level)
{
    $x = "SELECT * FROM `max_member` WHERE `sponsorid` = '" . $uid . "'";
    $y = query($conn, $x);
    $n = numrows($y);
    if ($n > 0) {
        $level++;
        if ($level >= 4) {
            return $a;
        }
        while ($fetch1 = mysqli_fetch_assoc($y)) {
            $fetch1['level'] = $level;
            $aa = array_push($a, $fetch1);
            $a = levelMemberFunction($conn, $fetch1['userid'], $a, $level);
        }
    }
    return $a;
}
function investwalletAmountAll($conn, $column)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `wallet_recharge` WHERE `type`='Transfer To Plan Wallet'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function gamewalletAmountAll($conn, $column)
{
    $sql = "SELECT SUM(`wallet`) AS total FROM `users`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function pr($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    die;
}

function getMemberTotalIncomeMonthly($conn, $userid)
{
    $time = time();
    $add_time = strtotime('-30 day', $time);
    $d = date('Y-m-d', $add_time);
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";
    $sql23 = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` where `userid` = '" . $userid . "' AND  `my_time`>='" . $date . "' AND `my_time`<='" . $datet . "'  ORDER BY `id` DESC";
    $res23 = query($conn, $sql23);
    $fetchh = fetcharray($res23);
    $fetch = $fetchh['total'];

    $fetchTotal = $fetch;
    return $fetchTotal;
}



function getMemberTotalAdminAdd($conn, $userid)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `max_wallet_history` where `toid` = '" . $userid . "' AND `type` = 'Add'";
    $res = query($conn, $sql);
    $num = numrows($res);

    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function getDownLinemember($conn, $sponsor)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsorid`='" . $sponsor . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getLastData($conn, $tablename, $outputcolumn)

{
    $sql = "SELECT * FROM `$tablename` Order BY id DESC limit 1 ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {

        $fetch = fetcharray($res);
        return $fetch[$outputcolumn];
    }
}

function getWalletAddressMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `wallet_address1` IS NOT NULL AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}



function getbinanceAddressMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `Binance_account_number` IS NOT NULL AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}



function getDontbinanceAddressMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `Binance_account_number` IS Null AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}




function getDontWalletAddressMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `wallet_address1` IS Null AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}


function getMemberTotalFinancialIncome($conn, $userid)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `max_wallet_history` where `toid` = '" . $userid . "' AND `type` = 'Interest'";
    $res = query($conn, $sql);
    $num = numrows($res);

    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getMemberTotalGrabAmount($conn, $userid)
{

    $datetime = date('Y-m-d');

    $sql = "SELECT SUM(`amount`) AS total FROM `max_video` WHERE `userid`='" . $userid . "' AND `date` ='" . $datetime . "'";

    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function getNoOfActiveFeedback($conn)
{
    $sql = "SELECT `id` FROM `complaints_box` Where `status` = 'I'";
    $res = query_with_log($conn, $sql);
    $num = numrows($res);
    return $num;
}




function getMemberTotalAgencyincome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%Level%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


/**/


function getMemberpackageall($conn, $userid)
{
    $sql = "SELECT * FROM `stake` WHERE `userid`='" . $userid . "' AND `status`='A'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        return $num;
    } else {
        return 0;
    }
}
function getLuckyHitCurrentGameResultSum($conn, $tableName, $gameId, $sum, $coloum, $coloumSelect)
{
    $sql = "SELECT COALESCE(SUM(`$sum`),0) as total FROM `$tableName` WHERE `$coloum` = '" . $coloumSelect . "' AND `game_id` = '" . $gameId . "' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getMemberhourslyincome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%Hourly%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getDownLineInActive($conn, $sponsor)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsorid`='" . $sponsor . "' AND `status`='I' AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

/**/

function getUserReferralIncome($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Referral_Income%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}

function getMemberLevelTotal($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level%'";
    //print_r($jhhjk);die;
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    return $numdd['total'];
}

function totalInvest($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    return $numdd['total'];
}


function getMemberRechargeLevel1Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Refer_bonus_on_recharge%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    return $numdd['total'];
}


function getMemberLevel1Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level 1%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    $jhhjk2 = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Invited_Valid_Member%'";
    $hjuh2 = query($conn, $jhhjk2);
    $numdd2 = fetcharray($hjuh2);
    return $numdd['total'] + $numdd2['total'];
}

function getMemberLevel2Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level 2%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}

function getMemberLevel3Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level 3%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}
function getMemberLevel4Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level 4%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}
function getMemberLevel5Total($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level 5%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}

function getMemberLevel1Today($conn, $userid)
{
    $d = date('Y-m-d');
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";
    $sql = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` where `userid` = '" . $userid . "'AND `datetime`>='" . $date . "' AND `datetime`<='" . $datet . "' AND `level` LIKE '%Level 1%' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberLevel2Today($conn, $userid)
{
    $d = date('Y-m-d');
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";
    $sql = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` where `userid` = '" . $userid . "'AND `datetime`>='" . $date . "' AND `datetime`<='" . $datet . "' AND `level` LIKE '%Level 2%' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberLevel3Today($conn, $userid)
{
    $d = date('Y-m-d');
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";
    $sql = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` where `userid` = '" . $userid . "'AND `datetime`>='" . $date . "' AND `datetime`<='" . $datet . "' AND `level` LIKE '%Level 3%' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}




function getMemberLevelTeam($conn, $userid)
{
    $jhhjk = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` WHERE `userid` = '" . $userid . "' AND `level` LIKE '%Level%'";
    $hjuh = query($conn, $jhhjk);
    $numdd = fetcharray($hjuh);
    //pr($numdd['total']);
    return $numdd['total'];
}

function redirect($url)

{
    header('Location:' . $url);
    exit();
}

function query($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    return $res;
}

function numrows($exe)
{
    $no = mysqli_num_rows($exe);
    return $no;
}

function fetcharray($res)
{
    $fetch = mysqli_fetch_array($res);
    return $fetch;
}


function getAdmin($conn, $id, $field)
{
    $sql = "SELECT * FROM `max_admin` WHERE `id`='" . $id . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getTotalMember($conn)
{
    $sql = "SELECT `id` FROM `users`";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}
function getTotalMemberBlockUnblock($conn, $status)
{
    $sql = "SELECT `id` FROM `users` WHERE `block` = $status";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}


function getWalletValidationRequests($conn)
{
    $sql = "SELECT * FROM `max_member` Where `trxAddValid` = 0 AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getApprovedMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `status`='A' AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}




define('staticAPI', 'http://13.127.227.22/freeunlimited/v3/');
define('apiKey', 'key');
function getJoloBalance($conn)
{
    $paramList = array();
    $paramList["apikey"] = apiKey;
    $payload = json_encode($paramList, true);

    $url = staticAPI . "balance.php";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, 0);
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $response1 = json_decode($response);
    //print_r($response1);die;
    return $response1->balance;
}




function getInactiveMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `status`='I' AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getUnVerifiedMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `email_verfiy`=0 AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getVerifiedMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `email_verfiy` = 1 AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getBlockedMember($conn)
{
    $sql = "SELECT `id` FROM `max_member` WHERE `block`=1 AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getMemberUserid($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getMemberUserDetail($conn, $column, $userid, $field)
{
    $sql = "SELECT * FROM `users` WHERE `$column`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getCurrentGameResultSum($conn, $gameType, $gameId, $column, $gameNumber)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `booking` WHERE `game_id`='" . $gameId . "' AND `type`='" . $gameType . "' AND `$column`='" . $gameNumber . "' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function getCurrentGameAndarBharResultSum($conn, $gameId, $sumColoum, $betSelect)
{
    $sql = "SELECT SUM(`$sumColoum`) AS total FROM `andar_bahar_booking` WHERE `game_id`='" . $gameId . "'AND `selected`='" . $betSelect . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getGameName($number)
{

    if (isset($number) && $number == 1) {
        $name = "Parity";
    } elseif (isset($number) && $number == 2) {
        $name = "Sapre";
    } elseif (isset($number) && $number == 3) {
        $name = "Bcone";
    } elseif (isset($number) && $number == 4) {
        $name = "Emerd";
    } elseif (isset($number) && $number == 5) {
        $name = "Lucky Hit";
    } elseif (isset($number) && $number == 6) {
        $name = "Lucky Hit 2 Min";
    } else {
        $name = "No Game Found!";
    }

    return $name;
}


function getWinDetailsAmount($conn, $gameType, $gameId, $resColor, $resNo)
{
    $sql = "SELECT COALESCE(SUM(`dev_amount`),0) as total FROM `booking` WHERE `type` = '" . $gameType . "' AND `game_id` = '" . $gameId . "' AND (`color` = '" . $resColor . "' OR `number` = '" . $resNo . "')";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getWinDetailsAmountTwoColor($conn, $gameType, $gameId, $resColor1, $resColor2, $resNo)
{
    $sql = "SELECT COALESCE(SUM(`dev_amount`),0) as total FROM `booking` WHERE `type` = '" . $gameType . "' AND `game_id` = '" . $gameId . "' AND (`color` = '" . $resColor1 . "' OR `color` = '" . $resColor2 . "' OR `number` = '" . $resNo . "')";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}








function getMemberLevelIncome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%Level%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getMemberDirectIncome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%Direct%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getMemberDailyIncome($conn, $userid)
{
    $sql = "SELECT COALESCE(SUM(`commission`),0) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `date` LIKE '%" . date('Y-m-d') . "%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getMemberCheckIncome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' AND `level` LIKE '%Check%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getMember($conn, $id, $field)
{
    $sql = "SELECT * FROM `max_member` WHERE `id`='" . $id . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getAdminName($conn, $id, $field)
{
    $sql = "SELECT * FROM `max_admin` WHERE `id`='" . $id . "' ORDER BY `id`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getDownlineByPosition($conn, $sponsor, $position)
{
    $sql = "SELECT * FROM `max_genealogy_pool1` WHERE `placement`='" . $sponsor . "' AND `position`='" . $position . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        return $fetch['userid'];
    }
}

function getDownlineByPositionS($conn, $sponsor)
{
    $sql = "SELECT * FROM `max_genealogy_pool1` WHERE `placement`='" . $sponsor . "'";
    $res = query($conn, $sql);

    return $res;
}

function getWithdrawalMember($conn, $userid)
{
    $sql = "SELECT COALESCE(SUM(`request`),0) AS total FROM `max_withdrawal` WHERE `userid`='" . $userid . "'";


    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getDownlineCount($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member_count_pool1` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getSettingsWithdrawal($conn, $field)
{
    $sql = "SELECT * FROM `max_settings_withdrawal` ORDER BY `id` DESC LIMIT 1";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getPackage($conn)
{
    $sql = "SELECT * FROM `max_settings_joining` ORDER BY `id` DESC LIMIT 1";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch['joining'];
    }
}



function getUplineID($conn, $userid)
{
    $sql = "SELECT * FROM `max_genealogy_pool1` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch['placement'];
    }
}

function getDownlinePosition($conn, $userid, $placement)
{
    $sql1 = "SELECT * FROM `max_genealogy_pool1` WHERE `userid`='" . $userid . "' AND `placement`='" . $placement . "'";
    $res1 = query($conn, $sql1);
    $num1 = numrows($res1);
    if ($num1 > 0) {
        $fetch1 = fetcharray($res1);

        return $fetch1['position'];
    }
}

function getSales($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member_sales` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}



function getReward($conn, $id, $field)
{
    $sql = "SELECT * FROM `max_settings_reward` WHERE `id`='" . $id . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getSettingsFund($conn, $id, $field)
{
    $sql = "SELECT * FROM `max_settings_fundbonus` WHERE `id`='" . $id . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getRewardCommissionAdmin($conn)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_reward` WHERE `status`='R' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getPendingWithdrawalAdmin($conn)
{
    $sql = "SELECT SUM(`request`) AS total FROM `max_withdrawal` WHERE `status`='P' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getApprovedWithdrawalAdmin($conn)
{
    $sql = "SELECT SUM(`request`) AS total FROM `max_withdrawal` WHERE   `status`='A' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getNoOfSubadmin($conn)
{
    $sql = "SELECT * FROM `max_admin` WHERE `role`='S' AND `status`='A' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}



function getNoOfFeedback($conn)
{
    $sql = "SELECT `id` FROM `complaints_box` WHERE `status`= 'I'";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}




function getNoPair($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member_pair` WHERE `userid`='" . $userid . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        return $fetch[$field];
    }
}



function getJoining($conn, $field)
{
    $sql = "SELECT * FROM `max_settings_joining` ORDER BY `id` DESC LIMIT 1";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}



function getPackageAmt($conn, $field)
{
    $sql = "SELECT * FROM `max_settings_joining` ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getBoosterCount($conn, $userid)
{
    $sql = "SELECT * FROM `max_booster` WHERE `userid` = '" . $userid . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);

    if ($num > 0) {
        return 'Yes - ' . $num;
    }
    return 'No';
}

function getLeaderCount($conn, $userid)
{
    $sql = "SELECT * FROM `max_leaders` WHERE `userid` = '" . $userid . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);

    if ($num > 0) {
        return 'Yes - ' . $num;
    }
    return 'No';
}

function getTotalBoosterCount($conn)
{
    $sql = "SELECT * FROM `max_booster`";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getTotalLeadersCount($conn)
{
    $sql = "SELECT * FROM `max_leaders`";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getTotalRewardCount($conn)
{
    $sql = "SELECT * FROM `max_commission_reward`";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getRewardCommMember($conn, $userid)
{
    $sql = "SELECT SUM(`bonus`) AS total FROM `max_commission_reward` WHERE `userid`='" . $userid . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getTotalIncome($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getTotalIncomeYesterday($conn, $userid)
{
    $dateYesterday = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "'  AND `date` like'%" . $dateYesterday . "%'  ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}




function getRewardCommAdmin($conn)
{
    $sql = "SELECT SUM(`bonus`) AS total FROM `max_commission_reward` ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getMemberTotalIncome($conn, $userid)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `max_wallet_history` where `toid` = '" . $userid . "' AND `type` = 'Add' AND `userid` != 'Admin'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch['total'];
    }

    return 0;
}


function getDepositSMS($conn)
{
    $sql = "SELECT SUM(`quantity`) AS total FROM `max_sms_deposit`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch['total'];
    }
}
function getTotalSent($conn)
{
    $sql = "SELECT SUM(`quantity`) AS total FROM `max_sms_sent`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch['total'];
    }
}
function availableSMS($conn)
{
    $total = getDepositSMS($conn) - getTotalSent($conn);

    return $total;
}

function getSettingsReward($conn, $direct, $field)
{
    $sql = "SELECT * FROM `max_settings_reward` WHERE `direct`='" . $direct . "' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getSettingsPairing($conn, $field)
{
    $sql = "SELECT * FROM `max_settings_pairing` ORDER BY `id` DESC LIMIT 1";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}



function getDownline($conn, $sponsor)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsor`='" . $sponsor . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getAvailableSMS($conn)
{
    $total = getDepositSMS($conn) - getTotalSent($conn);
    return $total;
}

function getMemberReward($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member_reward` WHERE `userid`='" . $userid . "' AND `status`='R'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}


function getCountLeft($conn, $userid)
{
    $sql = "SELECT SUM(`left`) AS total FROM `max_member_count_pair` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        $total = $fetch['total'];

        return $total;
    }
}

function getCountRight($conn, $userid)
{
    $sql = "SELECT SUM(`right`) AS total FROM `max_member_count_pair`  WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        $total = $fetch['total'];

        return $total;
    }
}


function getSalesLeft($conn, $userid)
{
    $sql = "SELECT SUM(`left`) AS total FROM `max_member_sales` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        $total = $fetch['total'];

        return $total;
    }
}


function getTotalDirect($conn, $userid)
{
    $sql = "SELECT SUM(`left`) AS total FROM `max_member_sales` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        $total = $fetch['total'];

        return $total;
    }
}

function getCountLeftMember($conn, $userid)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsor`='" . $userid . "' AND `position`='Left'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $num;
    }
}


function getCountRightMember($conn, $userid)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsor`='" . $userid . "' AND `position`='Right'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $num;
    }
}



function getEpinAmount($conn, $userid)
{
    $sql = "SELECT sum(`total`) as total FROM `max_member_epin` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);
        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = 0;
        }
    } else {
        $total = 0;
    }

    return $total;
}



function getDownlineCountPair($conn, $userid, $field)
{
    $sql = "SELECT * FROM `max_member_count_pair` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}

function getDownlinePlacement($conn, $placement, $position)
{
    $sql = "SELECT * FROM `max_member` WHERE `placement`='" . $placement . "' AND `position`='" . $position . "' AND `paystatus`='A'";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getPendingWithdrawal($conn, $column)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `max_withdrawal` WHERE `status`='P' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getApprovedWithdrawal($conn, $column)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `max_withdrawal` WHERE `status`='A' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getDownLineActive($conn, $sponsor)
{
    $sql = "SELECT * FROM `max_member` WHERE `sponsorid`='" . $sponsor . "' AND `status`='A' AND `delete_id` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getPool1CommAdmin($conn)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `status`='R' ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}




function getPool1Commission($conn, $userid)
{
    $sql = "SELECT COALESCE(SUM(`commission`),0) AS total FROM `max_commission_pool1`  WHERE  `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



/*Query with log */

function checkDevice()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v1416|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return 'Mobile';
    }

    return 'Desktop';
}

function getBrowserDetect()
{
    $info = $_SERVER['HTTP_USER_AGENT'];
    // $mybrowser = get_browser();
    if (strpos($info, "Chrome") == true) {
        $output = "Chrome";
    } else if (strpos($info, "IE") == true) {
        $output = "Internet Explorer";
    } else if (strpos($info, "Firefox") == true) {
        $output = "Firrefox";
    } else {
        $output = "other";
    }
    return $output;
}

// Ok
function getIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function query_with_log($conn, $getquery)
{
    $ip = getIPAddress();
    $time = date("d-m-y H:i:s");
    $result = mysqli_query($conn, $getquery);
    $passpath = "query_logs/pass/";
    $failpath = "query_logs/fail/";
    $passfile = "query_logs.txt";
    $failfile = "query_logs.txt";
    $fileName =  basename($_SERVER['PHP_SELF']);


    if (!file_exists($failpath)) {
        mkdir($failpath, 0777, true);
    }
    if (!file_exists($passpath)) {
        mkdir($passpath, 0777, true);
    }

    if ($result) {
        $fp = fopen($passpath . $passfile, 'a');
        // fwrite($fp, "\n" . $getquery . ", IP:" . $ip . ", Device: " . checkDevice() . ", TIME:" . $time . "\n");
        fwrite($fp, "\n" . $getquery . ", IP:" . $ip . ", Device: " . checkDevice() . ", TIME:" . $time . ", File Name:" . $fileName . "\n");

        fclose($fp);
        return $result;
    } else {
        $fp = fopen($failpath . $failfile, 'a');
        // fwrite($fp, "\n" . strtoupper($getquery) . ", IP:" . $ip . ", Device: " . checkDevice() . ", TIME:" . $time . "\n");
        fwrite($fp, "\n" . $getquery . ", IP:" . $ip . ", Device: " . checkDevice() . ", TIME:" . $time . ", File Name:" . $fileName . "\n");
        fclose($fp);
        return $result;
    }
}


function getMemberTodaycommission($conn, $userid)
{
    $d = date('Y-m-d');
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";
    $sql = "SELECT COALESCE(SUM(`commission`),0) as total FROM `max_commission_pool1` where `userid` = '" . $userid . "'AND `my_time`>='" . $date . "' AND `my_time`<='" . $datet . "'  ORDER BY `id` DESC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberTotalcommission($conn, $userid)
{
    $sql = "SELECT SUM(`commission`) AS total FROM `max_commission_pool1` WHERE `userid`='" . $userid . "' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberTotalRecharge($conn, $userid)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `transactions` WHERE `userid`='" . $userid . "' AND `type` LIKE '%User_Recharge_Successful%'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberTotalwithdraw($conn, $userid)
{
    $sql = "SELECT SUM(`payout`) AS total FROM `max_withdrawal` WHERE `userid`='" . $userid . "' AND  `status` ='A'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

// function getOnlineRecharge($conn){
//     $sql = "SELECT SUM(`amount`) AS total FROM `transactions` WHERE `type` LIKE '%User_Recharge_Successful%' AND `status` LIKE '%Success%' ORDER BY `id` ASC";
//     $res = query($conn, $sql);
//     $num = numrows($res);
//     if ($num > 0) {
//         $fetch = fetcharray($res);

//         if ($fetch['total'] > 0) {
//             $total = $fetch['total'];
//         } else {
//             $total = number_format(0, 2);
//         }
//     } else {
//         $total = number_format(0, 2);
//     }
//     return $total;
// }


function getMemberTotalPackage($conn, $userid)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `stake` WHERE `userid`='" . $userid . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getMemberPackageDetails($conn, $id, $field)
{
    $sql = "SELECT * FROM `package` WHERE `id`='" . $id . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        return $fetch[$field];
    }
}




////////

function getOnlineRecharge($conn)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `transactions` WHERE `status` = 'Success' AND `type` LIKE '%Recharge_Successful%' ORDER BY `id` ASC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getOnlineRecharge333($conn)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `transactions` WHERE `status` = 'Success' AND `type` LIKE '%Recharge_Successful%' AND `id` <= 124 ORDER BY `id` ASC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getOnlineRecharge222($conn)
{
    $ppppp = getOnlineRecharge333($conn);

    $sql = "SELECT * FROM `transactions` WHERE `status` = 'Success' AND `type` LIKE '%Recharge_Successful%' AND `id` > 124 ORDER BY `id` ASC";
    $res = query($conn, $sql);
    $num = numrows($res);
    //pr($num);
    $total = 0;
    if ($num > 0) {
        $countttt = 0;
        while ($fetch = fetcharray($res)) {
            if ($countttt % 3 != 0) {
                $total = $total + $fetch['amount'];
            }
            $countttt++;
        }
    }

    return $total + $ppppp;
}



function getOnlineZozoRecharge44444444444($conn)
{
    $ppppww222p = getOnlineRecharge22233($conn);

    $sql = "SELECT * FROM `zozo_transactions` WHERE `status` = 'success' AND `id` > 2332 ORDER BY `id` ASC";
    $res22 = query($conn, $sql);
    $num = numrows($res22);
    //pr($num);
    $total22 = 0;
    if ($num > 0) {
        $countttt333 = 0;
        while ($fetchw = fetcharray($res22)) {
            if ($countttt333 % 2 != 0) {
                $total22 = $total22 + $fetchw['amount'];
            }
            $countttt333++;
        }
    }

    return $total22 + $ppppww222p;
}
function getOnlineRecharge22233($conn)
{
    $ppppwwp = getOnlineRecharge33322($conn);

    $sql = "SELECT * FROM `zozo_transactions` WHERE `status` = 'success' AND `id` > 27 AND `id` <= 2332 ORDER BY `id` ASC";
    $res22 = query($conn, $sql);
    $num = numrows($res22);
    //pr($num);
    $total22 = 0;
    if ($num > 0) {
        $countttt333 = 0;
        while ($fetchw = fetcharray($res22)) {
            if ($countttt333 % 3 != 0) {
                $total22 = $total22 + $fetchw['amount'];
            }
            $countttt333++;
        }
    }

    return $total22 + $ppppwwp;
}
function getOnlineRecharge33322($conn)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `zozo_transactions` WHERE `status` = 'success' AND `id` <= 27 ORDER BY `id` ASC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getOnlineRechargeZOZO($conn)
{
    $sql = "SELECT SUM(`amount`) AS total FROM `zozo_transactions` WHERE `status` = 'success' ORDER BY `id` ASC";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}




function getMemberIncomeReceive($conn, $userid, $amount)
{
    $sqlData1 = "SELECT * FROM `max_member` WHERE `userid` = '" . $userid . "'";
    $queryData1 = query_with_log($conn, $sqlData1);
    $sponData1 = fetcharray($queryData1);
    $total_package =  $sponData1['active_package'];
    $total_income_given_limit = round(($total_package * 2), 2);

    $total_income_given = $sponData1['total_non_working_income'];

    if (($total_income_given + $amount) < $total_income_given_limit) {
        return 1;
    } else {
        $sql = "UPDATE `max_member` SET `income_on_off` = 0 ,`income_off_time` ='" . date('Y-m-d H:i:s') . "' WHERE `userid`='" . $userid . "' AND `income_on_off` = 1";
        $res111 = query_with_log($conn, $sql);
        $sql651 = "UPDATE `stake` SET `complete`='1',`test`='Income_off_total_given_" . ($total_income_given + $amount) . "__income_limit_" . $total_income_given_limit . "', `complete_time` = '" . date('Y-m-d H:i:s') . "' WHERE `userid`='" . $userid . "' AND `complete` = '0' AND `amount` = 30";
        $res651 = query_with_log($conn, $sql651);

        return 0;
    }
}

function getMemberIncomeMagnumCheck($conn, $userid, $amount)
{
    $sqlData1 = "SELECT * FROM `max_member` WHERE `userid` = '" . $userid . "' AND `reward_eligibe` = '1' ORDER BY `id` ASC limit 1";
    $queryData1 = query_with_log($conn, $sqlData1);
    $numData1 = numrows($queryData1);
    if ($numData1 > 0) {
        $sponData1 = fetcharray($queryData1);
        $total_income_given = $sponData1['total_income_check'];

        if (($total_income_given + $amount) <= 300) {
            $onOff = 1;
        } else {
            $onOff = 0;
        }
    } else {
        $onOff = 1;
    }
    return $onOff;
}


function getTodayApprovedManualRechargeAdmin($conn)
{

    $d = date('Y-m-d');
    $date = $d . " 00:00:00";
    $t = date('Y-m-d');
    $datet = $t . " 23:59:59";

    $sql = "SELECT COALESCE(SUM(`amount`),0) AS total FROM `purchase` WHERE  `my_time`>='" . $date . "' AND `my_time`<='" . $datet . "'  AND  `status`='A'";
    $res = query_with_log($conn, $sql);
    $fetch = fetcharray($res);
    return $fetch['total'];
}


function getApprovedManualRechargeAdmin($conn)
{
    $sql = "SELECT COALESCE(SUM(`amount`),0) AS total FROM `purchase` WHERE `status`='A'";
    $res = query_with_log($conn, $sql);
    $fetch = fetcharray($res);
    return $fetch['total'];
}


function getTrxPrizeLive()
{
    $url = "https://api.coingecko.com/api/v3/simple/price?ids=tron&vs_currencies=usd";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $info = json_decode($result, true);
    // echo "<pre>";
    // print_r($info);

    // $usd = $info ['TRX_USD'] ['last_price'];
    // $trx = 1/$usd;


    $usd = $info['tron']['usd'];


    $trx = 1 / $usd;


    return $trx;
}





//
function getAllWithdrawalCommission($conn)
{
    $sql = "SELECT SUM(`charge`) AS total FROM `max_withdrawal` ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getAllMainToFundCommission($conn)
{
    $sql = "SELECT SUM(`amount_charge`) AS total FROM `max_main_to_fund_wallet` ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
//


function getIncomeProfitWallet($conn, $tableName)
{

    $sql = "SELECT SUM(`amount`) AS total FROM `$tableName` ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }


    $sql2 = "SELECT SUM(`income_given`) AS total FROM `$tableName` ";
    $res2 = query($conn, $sql2);
    $num2 = numrows($res2);
    if ($num2 > 0) {
        $fetch2 = fetcharray($res2);

        if ($fetch2['total'] > 0) {
            $total2 = $fetch2['total'];
        } else {
            $total2 = number_format(0, 2);
        }
    } else {
        $total2 = number_format(0, 2);
    }


    return  $total - $total2;
}


function getAllPurchaseRequests($conn)
{
    $sql = "SELECT * FROM `manual_transactions` WHERE `status` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getAllPurchaseApproved($conn)
{
    $sql = "SELECT * FROM `manual_transactions` WHERE `status` = 1";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getPurchaseRequestAmountAll($conn, $column, $status)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `manual_transactions` WHERE `status`=$status ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}


function getTotalPurchaseRequestAmount($conn, $column)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `manual_transactions`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function getTodayPurchaseRequestAmountAll($conn, $column, $status)
{

    $date = date('Y-m-d');

    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `manual_transactions` WHERE `status`= '" . $status . "' AND `my_time` = '" . $date . "' ";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getTodayPurchaseRequestAmount($conn, $column)
{
    $date = date('Y-m-d');

    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `manual_transactions` WHERE `my_time` = '" . $date . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}





function getAllWithdrawalRequests($conn)
{
    $sql = "SELECT * FROM `withdrawal` WHERE `status` = 0";
    $res = query($conn, $sql);
    $num = numrows($res);
    return $num;
}

function getWithdrawalRequestAmountAll($conn, $column, $status)
{
    $sql = "SELECT SUM(`" . $column . "`) AS total FROM `withdrawal` WHERE `status`='" . $status . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}

function getTotalWithdrawalManualOnline($conn, $sum, $status, $columnName, $columnValue)
{
    $sql = "SELECT SUM(`" . $sum . "`) AS total FROM `withdrawal` WHERE `status`='" . $status . "' AND `$columnName` = '" . $columnValue . "'";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}
function getTotalWithdrawalRequest($conn, $sum)
{
    $sql = "SELECT SUM(`" . $sum . "`) AS total FROM `withdrawal`";
    $res = query($conn, $sql);
    $num = numrows($res);
    if ($num > 0) {
        $fetch = fetcharray($res);

        if ($fetch['total'] > 0) {
            $total = $fetch['total'];
        } else {
            $total = number_format(0, 2);
        }
    } else {
        $total = number_format(0, 2);
    }
    return $total;
}



function getCyrusAmount()
{
    $curl22 = curl_init();
    curl_setopt_array($curl22, array(
        CURLOPT_URL => 'https://cyrusrecharge.in/api/balance.aspx?memberid=AP408307&pin=0FBFE623BB&format=json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: ASP.NET_SessionId=aca551ill0b2xcocpyblknrw'
        ),
    ));
    $response22 = curl_exec($curl22);
    curl_close($curl22);
    $response22 = json_decode($response22);
    $cyrusBalance = (isset($response22->Balance) && $response22->Balance >= 0) ? $response22->Balance : 'Cyrus_Issue';
    return $cyrusBalance;
}
