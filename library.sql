-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-07-26 09:33:36
-- 服务器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `library`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `borrowbook` (IN `stu_id` INT, IN `book_id` INT, IN `Borrowdate` DATE, IN `Duedate` DATE, OUT `strresult` VARCHAR(32))  BEGIN
  set @n =(select lo_num from book where bookid = book_id);
	set @m =(select count(*) from borrow where bookid=book_id and stuid=stu_id);
	if @m>0 then 
		 set strresult='您已经借阅过该图书!';	
  elseif @n >0 then
     insert into borrow values(stu_id,book_id,Borrowdate,Duedate);
	   update book set lo_num=lo_num-1 where bookid = book_id;
	   update student set book_num=book_num+1 where stuid=stu_id;
	   set strresult='借阅成功！';
	else
	   set strresult='当前图书没有可借复本！';  
	end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `returnbook` (IN `stu_id` INT, IN `book_id` INT, IN `backdate` DATE, OUT `strresult` VARCHAR(32))  BEGIN
	set @n = (select count(*) from borrow where bookid=book_id and stuid=stu_id);
  if @n>0 then
	   delete from borrow where bookid=book_id and stuid=stu_id;
	   insert into book_return values(stu_id,book_id,backdate);
	   update book set lo_num = lo_num+1 where bookid=book_id;
     update student set book_num = book_num-1 where stuid=stu_id;
	   set strresult='还书成功!';
	else
	   set strresult='该学生未借阅该图书!';
  end if;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `adminuser`
--

CREATE TABLE `adminuser` (
  `adminid` int(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  `adname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `adminuser`
--

INSERT INTO `adminuser` (`adminid`, `password`, `adname`, `email`) VALUES
(1, '123456', '张三', '123@123.com'),
(2, '123456', '叶秋', 'yeqiu@yeqiu.com');

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE `book` (
  `bookid` int(20) NOT NULL,
  `bookname` varchar(128) NOT NULL,
  `author` varchar(64) NOT NULL,
  `press` varchar(64) NOT NULL,
  `position` varchar(128) NOT NULL,
  `sum_num` int(2) NOT NULL,
  `lo_num` int(2) NOT NULL,
  `catid` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`bookid`, `bookname`, `author`, `press`, `position`, `sum_num`, `lo_num`, `catid`) VALUES
(1, '解忧杂货店', '东野圭吾(日)', '南海出版社', '2楼2号书架', 2, 1, '1'),
(2, '白夜行', '东野圭吾(日)', '南海出版公司', '2楼3号书架', 3, 3, '1'),
(3, '冰与火之歌', '乔治·马丁', '重庆出版社', '2楼10号书架', 5, 4, '2'),
(4, '纸牌屋', '迈克尔·道布斯', '百花洲文艺出版社', '2楼11号书架', 3, 2, '2'),
(5, '线性代数', '居余马等', '清华大学出版社', '3楼1号书架', 2, 2, '3'),
(6, '数学分析', '程其襄', '高等教育出版社', '3楼2号书架', 1, 1, '3'),
(7, '计算机组成与设计：硬件/软件接口', 'David A.Patterson,John L.Hennessy', '机械工业出版社', '3楼7号书架', 1, 0, '4'),
(8, '数据结构、算法与应用', 'Sartaj Sahni', '机械工业出版社', '3楼7号书架', 2, 2, '4');

--
-- 触发器 `book`
--
DELIMITER $$
CREATE TRIGGER `inserttest` BEFORE INSERT ON `book` FOR EACH ROW BEGIN
if(NEW.bookid='' or NEW.bookname='' or NEW.author='' or NEW.press='' or NEW.position='' or NEW.sum_num='' or NEW.catid='')then
SIGNAL SQLSTATE  'ERROR' set MESSAGE_TEXT = '请检查输入数据!';
elseif (NEW.bookid in(select bookid from book))then
SIGNAL SQLSTATE  'ERROR' set MESSAGE_TEXT = '已存在此id!';
elseif(NEW.sum_num<=0) THEN
SIGNAL SQLSTATE  'ERROR' set MESSAGE_TEXT = '添加数量应大于0';
elseif(NEW.catid not in(select catid from category)) THEN
insert into category(catid) VALUE(NEW.catid);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `book_return`
--

CREATE TABLE `book_return` (
  `stuid` int(10) NOT NULL,
  `bookid` int(20) NOT NULL,
  `back_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `book_return`
--

INSERT INTO `book_return` (`stuid`, `bookid`, `back_date`) VALUES
(1, 2, '2020-06-05'),
(2, 4, '2020-06-01');

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

CREATE TABLE `borrow` (
  `stuid` int(10) NOT NULL,
  `bookid` int(20) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `borrow`
--

INSERT INTO `borrow` (`stuid`, `bookid`, `borrow_date`, `due_date`) VALUES
(1, 1, '2020-04-20', '2020-05-20'),
(2, 3, '2020-05-31', '2020-07-01'),
(2, 4, '2020-06-01', '2020-07-01'),
(2, 7, '2020-05-31', '2020-07-01');

-- --------------------------------------------------------

--
-- 替换视图以便查看 `borrow_view`
-- （参见下面的实际视图）
--
CREATE TABLE `borrow_view` (
`bookname` varchar(128)
,`author` varchar(64)
,`press` varchar(64)
,`position` varchar(128)
,`sum_num` int(2)
,`lo_num` int(2)
,`catid` char(10)
,`borrow_date` date
,`due_date` date
,`password` varchar(256)
,`name` varchar(128)
,`collage` varchar(128)
,`degree` varchar(128)
,`book_num` int(2)
,`bookid` int(20)
,`stuid` int(10)
);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `catid` char(10) NOT NULL,
  `catname` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`catid`, `catname`) VALUES
('1', '日本文学'),
('2', '欧美文学'),
('3', '数学'),
('4', '计算机');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `stuid` int(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(128) NOT NULL,
  `collage` varchar(128) NOT NULL,
  `degree` varchar(128) NOT NULL,
  `book_num` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`stuid`, `password`, `name`, `collage`, `degree`, `book_num`) VALUES
(1, 'abcdef', '令狐冲', '计算机学院', '本科生', 1),
(2, 'abcdef', '杨过', '数学院', '本科生', 3),
(3, 'abcdef', '郭靖', '材料学院', '研究生', 0),
(4, 'abcdef', '段誉', '文学院', '研究生', 0);

-- --------------------------------------------------------

--
-- 视图结构 `borrow_view`
--
DROP TABLE IF EXISTS `borrow_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `borrow_view`  AS  select `book`.`bookname` AS `bookname`,`book`.`author` AS `author`,`book`.`press` AS `press`,`book`.`position` AS `position`,`book`.`sum_num` AS `sum_num`,`book`.`lo_num` AS `lo_num`,`book`.`catid` AS `catid`,`borrow`.`borrow_date` AS `borrow_date`,`borrow`.`due_date` AS `due_date`,`student`.`password` AS `password`,`student`.`name` AS `name`,`student`.`collage` AS `collage`,`student`.`degree` AS `degree`,`student`.`book_num` AS `book_num`,`borrow`.`bookid` AS `bookid`,`borrow`.`stuid` AS `stuid` from ((`book` join `borrow` on(`book`.`bookid` = `borrow`.`bookid`)) join `student` on(`borrow`.`stuid` = `student`.`stuid`)) ;

--
-- 转储表的索引
--

--
-- 表的索引 `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`adminid`);

--
-- 表的索引 `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookid`),
  ADD KEY `catid` (`catid`);

--
-- 表的索引 `book_return`
--
ALTER TABLE `book_return`
  ADD PRIMARY KEY (`stuid`,`bookid`,`back_date`) USING BTREE,
  ADD KEY `book_return_ibfk_2` (`bookid`);

--
-- 表的索引 `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`stuid`,`bookid`),
  ADD KEY `borrow_ibfk_2` (`bookid`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- 表的索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stuid`);

--
-- 限制导出的表
--

--
-- 限制表 `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `book_return`
--
ALTER TABLE `book_return`
  ADD CONSTRAINT `book_return_ibfk_1` FOREIGN KEY (`stuid`) REFERENCES `student` (`stuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_return_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`stuid`) REFERENCES `student` (`stuid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `book` (`bookid`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
