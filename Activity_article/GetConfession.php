<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $index = $_POST["index"];
    $index = 1;
    $interval = 8;
    $articles = array();

    function getArticle() {
        global $con, $index, $interval, $articles, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM confession ORDER BY articleid DESC");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colArticleID, $colUserID, $colDate, $colTime, $colHead, $colArticle);

        $count = mysqli_stmt_num_rows($statement);
        $response["article_count"] = $count;

        $start = ($index-1)*$interval;
        if ($response["article_count"] < $index*$interval) $end = $response["article_count"]; else $end = $index*$interval;

        if ($count > 0) {
            $i = 0;
            while (mysqli_stmt_fetch($statement)) {

                if ($i >= $start && $i < $end) {
                    $statement2 = mysqli_prepare($con, "SELECT sex, major FROM user WHERE userid = ?");
                    mysqli_stmt_bind_param($statement2, "i", $colUserID);
                    mysqli_stmt_execute($statement2);
                    mysqli_stmt_store_result($statement2);
                    mysqli_stmt_bind_result($statement2, $colSex, $colMajor);
                    while (mysqli_stmt_fetch($statement2)) {
                        if ($colUserID == 1) {
                            $colSex2 = 2;
                        } else {
                            $colSex2 = $colSex;
                        }

                        $colMajor2 = $colMajor;
                    }

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

                    $articles[] = array("articleid" => $colArticleID, "userid" => $colUserID, "sex" => $colSex2, "major" => urlencode(index_to_major($colMajor2)), "date_time" => urlencode($colDate.$colTime), "head" => urlencode($colHead), "article" => urlencode($colArticle));

                }
                $i++;
            }

            $response["articles"] = $articles;
            $response["article_count"] -= $index*$interval;
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if (getArticle()) {
        $response["success"] = true;
    } else {
        // echo "Get article failed or No article!";
        $response["error"] = "noArticle";
    }

    echo urldecode(json_encode($response));
?>
