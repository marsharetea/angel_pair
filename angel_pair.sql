-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2018 年 06 月 21 日 19:22
-- 伺服器版本: 10.1.25-MariaDB
-- PHP 版本： 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `angel_pair`
--

-- --------------------------------------------------------

--
-- 資料表結構 `chat`
--

CREATE TABLE `chat` (
  `relationid` int(11) NOT NULL,
  `date` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `context` varchar(1000) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `chat`
--

INSERT INTO `chat` (`relationid`, `date`, `time`, `context`, `userid`) VALUES
(1, '2018/06/30', '23:10:10', 'ewjiewnt', 2),
(2, '2018/06/30', '23:10:10', 'ewjiewnt', 2),
(3, '2018/07/01', '15:08:07', '才怪', 2),
(3, '2018/07/01', '15:08:08', '握愛你', 2),
(4, '2018/05/31', '18:05:34', 'fuck', 2),
(5, '2018/04/05', '18:09:09', 'hey you', 2),
(6, '2018/04/07', '20:01:10', 'hello world', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `complain`
--

CREATE TABLE `complain` (
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `head` varchar(100) NOT NULL,
  `article` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `complain`
--

INSERT INTO `complain` (`articleid`, `userid`, `date`, `time`, `head`, `article`) VALUES
(1, 1, '2018/06/16', '14:41:06', '靠北輔大23622\n', '靠北自己是個智障\n竟然算錯了學分\n能不能畢業就靠暑修了⋯⋯'),
(2, 1, '2018/06/16', '14:41:06', '靠北輔大23621\n', '歷史 單同學,請停止對老師及同學無禮的行為可以嘛'),
(3, 1, '2018/06/16', '14:41:06', '靠北輔大23620\n', '6/15 人哲 蔡** 自己活動的時候滑手機滑那麼爽，現在來講大家都不用心？被老師嗆完發現自己的話站不住腳，立馬轉彎轉得比誰都快，佩服佩服。'),
(4, 1, '2018/06/16', '14:41:06', '靠北輔大23619\n', 'Line有群組到底是用來幹嘛的\n每次問什麼都不回，每次都裝沒看到\n不配合就算了還靠北別人⋯⋯'),
(5, 1, '2018/06/16', '14:41:06', '靠北輔大23618\n', '今天忘記拔車鑰匙，感謝今天幫我拔起來放前車廂的同學，真的很感謝你，方便的話讓我知道你是誰請你喝個飲料吧～！'),
(6, 1, '2018/06/16', '14:41:06', '靠北輔大23617\n', '這個人…太扯了吧！天理難容啊！大家看看～\n路過幫推個 期中都歐趴 身體財產都平安\n附個小偷帥氣的身龐⋯⋯'),
(7, 1, '2018/06/16', '14:41:06', '靠北輔大23616\n', '機吧 這次不碼車牌了'),
(8, 1, '2018/06/16', '14:41:06', '靠北輔大23615\n', '乙組的某些人 可以學會謙虛嗎\n先不管比賽的人打的怎樣 去笑別人的出手動作就是有問題\n說實在的啦 乙組除了大三大四的幾個其他的真的也沒多強 不用自以為高人一等⋯⋯');

-- --------------------------------------------------------

--
-- 資料表結構 `confession`
--

CREATE TABLE `confession` (
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `head` varchar(100) NOT NULL,
  `article` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `confession`
--

INSERT INTO `confession` (`articleid`, `userid`, `date`, `time`, `head`, `article`) VALUES
(1, 1, '2018/06/21', '15:55:22', '＃告白輔大 今天6/13 下午第六節到第七...', '今天6/13 下午第六節到第七節的下課中間\n有位從聖言樓五樓搭電梯下來的男生\n高高白白的 頭髮有點長又不太長\n我在電梯裡覺得想認識但是不好意思在那麼多人的電梯中搭訕\n真的好想知道你是誰哦！'),
(2, 1, '2018/06/21', '15:55:22', '＃告白輔大 請問企管大三的黃x庭有男友嗎?...', '請問企管大三的黃x庭有男友嗎?\n想認識'),
(3, 1, '2018/06/21', '15:55:22', '＃告白輔大 週五下午4點準備回家\n在理園全...', '週五下午4點準備回家\n在理園全家前面擦身而過\n穿白色背心黑褲戴帽子穿白襪的男生~~~\n我想再碰見你！'),
(4, 1, '2018/06/21', '15:55:22', '＃告白輔大 可以幫我tag他嗎？ 想認識他...', '可以幫我tag他嗎？ 想認識他'),
(5, 1, '2018/06/21', '15:55:22', '＃告白輔大 電×系系晶大二的××真的很正\n...', '電×系系晶大二的××真的很正\n很會穿搭，好想認識但是你感覺酷酷的\n是不是很多人追啊'),
(6, 1, '2018/06/21', '15:55:22', '＃告白輔大 最近常看到一個奶大的妹子\n都穿...', '最近常看到一個奶大的妹子\n都穿小背心\n有人知道是誰嗎？'),
(7, 1, '2018/06/21', '15:55:22', '＃告白輔大 剛剛在宜真前面填問卷做實驗的男...', '剛剛在宜真前面填問卷做實驗的男生好帥\n感覺是你組員派出你來的\n好想認識><\n可惜我趕時間 很想回頭幫你 但是太尷尬了\n不知道你是哪個系的⋯⋯');

-- --------------------------------------------------------

--
-- 資料表結構 `friend`
--

CREATE TABLE `friend` (
  `relationid` int(11) NOT NULL,
  `lord` int(11) NOT NULL,
  `angel` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `friend`
--

INSERT INTO `friend` (`relationid`, `lord`, `angel`, `status`) VALUES
(1, 2, 3, 1),
(2, 2, 4, 1),
(3, 2, 5, 2),
(4, 2, 6, 3),
(5, 7, 2, 2),
(6, 8, 2, 3),
(7, 9, 2, 1),
(8, 10, 2, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `message_complain`
--

CREATE TABLE `message_complain` (
  `messageid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message_confession`
--

CREATE TABLE `message_confession` (
  `messageid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `pair`
--

CREATE TABLE `pair` (
  `lord` int(11) NOT NULL,
  `angel` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `pair`
--

INSERT INTO `pair` (`lord`, `angel`, `status`) VALUES
(1, 10, 0),
(2, 3, 0),
(3, 2, 0),
(4, 5, 0),
(5, 9, 0),
(6, 8, 0),
(7, 6, 0),
(8, 4, 0),
(9, 7, 0),
(10, 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `presslike_complain`
--

CREATE TABLE `presslike_complain` (
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `presslike_complain`
--

INSERT INTO `presslike_complain` (`articleid`, `userid`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(5, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `presslike_confession`
--

CREATE TABLE `presslike_confession` (
  `articleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `token` varchar(16) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(16) NOT NULL,
  `name` varchar(16) NOT NULL,
  `sex` int(11) NOT NULL,
  `birth_month` int(11) NOT NULL,
  `birth_date` int(11) NOT NULL,
  `birth_status` int(11) NOT NULL,
  `emotional_status` int(11) NOT NULL,
  `major` int(11) NOT NULL,
  `club` varchar(16) NOT NULL,
  `hobby` varchar(16) NOT NULL,
  `favorite_class` varchar(16) NOT NULL,
  `favorite_city` varchar(16) NOT NULL,
  `confusion` varchar(64) NOT NULL,
  `talent` varchar(16) NOT NULL,
  `dream` varchar(64) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pair_lord_status` int(11) NOT NULL,
  `pair_angel_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`userid`, `token`, `email`, `password`, `name`, `sex`, `birth_month`, `birth_date`, `birth_status`, `emotional_status`, `major`, `club`, `hobby`, `favorite_class`, `favorite_city`, `confusion`, `talent`, `dream`, `image`, `pair_lord_status`, `pair_angel_status`) VALUES
(1, 'ev97604', 'evefaithe@gmail.com', 'dnkewlnkel', '靠北輔大', 0, 5, 31, 1, 1, 15, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(2, '4010176', '406346220@gapp.fju.edu.tw', '333333', '告白輔大', 1, 1231, 0, 0, 2, 1, '野砲社', '釣魚喝茶', '研究方法', '綠島', '盧浩鈞盧小小', '當班代', '當一輩子班代', 'profile.png', 0, 0),
(3, '1279314', '1234@567.com', '0000', '林克晟', 1, 1, 27, 1, 1, 1, '日知會', '耍廢', '下課', '台南', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0, 0),
(4, '4078497', '401401087@mail.fju.edu.tw', '0534', '柯唯揚', 1, 8, 6, 1, 5, 46, '魔術社', '躺著', '下課', '泰山', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0, 0),
(5, 'he29602', 'heart2126@mail', '2126', '柯唯心', 1, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(6, 'zz42462', 'zzifanglaii@mail.com', '2126', '賴姿方', 1, 0, 0, 0, 2, 46, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(7, 'ma33569', 'marsharetea@gmail.com', 'puo0534', '柯唯揚', 1, 0, 0, 0, 3, 46, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(8, 'er86740', 'eric82918@gmail.com', 'xxxxxx', '江奕鴻', 0, 0, 0, 0, 0, 34, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(9, 'du78125', 'duke0618@gmail.com', 'oo00oo0', 'Duke', 0, 0, 0, 0, 4, 39, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(10, 'em84861', 'emilyyyyy@gmail.com', 'mkgdml', 'Emily', 1, 0, 0, 0, 0, 32, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`relationid`,`date`,`time`);

--
-- 資料表索引 `complain`
--
ALTER TABLE `complain`
  ADD PRIMARY KEY (`articleid`,`userid`),
  ADD KEY `complain_ibfk_1` (`userid`);

--
-- 資料表索引 `confession`
--
ALTER TABLE `confession`
  ADD PRIMARY KEY (`articleid`,`userid`),
  ADD KEY `confession_ibfk_1` (`userid`);

--
-- 資料表索引 `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`relationid`);

--
-- 資料表索引 `message_complain`
--
ALTER TABLE `message_complain`
  ADD PRIMARY KEY (`messageid`,`articleid`,`userid`),
  ADD KEY `articleid` (`articleid`);

--
-- 資料表索引 `message_confession`
--
ALTER TABLE `message_confession`
  ADD PRIMARY KEY (`messageid`,`articleid`,`userid`),
  ADD KEY `articleid` (`articleid`);

--
-- 資料表索引 `pair`
--
ALTER TABLE `pair`
  ADD PRIMARY KEY (`lord`,`angel`);

--
-- 資料表索引 `presslike_complain`
--
ALTER TABLE `presslike_complain`
  ADD PRIMARY KEY (`articleid`,`userid`);

--
-- 資料表索引 `presslike_confession`
--
ALTER TABLE `presslike_confession`
  ADD PRIMARY KEY (`articleid`,`userid`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `complain`
--
ALTER TABLE `complain`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `confession`
--
ALTER TABLE `confession`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `friend`
--
ALTER TABLE `friend`
  MODIFY `relationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `message_complain`
--
ALTER TABLE `message_complain`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `message_confession`
--
ALTER TABLE `message_confession`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`relationid`) REFERENCES `friend` (`relationid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `complain`
--
ALTER TABLE `complain`
  ADD CONSTRAINT `complain_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `confession`
--
ALTER TABLE `confession`
  ADD CONSTRAINT `confession_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `message_complain`
--
ALTER TABLE `message_complain`
  ADD CONSTRAINT `message_complain_ibfk_1` FOREIGN KEY (`articleid`) REFERENCES `complain` (`articleid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `message_confession`
--
ALTER TABLE `message_confession`
  ADD CONSTRAINT `message_confession_ibfk_1` FOREIGN KEY (`articleid`) REFERENCES `confession` (`articleid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `presslike_complain`
--
ALTER TABLE `presslike_complain`
  ADD CONSTRAINT `presslike_complain_ibfk_1` FOREIGN KEY (`articleid`) REFERENCES `complain` (`articleid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `presslike_confession`
--
ALTER TABLE `presslike_confession`
  ADD CONSTRAINT `presslike_confession_ibfk_1` FOREIGN KEY (`articleid`) REFERENCES `confession` (`articleid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
