-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2018 年 06 月 04 日 08:29
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
-- 資料表結構 `friend`
--

CREATE TABLE `friend` (
  `userid` int(11) NOT NULL,
  `friend` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `pair`
--

CREATE TABLE `pair` (
  `userid` int(11) NOT NULL,
  `pair` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `pair`
--

INSERT INTO `pair` (`userid`, `pair`, `status`) VALUES
(11, 2, 0),
(2, 11, 0),
(1, 10, 0),
(10, 1, 0),
(9, 8, 0),
(8, 9, 0),
(7, 5, 0),
(5, 7, 0),
(6, 4, 0),
(4, 6, 0),
(3, 9, 0),
(9, 3, 0);

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
  `pair_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`userid`, `token`, `email`, `password`, `name`, `sex`, `birth_month`, `birth_date`, `birth_status`, `emotional_status`, `major`, `club`, `hobby`, `favorite_class`, `favorite_city`, `confusion`, `talent`, `dream`, `image`, `pair_status`) VALUES
(1, 'ev97604', 'evefaithe@gmail.com', 'dnkewlnkel', 'jason', 0, 5, 31, 1, 1, 15, '', '', '', '', '', '', '', 'profile.png', 0),
(2, '4077417', '406346220@gapp.fju.edu.tw', '333333', '李政', 1, 1231, 0, 0, 2, 1, '野砲社', '釣魚喝茶', '研究方法', '綠島', '盧浩鈞盧小小', '當班代', '當一輩子班代', 'profile.png', 0),
(3, '1279314', '1234@567.com', '0000', '林克晟', 1, 1, 27, 1, 1, 1, '日知會', '耍廢', '下課', '台南', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0),
(4, '4078497', '401401087@mail.fju.edu.tw', '0534', '柯唯揚', 1, 8, 6, 1, 5, 46, '魔術社', '躺著', '下課', '泰山', '睡不飽', '好像也沒有', '沒想過', 'profile.png', 0),
(5, 'he29602', 'heart2126@mail', '2126', '柯唯心', 1, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', 'profile.png', 0),
(6, 'zz42462', 'zzifanglaii@mail.com', '2126', '賴姿方', 1, 0, 0, 0, 0, 46, '', '', '', '', '', '', '', 'profile.png', 0),
(7, 'ma33569', 'marsharetea@gmail.com', 'puo0534', '柯唯揚', 1, 0, 0, 0, 0, 46, '', '', '', '', '', '', '', 'profile.png', 0),
(8, 'er86740', 'eric82918@gmail.com', 'xxxxxx', '江奕鴻', 0, 0, 0, 0, 0, 34, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0),
(9, 'du78125', 'duke0618@gmail.com', 'oo00oo0', 'Duke', 0, 0, 0, 0, 0, 39, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0),
(10, 'em84861', 'emilyyyyy@gmail.com', 'mkgdml', 'Emily', 1, 0, 0, 0, 0, 32, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0),
(11, 'Ab39192', 'Abby000@gmail.com', '09876', 'Abby', 0, 0, 0, 0, 0, 43, '未填', '未填', '未填', '未填', '未填', '未填', '未填', 'profile.png', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
