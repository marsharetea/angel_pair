<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    $emails = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
    'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

    $firstname = array('金' , '柯' , '林' , '李' , '何' , '劉' , '方' , '周' , '蔡' ,
    '趙' , '魯' , '杜' , '呂' , '孔' , '曹' , '孟' , '楊' , '張' , '王' , '吳' , '蔣' ,
    '陳' , '黃' , '白' , '蔡' , '許' , '太' , '孫' , '包' , '宋' , '徐' , '賴' , '趙' ,
    '錢' , '孫' , '李' , '周' , '吳' , '鄭' , '王' , '蔣' , '沈' , '韓' , '楊' , '項' ,
    '祝' , '董' , '梁' , '熊' , '紀' , '舒' , '屈' , '葉' , '甘' , '古' , '馮' , '陳' ,
    '褚' , '魏' , '冉' , '段' , '司' , '夏' , '軒' , '車' , '牧' , '杜' , '賈' , '伍' ,
    '武' , '邱' , '馬' , '洪' , '富' , '潘' , '蘇' , '曹');

    $lastname = array('乾', '玲', '良', '超', '蹟', '俳', '雪', '娜', '摩', '朵', '亨',
    '雷', '處', '毛', '語', '振', '紅', '晃', '雯', '宜', '文', '學', '政', '冠', '唯',
    '揚', '達', '首', '強', '妍', '芳', '思', '牡', '湯', '尤', '克', '成', '浩', '英',
    '俊', '啟', '翔' , '輔' , '紹' , '仲' , '琮' , '凱' , '篤' , '瑪' , '柬' , '心' ,
    '希' , '昕' , '水' , '號' , '浩' , '財' , '齊' , '泣' , '愛' , '驁' , '短' , '大' ,
    '眾' , '莞' , '白' , '人' , '倫' , '士' , '程' , '傅' , '夫' , '爸' , '恁' , '夫' ,
    '玲' , '中' , '升' , '偉' , '剛' , '瑄' , '方' , '芳' , '樺' , '姿' , '婷' , '欽' ,
    '繼' , '季' , '聰' , '志' , '慧' , '丞');

    $clubs = array('動漫社', '野營社', '網球社', '熱音社', '吉他社', '歷史研究社', '魔術社',
    '歌唱社', '熱舞社', '調酒社', '中醫社', '康輔社', '證券研究社', '攝影社', '親善社', '劍道社',
    '棒球社', '羽球社', '空手道社', '輪回研究社', '翻牆社' , '轉聯會' , '學生會' , '領袖社' , '書法社' ,
    '電影社' , '聖經社' , '空手道社' , '跆拳道社' , '程設社' , '卡漫社' , '話劇社' , '美術社' , '新聞社' ,
    '合唱團' , '國樂社');

    $hobbys = array('游泳', '跑步', '追劇', '拳擊', '看書', '看電影', '唱歌', '攀岩', '抱石', '登山',
    '騎重機', '騎腳踏車', '聽音樂', '網球', '籃球', '撞球', '壘球', '棒球', '健走', '品酒', '羽球', '玩遊戲',
    '桌遊', '聊天', '潛水', '高爾夫球', '博弈', '翻花繩', '購物', '探索美食');

    $favorite_classS = array('英文課', '統計學', '微積分', '軟體工程', '系統開發', '經濟學', '貨幣銀行學',
    '財務管理', '電子商務', 'Web前端設計', '資料庫管理', '研究方法', '領導學', '大眾心理學', '程式應用', '大數據分析',
    '體育課', '會計學', '民法實務', '生理學');

    $favorite_citys = array('台北', '新北', '苗栗', '桃園', '彰化', '台中', '新竹', '雲林', '嘉義', '台南',
    '高雄', '屏東', '墾丁', '台東', '鹿野', '平溪', '斗六', '花蓮', '宜蘭', '三星', '新莊', '泰山', '東京',
    '倫敦', '西雅圖', '維也納', '布拉格', '大阪', '九州', '北海道', '平壤', '山東', '福建', '香港', '澳門',
    '首爾', '洛杉磯', '紐約', '邁阿密', '克里斯夫蘭', '金州', '曼哈頓', '新加玻', '胡志明市', '南投', '埔里',
    '京都', '北京', '上海', '湖南', '慕尼黑', '波士頓', '雅典', '夏威夷');

    $confusions = array('太胖', '太瘦', '太醜', '太矮', '貧乳', '對未來沒目標', '頭髮太稀疏', '交不到女朋友',
    '畢不了業', '報告交不出來', '成績太差', '沒朋友', '手機摔壞', '電腦摔壞', '牙齒痛不敢看牙醫', '女朋友管太多',
    '月底沒錢吃飯', '事情太多做不完', '找不到工作', '上星期車禍失去一條腿女朋友又跟人跑', '睡不著');

    $talents = array('唱歌', '拉小提琴', '網球', 'Java', '籃球', '桌球', '調酒', '跑步', '花錢', '攀岩',
    '吉他', '鋼琴', '繪畫', '英文', '日文', '做家事', '魔術', '打LOL', '羽球', 'Python', 'PHP', 'MySQL',
    '殺價', '看手相', '喝酒', '舔手肘', '泰拳', '舔鼻頭', '開八字腿', '打扮');

    $dreams = array('成為太空人', '年薪千萬', '交女朋友', '養寵物', '帶家人出國', '環遊世界', '幫助弱勢',
    '進入台積電', '當模特兒', '成為明星', '有個哥哥', '有個妹妹', '成為歌星', '生兒子', '生女兒', '長命百歲',
    '中樂透', '與周杰倫握手', '學年第一', '出國留學', '有個富爸爸', '開間餐廳', '學會飛翔', '找出百慕達的秘密',
    '裝潢自己的家', '喝醉', '吃胖', '學會開飛機', '成為奇樂', '田馥甄成為我女朋友');


    function registerUser() {
        global $con, $emails, $firstname, $lastname, $clubs, $hobbys, $favorite_classS, $favorite_citys, $confusions, $talents, $dreams;

        $email = $emails[rand(0, count($emails)-1)].$emails[rand(0, count($emails)-1)].rand(1000, 9999)."@gapp.fju.edu.tw";
        $password = rand(100000, 999999);
        $name = $firstname[rand(0, count($firstname)-1)].$lastname[rand(0, count($lastname)-1)].$lastname[rand(0, count($lastname)-1)];
        $sex = rand(1, 2);
        $birth_month = rand(1, 12);
        $birth_date = rand(1, 30);
        $birth_status = 1;
        $emotional_status = rand(0, 5);
        $major = rand(1, 47);
        $club = $clubs[rand(0, count($clubs)-1)];
        $hobby = $hobbys[rand(0, count($hobbys)-1)];
        $favorite_class = $favorite_classS[rand(0, count($favorite_classS)-1)];
        $favorite_city = $favorite_citys[rand(0, count($favorite_citys)-1)];
        $confusion = $confusions[rand(0, count($confusions)-1)];
        $talent = $talents[rand(0, count($talents)-1)];
        $dream = $dreams[rand(0, count($dreams)-1)];
        $image = "profile.png";
        $pair_lord_status = -1;
        $pair_angel_status = -1;
        $token = substr($email, 0, 2).rand(10000, 99999); //email前四碼+亂數四碼

        $statement = mysqli_prepare($con, "INSERT INTO user (token, email, password, name, sex, birth_month, birth_date, birth_status, emotional_status, major, club, hobby, favorite_class, favorite_city, confusion, talent, dream, image, pair_lord_status, pair_angel_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "ssssiiiiiissssssssii", $token, $email, $password, $name, $sex, $birth_month, $birth_date, $birth_status, $emotional_status, $major, $club, $hobby, $favorite_class, $favorite_city, $confusion, $talent, $dream, $image, $pair_lord_status, $pair_angel_status);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    function emailAvailable() {
        global $con, $email;
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE email = ?");
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        mysqli_stmt_close($statement);
        if ($count < 1){
            return true;
        } else {
            return false;
        }
    }

    // function getUserID() {
    //     global $con, $token, $response;
    //     $statement = mysqli_prepare($con, "SELECT userid FROM user WHERE token = ?");
    //     mysqli_stmt_bind_param($statement, "s", $token);
    //     mysqli_stmt_execute($statement);
    //     mysqli_stmt_store_result($statement);
    //     mysqli_stmt_bind_result($statement, $colUserID);
    //
    //     while (mysqli_stmt_fetch($statement)) {
    //         $response["userid"] = $colUserID;
    //         $response["token"] = $token;
    //     }
    // }

    $response = array();
    $response["success"] = false;

    for ($i=0; $i < 1; $i++) {
        if (emailAvailable()) {
            registerUser();
            // getUserID();
            $response["success"] = true;
        } else {
            // echo "Email is registered!";
            $response["error"] = "emailUsed";
        }
    }

    echo json_encode($response);
?>
