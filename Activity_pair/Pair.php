<?php
    // require("password.php");

    // ignore_user_abort();//關掉瀏覽器，PHP腳本也可以繼續執行.
    // set_time_limit(0);// 通過set_time_limit(0)可以讓程式無限制的執行下去
    // $interval=2;// 每隔...運行

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    $userIDs = array();
    $pairs = array();

    function downloadUserID() {
        global $con, $userIDs;
        // unset($GLOBALS['userIDs']);
        $userIDs = array();

        $statement = mysqli_prepare($con, "SELECT userid FROM user");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colUserID);
        $count = mysqli_stmt_num_rows($statement);

        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                $userIDs[] = $colUserID;
            }
            return true;
        } else {
            return false;
        }
    }

    function runPair() {
        global $userIDs, $pairs;
        // unset($pairs);
        $pairs = array();

        while (count($userIDs) > 1) { //第一批配對

            $id1 = $userIDs[rand(0, count($userIDs)-1)];
            $id2 = $userIDs[rand(0, count($userIDs)-1)];
            while (checkDuplicate($id1, $id2) || $id1 == $id2) {
                $id2 = $userIDs[rand(0, count($userIDs)-1)];
            }

            $pairs[] = [$id1, $id2];

            $lord[] = $id1;
            $angel[] = $id2;

            $userIDs = array_diff($userIDs, [$id1, $id2]);
            $userIDs = array_values($userIDs);

            // if (count($userIDs) == 1) {
            //     $pairs[] = [$userIDs[0], $pairs[rand(0, count($pairs)-1)][0]];
            // }
        }

        while (count($lord) > 0 && count($angel) > 0) { //第二批配對

            $id1 = $angel[rand(0, count($angel)-1)];
            $id2 = $lord[rand(0, count($lord)-1)];
            while (checkDuplicate($id1, $id2) || $id1 == $id2) {
                $id2 = $lord[rand(0, count($lord)-1)];
            }

            $pairs[] = [$id1, $id2];

            $lord = array_diff($lord, [$id2]);
            $lord = array_values($lord);
            $angel = array_diff($angel, [$id1]);
            $angel = array_values($angel);
        }
    }

    function checkDuplicate($id1, $id2) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT * FROM pair WHERE lord = ? AND angel = ? OR lord = ? AND angel = ?");
        mysqli_stmt_bind_param($statement, "iiii", $id1, $id2, $id2, $id1);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function uploadPairs() {
        global $con, $pairs;
        $statement = mysqli_prepare($con, "UPDATE pair SET status = 1 WHERE status = 0");
        mysqli_stmt_execute($statement);
        $statement = mysqli_prepare($con, "DELETE FROM friend WHERE status = -1");
        mysqli_stmt_execute($statement);

        for ($i=0; $i < count($pairs); $i++) {
            $statement = mysqli_prepare($con, "INSERT INTO pair (lord, angel) VALUES (?, ?)");
            mysqli_stmt_bind_param($statement, "ii", $pairs[$i][0], $pairs[$i][1]);
            mysqli_stmt_execute($statement);
        }
    }

    function resetPairStatus() {
        global $con;
        $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 0, pair_angel_status = 0");
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    // $i = 0;
    // do {
        if (downloadUserID()) {
            runPair();
            // foreach ($pairs as $key) {
            //     echo "<br>";
            //    foreach ($key as $key2) {
            //       echo $key2." ";
            //    }
            // }
            uploadPairs();
            resetPairStatus();
        }
    //     $i ++;
    //     sleep($interval);// 等待...分鐘
    // }while($i < 1);

?>
