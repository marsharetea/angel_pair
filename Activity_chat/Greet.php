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

    function fireBase($con, $userID, $yoursID, $mode) {
        $statement = mysqli_prepare($con, "SELECT context, userid FROM chat WHERE relationid = (SELECT relationid FROM friend WHERE lord = ? AND angel = ?)");
        if ($mode == 1) {
            mysqli_stmt_bind_param($statement, "ii", $yoursID, $userID);
        } else {
            mysqli_stmt_bind_param($statement, "ii", $userID, $yoursID);
        }
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colContext, $colUserID);

        while (mysqli_stmt_fetch($statement)) {
            if ($colUserID == $userID) {
                if ($mode == 1) {
                    $filebase["angelid"] = $colUserID;
                    $filebase["angelcontext"] = $colContext;
                } else {
                    $filebase["lordid"] = $colUserID;
                    $filebase["lordcontext"] = $colContext;
                }
            } else {
                if ($mode == 1) {
                    $filebase["lordid"] = $colUserID;
                    $filebase["lordcontext"] = $colContext;
                } else {
                    $filebase["angelid"] = $colUserID;
                    $filebase["angelcontext"] = $colContext;
                }
            }
        }
        return $filebase;
    }

?>
