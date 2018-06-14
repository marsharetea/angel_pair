<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $yoursID = $_POST["yoursID"];
    // $mode = $_POST["mode"];
    // $relationID = $_POST["relationid"];
    // $index = $_POST["index"];

    $userID = 2;
    // $yoursID = 3;
    // $mode = 0; //主人頁面為 1，天使頁面為 0
    $relationID = 3;
    $index = 1;
    $interval = 8;

    $contexts = array();

    // function getContext() {
    //     global $con, $userID, $yoursID, $mode, $contexts, $response;
    //     $statement = mysqli_prepare($con, "SELECT relationid FROM friend WHERE lord = ? AND angel = ?");
    //     if ($mode == 1) {
    //         mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
    //     } else {
    //         mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
    //     }
    //     mysqli_stmt_execute($statement);
    //     mysqli_stmt_store_result($statement);
    //     mysqli_stmt_bind_result($statement, $colRelationID);
    //     $count = mysqli_stmt_num_rows($statement);
    //
    //     if ($count > 0) {
    //         while (mysqli_stmt_fetch($statement)) {
    //                 $response["relationid"] = $colRelationID;
    //
    //                 $statement2 = mysqli_prepare($con, "SELECT date, time, context, userid FROM chat WHERE relationid = ?");
    //                 mysqli_stmt_bind_param($statement2, "i", $colRelationID);
    //                 mysqli_stmt_execute($statement2);
    //                 mysqli_stmt_store_result($statement2);
    //                 mysqli_stmt_bind_result($statement2, $colDate, $colTime, $colContext, $colUserID);
    //                 $count2 = mysqli_stmt_num_rows($statement2);
    //                 $response["context_count"] = $count2;
    //
    //                 while (mysqli_stmt_fetch($statement2)) {
    //
    //                     $colDate = explode("/", $colDate);
    //                     $colDate = (int)$colDate[1]."月".(int)$colDate[2]."日";
    //                     $colTime = explode(":", $colTime);
    //
    //                     if ((int)$colTime[0] > 12) {
    //                         $colTime = "下午".((int)$colTime[0]-12).":".$colTime[1];
    //                     } elseif ((int)$colTime[0] == 12) {
    //                         $colTime = "下午".(int)$colTime[0].":".$colTime[1];
    //                     } else {
    //                         $colTime = "上午".(int)$colTime[0].":".$colTime[1];
    //                     }
    //
    //                     if ($colUserID == $userID) $status = 0; else $status = 1;
    //
    //                     $contexts[] = array("date_time" => urlencode($colDate.$colTime), "context" => urlencode($colContext), "status" => $status); //0為自己說話，1為好友
    //
    //                 }
    //         }
    //
    //         $response["contexts"] = $contexts;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    function getContext() {
        global $con, $userID, $relationID, $index, $interval, $contexts, $response;
        $statement = mysqli_prepare($con, "SELECT date, time, context, userid FROM chat WHERE relationid = ? ORDER BY `date` DESC, `time` DESC");
        mysqli_stmt_bind_param($statement, "i", $relationID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colDate, $colTime, $colContext, $colUserID);
        $count = mysqli_stmt_num_rows($statement);
        $response["context_count"] = $count;

        $start = ($index-1)*$interval;
        if ($response["context_count"] < $index*$interval) $end = $response["context_count"]; else $end = $index*$interval;

        if ($count > 0) {
            $i = 0;
            while (mysqli_stmt_fetch($statement)) {

                if ($i >= $start && $i < $end) {
                    $colDate = explode("/", $colDate);
                    $colDate = (int)$colDate[1]."月".(int)$colDate[2]."日";
                    $colTime = explode(":", $colTime);

                    if ((int)$colTime[0] > 12) {
                        $colTime = "下午".((int)$colTime[0]-12).":".$colTime[1];
                    } elseif ((int)$colTime[0] == 12) {
                        $colTime = "下午".(int)$colTime[0].":".$colTime[1];
                    } else {
                        $colTime = "上午".(int)$colTime[0].":".$colTime[1];
                    }

                    if ($colUserID == $userID) $status = 0; else $status = 1;

                    $contexts[] = array("date_time" => urlencode($colDate.$colTime), "context" => urlencode($colContext), "status" => $status); //0為自己說話，1為好友
                }
                $i++;
            }

            $response["contexts"] = $contexts;
            $response["context_count"] -= $index*$interval;
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if (getContext()) {
        $response["success"] = true;
    } else {
        // echo "Get context failed or No context!";
        $response["error"] = "noContext";
    }

    echo urldecode(json_encode($response));
?>
