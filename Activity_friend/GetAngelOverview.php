<?php
    // require("password.php");
    include("../major_trans.php");
    include("../Activity_image/DownloadImg.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    // $index = $_POST["index"];
    $userID = 2;
    $token = "4010176";
    $index = 1;
    $interval = 8;
    $time_space = 14409;

    $temp_friend = array();
    $friends = array();

    function downloadFriend() {
        global $con, $userID, $token, $temp_friend, $response;
        $statement = mysqli_prepare($con, "SELECT relationid, angel, status FROM friend, user WHERE lord = ? AND user.token = ?");
        mysqli_stmt_bind_param($statement, "is", $userID, $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colRelationID, $colAngel, $colStatus);
        $count = mysqli_stmt_num_rows($statement);

        $response["friend_count"] = $count;
        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                $temp_friend[] = [$colRelationID, $colAngel, $colStatus];
            }
            return true;
        } else {
            return false;
        }
    }

    function getFriendBrief() {
        global $con, $userID, $index, $interval, $temp_friend, $friends, $response;
        $start = ($index-1)*$interval;
        if ($response["friend_count"] < $index*$interval) $end = $response["friend_count"]; else $end = $index*$interval;

        // for ($i=0; $i < $response["friend_count"]; $i++) {
        for ($i=$start; $i < $end; $i++) {
            $statement = mysqli_prepare($con, "SELECT userid, name, sex, major, image FROM user WHERE userid = ?");
            mysqli_stmt_bind_param($statement, "i", $temp_friend[$i][1]);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            mysqli_stmt_bind_result($statement, $colUserID, $colName, $colSex, $colMajor, $colImage);
            while (mysqli_stmt_fetch($statement)) {
                // $response["userid"] = $colUserID;
                // $response["sex"] = $colSex;
                // $response["major"] = urlencode(index_to_major($colMajor));
                // $response["image"] = urlencode(img_to_base64($colImage));
                $colContext = getLatestMessage($temp_friend[$i][0]);

                if ($temp_friend[$i][2] == 1 && !checkBlurStatus($temp_friend[$i][0])) {
                    $colImage2 = explode(".", $colImage);
                    $colImage = $colImage2[0]."_1.jpg";
                }

                $friends[] = array("userid" => $colUserID, "name" => urlencode($colName), "sex" => $colSex, "major" => urlencode(index_to_major($colMajor)), "image" => "http://140.136.133.78/angel_pair/imgg/".$colImage, "latest" => urlencode($colContext), "relationid" => $temp_friend[$i][0], "status" => $temp_friend[$i][2]);
            }
        }
        $response["friends"] = $friends;
        $response["friend_count"] -= $index*$interval;
    }

    function getLatestMessage($relationID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT context FROM chat WHERE relationid = ? ORDER BY `date` DESC, `time` DESC LIMIT 1");
        mysqli_stmt_bind_param($statement, "i", $relationID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colContext);
        while (mysqli_stmt_fetch($statement)) {
            return $colContext;
        }
        return "Nothing";
    }

    function checkBlurStatus($relationID) {
        global $con, $time_space;
        $statement = mysqli_prepare($con, "SELECT `date`, `time` FROM chat WHERE relationid = ?");
        mysqli_stmt_bind_param($statement, "i", $relationID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colDate, $colTime);
        while (mysqli_stmt_fetch($statement)) {
            $date = $colDate;
            $time = $colTime;
        }
        $date_arr = explode("/", $date);
        $time_arr = explode(":", $time);
        $pair_time = calculateTime($date_arr, $time_arr);

        date_default_timezone_set("Asia/Shanghai");
        $date = date("Y/m/d");
        $time = date("H:i:s");
        $date_arr = explode("/", $date);
        $time_arr = explode(":", $time);
        $current_time = calculateTime($date_arr, $time_arr);

        if ($current_time - $pair_time > $time_space) {
            $statement = mysqli_prepare($con, "UPDATE friend SET status = 0 WHERE relationid = ?");
            mysqli_stmt_bind_param($statement, "i", $relationID);
            mysqli_stmt_execute($statement);
            return true;
        } else {
            return false;
        }
    }

    function calculateTime($date_arr, $time_arr) {
        $totle_time = ((((($date_arr[0]*12+$date_arr[1]))*30)+$date_arr[2])*24+$time_arr[0])*60+$time_arr[1];
        return $totle_time;
    }

    $response = array();
    $response["success"] = false;

    if (downloadFriend()) {
        getFriendBrief();
        $response["success"] = true;
    } else {
        // echo "Get friend failed or No friend!";
        $response["error"] = "noFriend";
    }

    echo urldecode(json_encode($response));
?>
