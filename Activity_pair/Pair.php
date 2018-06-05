<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    $userIDs = array();
    $pairs = array();

    function downloadUserID() {
        global $con, $userIDs;
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
        while (count($userIDs) > 1) {

            $id1 = $userIDs[rand(0, count($userIDs)-1)];
            $id2 = $userIDs[rand(0, count($userIDs)-1)];
            while ($id1 == $id2) {
                $id2 = $userIDs[rand(0, count($userIDs)-1)];
            }

            $pairs[] = [$id1, $id2];
            $userIDs = array_diff($userIDs, [$id1, $id2]);
            $userIDs = array_values($userIDs);

            if (count($userIDs) == 1) {
                $pairs[] = [$userIDs[0], $pairs[rand(0, count($pairs)-1)][0]];
            }
        }
    }

    function uploadPairs() {
        global $con, $pairs;
        $statement = mysqli_prepare($con, "UPDATE pair SET status = 1");
        mysqli_stmt_execute($statement);

        for ($i=0; $i < count($pairs); $i++) {
            $statement = mysqli_prepare($con, "INSERT INTO pair (lord, angel) VALUES (?, ?), (?, ?)");
            mysqli_stmt_bind_param($statement, "iiii", $pairs[$i][0], $pairs[$i][1], $pairs[$i][1], $pairs[$i][0]);
            mysqli_stmt_execute($statement);
        }
    }

    function resetPairStatus() {
        global $con;
        $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 0, pair_angel_status = 0");
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    if (downloadUserID()) {
        runPair();
        uploadPairs();
        resetPairStatus();
        print_r($pairs);
    }

?>
