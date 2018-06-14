<?php

    function addGreet($con, $userID, $yoursID, $mode, $context) {

        date_default_timezone_set("Asia/Shanghai");
        $date = date("Y/m/d");
        $time = date("H:i:s");

        $statement = mysqli_prepare($con, "SELECT relationid FROM friend WHERE lord = ? AND angel = ?");
        if ($mode == 1) {
            mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
        } else {
            mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
        }
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colRelationID);

        while (mysqli_stmt_fetch($statement)) {
            $statement = mysqli_prepare($con, "INSERT INTO chat (relationid, date, time, context, userid) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($statement, "isssi", $colRelationID, $date, $time, $context, $userID);
            mysqli_stmt_execute($statement);
        }
    }

?>
