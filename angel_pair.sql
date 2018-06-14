-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2018 年 06 月 12 日 20:40
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
(38, '2018/06/12', '22:31:02', 'hey girl', 2),
(38, '2018/06/12', '22:31:34', 'hey girl', 10),
(38, '2018/06/12', '22:58:05', 'fuck me plz!', 10),
(38, '2018/06/13', '02:26:48', 'fuck me plz!', 10);

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
(1, 9, '2018/06/09', '15:22:44', '325', '隨便打 反正這邊匿名 我也不會被踢'),
(2, 11, '2018/06/09', '18:31:22', '3242', '345435'),
(3, 2, '2018/06/10', '01:03:35', '我是李鄭鄭鄭鄭鄭ㄓㄥ', '我沒有什麼可說的'),
(4, 2, '2018/06/10', '01:11:30', '我是主恩', '我沒有什麼可說的'),
(5, 2, '2018/06/10', '01:11:31', '我是主恩', '我沒有什麼可說的'),
(6, 2, '2018/06/10', '01:11:31', '我是主恩', '我沒有什麼可說的'),
(7, 2, '2018/06/10', '01:11:32', '我是主恩', '我沒有什麼可說的'),
(8, 2, '2018/06/10', '01:11:32', '我是主恩', '我沒有什麼可說的'),
(9, 2, '2018/06/10', '01:11:33', '我是主恩', '我沒有什麼可說的'),
(10, 2, '2018/06/10', '01:11:33', '我是主恩', '我沒有什麼可說的'),
(11, 2, '2018/06/10', '01:11:34', '我是主恩', '我沒有什麼可說的');

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
(3, 2, '2018/06/05', '15:40:28', '我是主恩恩恩恩恩恩', '我沒有什麼可說的'),
(4, 2, '2018/06/12', '03:33:15', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁'),
(5, 2, '2018/06/12', '03:33:27', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁'),
(6, 2, '2018/06/12', '03:33:27', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁'),
(7, 2, '2018/06/12', '03:33:27', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁'),
(8, 2, '2018/06/12', '03:33:28', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁'),
(9, 2, '2018/06/12', '09:07:02', '這裡是一個很美好的地方', '如題，這邊可靠北好多人呢！摁摁');

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
(28, 2, 3, 1),
(29, 5, 2, 1),
(30, 6, 2, 1),
(31, 2, 8, 1),
(32, 2, 1, 1),
(33, 10, 2, 1),
(34, 2, 28, 2),
(35, 2, 7, 2),
(36, 16, 2, 1),
(37, 18, 2, 3),
(38, 2, 10, 1);

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

--
-- 資料表的匯出資料 `message_complain`
--

INSERT INTO `message_complain` (`messageid`, `articleid`, `userid`, `date`, `time`, `message`) VALUES
(1, 11, 2, '2018/06/12', '09:23:00', '幹哩北七喔'),
(2, 11, 2, '2018/06/12', '09:33:56', '幹哩北七喔'),
(3, 11, 2, '2018/06/12', '09:33:57', '幹哩北七喔'),
(4, 11, 2, '2018/06/12', '09:33:57', '幹哩北七喔'),
(5, 11, 2, '2018/06/12', '09:33:58', '幹哩北七喔'),
(6, 11, 2, '2018/06/12', '09:33:58', '幹哩北七喔');

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

--
-- 資料表的匯出資料 `message_confession`
--

INSERT INTO `message_confession` (`messageid`, `articleid`, `userid`, `date`, `time`, `message`) VALUES
(3, 3, 2, '2018/06/12', '09:34:37', '賣鬧啦'),
(4, 3, 2, '2018/06/12', '09:34:38', '賣鬧啦'),
(5, 3, 2, '2018/06/12', '09:34:38', '賣鬧啦'),
(6, 3, 2, '2018/06/12', '09:34:38', '賣鬧啦'),
(7, 3, 2, '2018/06/12', '21:38:48', '賣鬧啦');

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
(1, 21, 0),
(2, 10, 0),
(3, 14, 0),
(4, 28, 0),
(5, 24, 0),
(6, 27, 0),
(7, 22, 0),
(8, 31, 0),
(9, 26, 0),
(10, 15, 0),
(11, 3, 0),
(12, 1, 0),
(14, 17, 0),
(15, 19, 0),
(16, 9, 0),
(17, 16, 0),
(18, 2, 0),
(19, 23, 0),
(20, 11, 0),
(21, 8, 0),
(22, 25, 0),
(23, 12, 0),
(24, 5, 0),
(25, 20, 0),
(26, 4, 0),
(27, 6, 0),
(28, 18, 0),
(29, 30, 0),
(30, 29, 0),
(31, 7, 0);

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
(1, 'ev97604', 'evefaithe@gmail.com', 'dnkewlnkel', 'jason', 0, 5, 31, 1, 1, 15, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(2, '4067088', '406346220@gapp.fju.edu.tw', '333333', '李政', 1, 1231, 0, 0, 2, 1, '野砲社', '釣魚喝茶', '研究方法', '綠島', '盧浩鈞盧小小', '當班代', '當一輩子班代', 'profile.png', 2, 0),
(3, '1279314', '1234@567.com', '0000', '林克晟', 1, 1, 27, 1, 1, 1, '日知會', '耍廢', '下課', '台南', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0, 0),
(4, '4078497', '401401087@mail.fju.edu.tw', '0534', '柯唯揚', 1, 8, 6, 1, 5, 46, '魔術社', '躺著', '下課', '泰山', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0, 0),
(5, 'he29602', 'heart2126@mail', '2126', '柯唯心', 1, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(6, 'zz42462', 'zzifanglaii@mail.com', '2126', '賴姿方', 1, 0, 0, 0, 2, 46, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(7, 'ma33569', 'marsharetea@gmail.com', 'puo0534', '柯唯揚', 1, 0, 0, 0, 3, 46, '', '', '', '', '', '', '', 'profile.png', 0, 0),
(8, 'er86740', 'eric82918@gmail.com', 'xxxxxx', '江奕鴻', 0, 0, 0, 0, 0, 34, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(9, 'du78125', 'duke0618@gmail.com', 'oo00oo0', 'Duke', 0, 0, 0, 0, 4, 39, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(10, 'em84861', 'emilyyyyy@gmail.com', 'mkgdml', 'Emily', 1, 0, 0, 0, 0, 32, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 2),
(11, 'Ab39192', 'Abby000@gmail.com', '09876', 'Abby', 0, 0, 0, 0, 5, 43, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(12, 'er37924', 'ericsomm@gmail.com', 'fewkmm', 'Eric', 0, 0, 0, 0, 1, 43, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0, 0),
(14, 'bp32089', 'bp1340@gapp.com.edu.tw', '950185', '蔡輔剛', 0, 7, 3, 1, 2, 8, '書法社', '探索美食', '大眾心理學', '洛杉磯', '頭髮太稀疏', '看手相', '裝潢自己的家', 'profile.png', 0, 0),
(15, 'sg31311', 'sg8083@gapp.com.edu.tw', '256315', '慧短', 1, 6, 17, 1, 3, 12, '網球社', '拳擊', 'Web前端設計', '布拉格', '電腦摔壞', '拉小提琴', '交女朋友', 'profile.png', 0, 0),
(16, 'ey47199', 'ey3900@gapp.com.edu.tw', '597157', '沈恁晃', 1, 8, 28, 1, 0, 7, '熱舞社', '購物', '民法實務', '墾丁', '月底沒錢吃飯', '籃球', '學年第一', 'profile.png', 0, 0),
(17, 'os93170', 'os8631@gapp.com.edu.tw', '381483', '蔡程昕', 1, 11, 27, 1, 5, 22, '棒球社', '網球', '貨幣銀行學', '胡志明市', '太醜', '做家事', '進入台積電', 'profile.png', 0, 0),
(18, 'qd55814', 'qd5662@gapp.com.edu.tw', '227432', '趙輔瑄', 1, 8, 23, 1, 5, 8, '羽球社', '翻花繩', 'Web前端設計', '山東', '電腦摔壞', '拉小提琴', '出國留學', 'profile.png', 0, 0),
(19, 'xw95679', 'xw9689@gapp.com.edu.tw', '447601', '蔡首雯', 1, 10, 13, 1, 2, 20, '翻牆社', '高爾夫球', '研究方法', '邁阿密', '頭髮太稀疏', '繪畫', '養寵物', 'profile.png', 0, 0),
(20, 'ef41085', 'ef2067@gapp.com.edu.tw', '684679', '趙浩學', 0, 8, 27, 1, 0, 27, '聖經社', '攀岩', '生理學', '桃園', '沒朋友', '籃球', '生女兒', 'profile.png', 0, 0),
(21, 'pv40650', 'pv7824@gapp.com.edu.tw', '243151', '甘妍瑄', 1, 9, 30, 1, 1, 43, '魔術社', '追劇', '研究方法', '斗六', '牙齒痛不敢看牙醫', '看手相', '交女朋友', 'profile.png', 0, 0),
(22, 'rk40877', 'rk9186@gapp.com.edu.tw', '481977', '紀瑄琮', 1, 1, 30, 1, 0, 28, '跆拳道社', '抱石', '大數據分析', '大阪', '手機摔壞', '羽球', '長命百歲', 'profile.png', 0, 0),
(23, 'qn48156', 'qn3224@gapp.com.edu.tw', '828369', '董夫雷', 1, 8, 7, 1, 2, 13, '轉聯會', '壘球', '大眾心理學', '台東', '畢不了業', '桌球', '生兒子', 'profile.png', 0, 0),
(24, 'dz88014', 'dz1168@gapp.com.edu.tw', '954619', '陳夫翔', 0, 5, 30, 1, 4, 1, '羽球社', '籃球', '體育課', '彰化', '對未來沒目標', '開八字腿', '有個妹妹', 'profile.png', 0, 0),
(25, 'ea61039', 'ea2191@gapp.com.edu.tw', '786156', '韓中乾', 0, 12, 14, 1, 3, 7, '劍道社', '聽音樂', '統計學', '邁阿密', '太矮', '魔術', '與周杰倫握手', 'profile.png', 0, 0),
(26, 'nv45334', 'nv6196@gapp.com.edu.tw', '100143', '黃成娜', 0, 5, 14, 1, 1, 24, '棒球社', '棒球', '經濟學', '台北', '畢不了業', '花錢', '成為奇樂', 'profile.png', 0, 0),
(27, 'fk32400', 'fk4363@gapp.fju.edu.tw', '606564', '孔克樺', 1, 7, 6, 1, 3, 46, '康輔社', '追劇', '統計學', '桃園', '頭髮太稀疏', '吉他', '生兒子', 'profile.png', 0, 0),
(28, 'ru71493', 'ru6353@gapp.fju.edu.tw', '316836', '白驁良', 1, 2, 20, 1, 2, 39, '證券研究社', '桌遊', '大數據分析', '泰山', '太瘦', '打LOL', '找出百慕達的秘密', 'profile.png', 0, 0),
(29, 'ee59171', 'ee8799@gapp.fju.edu.tw', '220956', '何芝樺', 1, 11, 10, 1, 2, 30, '歷史研究社', '羽球', '程式應用', '倫敦', '成績太差', '拉小提琴', '開間餐廳', 'profile.png', 0, 0),
(30, 'xj78564', 'xj8038@gapp.fju.edu.tw', '803833', '車瓊方', 1, 5, 28, 1, 2, 33, '熱音社', '桌遊', 'Web前端設計', '倫敦', '對未來沒目標', '打LOL', '喝醉', 'profile.png', 0, 0),
(31, 'tg37246', 'tg7085@gapp.fju.edu.tw', '869245', '蔡篤振', 0, 7, 5, 1, 1, 2, '話劇社', '追劇', '系統開發', '香港', '對未來沒目標', '英文', '找出百慕達的秘密', 'profile.png', 0, 0);

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
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- 使用資料表 AUTO_INCREMENT `confession`
--
ALTER TABLE `confession`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `friend`
--
ALTER TABLE `friend`
  MODIFY `relationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- 使用資料表 AUTO_INCREMENT `message_complain`
--
ALTER TABLE `message_complain`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `message_confession`
--
ALTER TABLE `message_confession`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
