-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-09-08 15:39:08
-- 服务器版本： 5.5.61-log
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `os_bibashi_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_cates`
--

CREATE TABLE IF NOT EXISTS `admin_cates` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `mobile` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `url` varchar(50) DEFAULT NULL COMMENT '后台地址',
  `link` varchar(300) DEFAULT NULL COMMENT '外链',
  `rel` varchar(150) NOT NULL COMMENT 'rel值',
  `pid` int(11) NOT NULL COMMENT '父级菜单编号',
  `left_value` int(11) NOT NULL COMMENT '左值',
  `right_value` int(11) NOT NULL COMMENT '右值',
  `rank` int(11) NOT NULL COMMENT '排序值',
  `status` tinyint(4) NOT NULL COMMENT '显示状态',
  `project_id` int(11) DEFAULT NULL COMMENT '所属项目',
  `last_ip` int(11) NOT NULL COMMENT '最后登录IP',
  `last_time` int(11) NOT NULL COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='后台管理菜单';

--
-- 转存表中的数据 `admin_cates`
--

INSERT INTO `admin_cates` (`id`, `name`, `mobile`, `url`, `link`, `rel`, `pid`, `left_value`, `right_value`, `rank`, `status`, `project_id`, `last_ip`, `last_time`, `create_time`) VALUES
(1, '系统管理中心', NULL, '', '', '90a6a254f8d98abf62bb8856676a9a3d', 0, 1, 8, 1, 2, NULL, 2130706433, 1534345419, 1534338143),
(2, '管理员列表', NULL, 'Adminuser/index', NULL, '15d1e0b41a33e8b437de71c68f726545', 1, 2, 3, 3, 2, NULL, 2130706433, 1534338143, 1534338143),
(3, '管理角色列表', NULL, 'Adminrole/index', NULL, '3030d82aacbb9fbc79bf46d3559fc358', 1, 4, 5, 8, 2, NULL, 2130706433, 1534338143, 1534338143),
(4, '管理菜单列表', NULL, 'Admincate/index', NULL, '6d3d25678b1bc03fd7504b39b5cca2b5', 1, 6, 7, 10, 2, NULL, 2130706433, 1534338143, 1534338143),
(53, '会员管理', NULL, '', '', '24735fbe94183d03d5bbfc5a24bf51d6', 0, 9, 18, 11, 2, NULL, 2130706433, 1534996137, 1534996104),
(54, '会员列表', NULL, 'Users/index', '', '882bf02ce25e0d4965075c0f38059702', 53, 10, 11, 12, 2, NULL, 2130706433, 1535005365, 1534996151),
(56, '会员流水', NULL, 'Logs/index', '', 'f9958b7abd0406f7bffa6af961876821', 53, 12, 13, 14, 2, NULL, 2130706433, 1535011911, 1535011884),
(57, '会员订单', NULL, 'Orders/index', '', 'bb403e35e2267ecce44483c7633df78b', 53, 14, 15, 15, 2, NULL, 2130706433, 1535079720, 1535079563),
(58, '消息列表', NULL, 'Messages/index', '', '99c37e2779be6a4b76451d9793243503', 53, 16, 17, 16, 2, NULL, 2130706433, 1535097700, 1535082004);

-- --------------------------------------------------------

--
-- 表的结构 `admin_cate_has_roles`
--

CREATE TABLE IF NOT EXISTS `admin_cate_has_roles` (
  `id` int(11) NOT NULL COMMENT '主键编号',
  `cate_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单所属角色';

-- --------------------------------------------------------

--
-- 表的结构 `admin_cate_has_users`
--

CREATE TABLE IF NOT EXISTS `admin_cate_has_users` (
  `id` int(11) NOT NULL COMMENT '主键编号',
  `cate_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单所属用户';

-- --------------------------------------------------------

--
-- 表的结构 `admin_roles`
--

CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `rank` int(11) NOT NULL COMMENT '角色排序',
  `status` tinyint(3) NOT NULL COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员角色';

--
-- 转存表中的数据 `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `rank`, `status`) VALUES
(1, '系统管理员', 99999, 2),
(2, '网站内容运营', 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL COMMENT '编号',
  `mobile` char(11) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(50) DEFAULT NULL COMMENT '联系邮箱',
  `name` varchar(30) NOT NULL COMMENT '用户名称',
  `real_name` varchar(30) DEFAULT NULL COMMENT '真实名称',
  `pwd` varchar(50) NOT NULL COMMENT '密码',
  `status` tinyint(3) NOT NULL COMMENT '状态',
  `last_ip` int(11) NOT NULL COMMENT '最后更新ip',
  `last_time` int(11) NOT NULL COMMENT '最后更新时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员';

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `mobile`, `email`, `name`, `real_name`, `pwd`, `status`, `last_ip`, `last_time`, `create_time`) VALUES
(1, '13027199172', NULL, 'admin', '超级管理员', '46f92d17ba', 2, 2147483647, 1536385492, 1531987115),
(2, '13027199177', NULL, 'damow', '大魔王', '46f92d17ba', 2, 2130706433, 1534990880, 1534990880);

-- --------------------------------------------------------

--
-- 表的结构 `admin_user_has_roles`
--

CREATE TABLE IF NOT EXISTS `admin_user_has_roles` (
  `id` int(11) NOT NULL COMMENT '主键编号',
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户所属角色';

-- --------------------------------------------------------

--
-- 表的结构 `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL COMMENT '编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `reuser_id` int(11) unsigned NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '类型',
  `count` decimal(12,4) NOT NULL COMMENT '数量',
  `ret_count` decimal(12,4) NOT NULL COMMENT '兑换数量',
  `note` varchar(150) NOT NULL COMMENT '内容备注',
  `source` varchar(20) NOT NULL COMMENT '操作来源',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0删除，1显示',
  `subtract` int(1) NOT NULL DEFAULT '0' COMMENT '0减,1加'
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COMMENT='用户操作日志';

--
-- 转存表中的数据 `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `reuser_id`, `type`, `count`, `ret_count`, `note`, `source`, `create_time`, `status`, `subtract`) VALUES
(1, 1001, 0, 0, '20.0000', '120.0000', '兑换资产', 'exchangeassets', 1536299095, 1, 0),
(2, 1001, 1005, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536299509, 1, 0),
(3, 1001, 1005, 6, '5.0000', '5.0000', '转增激活次数', 'giveactivation', 1536299698, 1, 0),
(4, 1005, 1001, 6, '5.0000', '5.0000', '获得激活次数', 'giveactivation', 1536299698, 1, 0),
(5, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536300134, 1, 0),
(6, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536300163, 1, 0),
(7, 1001, 0, 0, '20.0000', '120.0000', '兑换资产', 'exchangeassets', 1536300248, 1, 0),
(8, 1001, 0, 0, '20.0000', '120.0000', '兑换资产', 'exchangeassets', 1536300319, 1, 0),
(9, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301210, 1, 0),
(10, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(11, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(12, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(13, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(14, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(15, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(16, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301212, 1, 0),
(17, 1001, 0, 0, '500.0000', '1.0000', '兑换激活次数', 'exchangeactivationco', 1536301226, 1, 0),
(18, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301405, 1, 0),
(19, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536301497, 1, 0),
(20, 1001, 0, 0, '20.0000', '120.0000', '兑换资产', 'exchangeassets', 1536303231, 1, 0),
(21, 1001, 0, 0, '20.0000', '120.0000', '兑换资产', 'exchangeassets', 1536303327, 1, 0),
(22, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303646, 1, 0),
(23, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303648, 1, 0),
(24, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303648, 1, 0),
(25, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303648, 1, 0),
(26, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303650, 1, 0),
(27, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303650, 1, 0),
(28, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(29, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(30, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(31, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(32, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(33, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303651, 1, 0),
(34, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536303672, 1, 0),
(35, 1001, 1023, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536310574, 1, 0),
(36, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536311802, 1, 0),
(37, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536311803, 1, 0),
(38, 1001, 1001, 2, '0.7200', '0.7200', '释放资产', 'release', 1536313204, 1, 0),
(39, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536314835, 1, 0),
(40, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536314837, 1, 0),
(41, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536314848, 1, 0),
(42, 1023, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536314850, 1, 0),
(43, 1023, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536314851, 1, 0),
(44, 1023, 0, 0, '1000.0000', '2.0000', '兑换激活次数', 'exchangeactivationco', 1536314876, 1, 0),
(45, 1023, 1001, 6, '1.0000', '1.0000', '转增激活次数', 'giveactivation', 1536315323, 1, 0),
(46, 1001, 1023, 6, '1.0000', '1.0000', '获得激活次数', 'giveactivation', 1536315323, 1, 0),
(47, 1023, 1001, 6, '1.0000', '1.0000', '转增激活次数', 'giveactivation', 1536315352, 1, 0),
(48, 1001, 1023, 6, '1.0000', '1.0000', '获得激活次数', 'giveactivation', 1536315352, 1, 0),
(49, 1001, 1023, 6, '2.0000', '2.0000', '转增激活次数', 'giveactivation', 1536316950, 1, 0),
(50, 1023, 1001, 6, '2.0000', '2.0000', '获得激活次数', 'giveactivation', 1536316950, 1, 0),
(51, 1023, 1025, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536317102, 1, 0),
(52, 1023, 1026, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536317255, 1, 0),
(53, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536317367, 1, 0),
(54, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536317373, 1, 0),
(55, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536317378, 1, 0),
(56, 1001, 1027, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536374217, 1, 0),
(57, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374427, 1, 0),
(58, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374432, 1, 0),
(59, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374434, 1, 0),
(60, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374840, 1, 0),
(61, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374849, 1, 0),
(62, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374861, 1, 0),
(63, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374862, 1, 0),
(64, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374862, 1, 0),
(65, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374863, 1, 0),
(66, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374863, 1, 0),
(67, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374863, 1, 0),
(68, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374881, 1, 0),
(69, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374895, 1, 0),
(70, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374896, 1, 0),
(71, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374897, 1, 0),
(72, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374898, 1, 0),
(73, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374958, 1, 0),
(74, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374986, 1, 0),
(75, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374992, 1, 0),
(76, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374993, 1, 0),
(77, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374993, 1, 0),
(78, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536374993, 1, 0),
(79, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375052, 1, 0),
(80, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375054, 1, 0),
(81, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375089, 1, 0),
(82, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375129, 1, 0),
(83, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375161, 1, 0),
(84, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375162, 1, 0),
(85, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375162, 1, 0),
(86, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375162, 1, 0),
(87, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375162, 1, 0),
(88, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375162, 1, 0),
(89, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(90, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(91, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(92, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(93, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(94, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(95, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(96, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(97, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(98, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(99, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375163, 1, 0),
(100, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375164, 1, 0),
(101, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375164, 1, 0),
(102, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375164, 1, 0),
(103, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375167, 1, 0),
(104, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375173, 1, 0),
(105, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375180, 1, 0),
(106, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375180, 1, 0),
(107, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375184, 1, 0),
(108, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375190, 1, 0),
(109, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375195, 1, 0),
(110, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375199, 1, 0),
(111, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375203, 1, 0),
(112, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375205, 1, 0),
(113, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375205, 1, 0),
(114, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375206, 1, 0),
(115, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375206, 1, 0),
(116, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375206, 1, 0),
(117, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375217, 1, 0),
(118, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375222, 1, 0),
(119, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375225, 1, 0),
(120, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375330, 1, 0),
(121, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375610, 1, 0),
(122, 1001, 0, 0, '0.0000', '0.0000', '兑换激活次数', 'exchangeactivationco', 1536375626, 1, 0),
(123, 1021, 0, 0, '500.0000', '1.0000', '兑换激活次数', 'exchangeactivationco', 1536386950, 1, 0),
(124, 1021, 1029, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536387184, 1, 0),
(125, 1021, 0, 0, '1000.0000', '2.0000', '兑换激活次数', 'exchangeactivationco', 1536387295, 1, 0),
(126, 1021, 1029, 7, '1.0000', '1.0000', '激活用户', 'activation', 1536388132, 1, 0),
(127, 1021, 0, 0, '20.0000', '20.0000', '兑换资产', 'exchangeassets', 1536388270, 1, 0),
(128, 1021, 0, 0, '20.0000', '20.0000', '兑换资产', 'exchangeassets', 1536388271, 1, 0),
(129, 1029, 0, 0, '20.0000', '20.0000', '兑换资产', 'exchangeassets', 1536388470, 1, 0),
(131, 1021, 1021, 2, '8.2552', '8.2552', '释放资产', 'release', 1536390284, 1, 0),
(132, 1021, 1021, 3, '5.7786', '5.7786', '释放奖励金额', 'release', 1536390284, 1, 1),
(133, 1021, 1021, 9, '2.4765', '2.4765', '释放奖励虚拟币', 'release', 1536390284, 1, 1),
(134, 1021, 1021, 2, '8.2304', '8.2304', '释放资产', 'login', 1536391563, 1, 0),
(135, 1021, 1021, 3, '5.7613', '5.7613', '释放奖励金额', 'login', 1536391563, 1, 1),
(136, 1021, 1021, 9, '2.4691', '2.4691', '释放奖励虚拟币', 'login', 1536391563, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL COMMENT '编号',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` varchar(300) NOT NULL COMMENT '内容',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `to_user_id` int(11) DEFAULT '0' COMMENT '接受用户编号',
  `show_time` int(11) NOT NULL COMMENT '显示时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(3) DEFAULT '1' COMMENT '0删除1显示'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='消息通知';

--
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `user_id`, `to_user_id`, `show_time`, `create_time`, `status`) VALUES
(1, '111', '11', 11, 1001, 1535014936, 1535014936, 1),
(2, '测试2', '测试2', 0, 0, 1535558399, 1535014936, 1);

-- --------------------------------------------------------

--
-- 表的结构 `message_flags`
--

CREATE TABLE IF NOT EXISTS `message_flags` (
  `id` int(11) NOT NULL COMMENT '编号',
  `message_id` int(11) NOT NULL COMMENT '消息编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='消息标记';

--
-- 转存表中的数据 `message_flags`
--

INSERT INTO `message_flags` (`id`, `message_id`, `user_id`, `create_time`) VALUES
(1, 1, 1001, 1535521844);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL COMMENT '编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `buy_user_id` int(11) DEFAULT NULL COMMENT '购买用户编号',
  `num` decimal(12,4) NOT NULL COMMENT '数量',
  `price` decimal(12,4) NOT NULL COMMENT '单价',
  `status` tinyint(3) NOT NULL COMMENT '订单状态 0 新订单 1 成交 2 关闭',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `last_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `type` int(3) unsigned DEFAULT '1' COMMENT '交易类型'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='订单';

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `buy_user_id`, `num`, `price`, `status`, `create_time`, `last_time`, `type`) VALUES
(1, 11, 1, '1.0000', '2.0000', 1, 1535014936, 1535097634, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL COMMENT '编号',
  `token` varchar(255) NOT NULL COMMENT '秘钥',
  `mobile` char(11) NOT NULL COMMENT '手机号码',
  `nick_name` varchar(30) NOT NULL COMMENT '昵称',
  `pwd` char(10) NOT NULL COMMENT '登录密码',
  `pay_pwd` char(10) NOT NULL COMMENT '支付密码',
  `head_image` varchar(255) NOT NULL DEFAULT 'cover_img/head.png' COMMENT '头像',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `assets` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT '资产',
  `coin` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT '虚拟币 TFC',
  `money` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT 'EP',
  `status` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1 启用 2 激活',
  `left_value` int(11) NOT NULL COMMENT '左值',
  `right_value` int(11) NOT NULL COMMENT '右值',
  `pid` int(11) NOT NULL COMMENT '父编号',
  `activation_num` int(11) NOT NULL DEFAULT '0' COMMENT '激活次数',
  `release_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '释放提取状态 0 未提取 1 已提取',
  `real_name` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `release_assets` decimal(12,4) unsigned DEFAULT '0.0000',
  `bank` varchar(50) DEFAULT NULL COMMENT '开户银行',
  `bank_account` varchar(22) DEFAULT NULL COMMENT '银行账户',
  `bank_address` varchar(150) DEFAULT NULL COMMENT '开户行地址',
  `last_ip` int(11) NOT NULL COMMENT '最后登录IP',
  `last_time` int(11) NOT NULL COMMENT '最后操作时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `money_log` decimal(12,4) unsigned DEFAULT '0.0000',
  `position` int(1) DEFAULT '0' COMMENT '0：左，1：右',
  `money_addr` varchar(43) DEFAULT NULL COMMENT '钱包地址'
) ENGINE=InnoDB AUTO_INCREMENT=1030 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `token`, `mobile`, `nick_name`, `pwd`, `pay_pwd`, `head_image`, `level`, `assets`, `coin`, `money`, `status`, `left_value`, `right_value`, `pid`, `activation_num`, `release_status`, `real_name`, `release_assets`, `bank`, `bank_account`, `bank_address`, `last_ip`, `last_time`, `create_time`, `money_log`, `position`, `money_addr`) VALUES
(1001, 'e758b2b66ad12fb067adde84a2f47d69', '13027199173', '333333', '46f92d17ba', '46f92d17ba', 'cover_img/2018-09-08/a9bf16672611d699d8a726298f16c2ce.png', 0, '0.0000', '0.0000', '0.0000', 2, 9, 24, 0, 0, 0, 'GG', '0.7200', 'GG', 'GG', '球球', 2147483647, 1536391898, 0, '1920.0000', 0, '864d6f17f620fe112e65637308a51c71'),
(1002, '', '13027199174', '逛荡', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '57.0000', 2, 25, 26, 0, 4, 1, NULL, '100.0000', NULL, NULL, NULL, 2147483647, 1536229322, 0, '100.0000', 0, '13027199174'),
(1005, '', '13027199175', '1231', '46f92d17ba', '46f92d17ba', 'cover_img\\10\\01\\1001.png', 0, '0.0000', '0.0000', '0.0000', 2, 10, 21, 1001, 5, 0, NULL, '100.0000', NULL, NULL, NULL, 0, 0, 0, '200000.0000', 0, '13027199175'),
(1006, '', '13027199176', '1231212', '46f92d17ba', '46f92d17ba', 'cover_img\\10\\01\\1001.png', 0, '0.0000', '0.0000', '0.0000', 2, 22, 23, 1001, 0, 0, NULL, '100.0000', NULL, NULL, NULL, 0, 0, 0, '100001.0000', 1, '13027199176'),
(1012, '', '13163319956', '我好啊', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 27, 28, 0, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536368988, 0, '0.0000', 0, '13163319956'),
(1016, '', '13027199171', '13027199171', '46f92d17ba', '', 'cover_img/10/16/1016.png', 1, '124.0001', '2.0000', '123.0000', 2, 29, 30, 0, 3, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536284811, 0, '0.0000', 0, '33ed8275fff9caef54864ffe7d076874'),
(1019, 'c530da0fd43ee6ac406734981f8ac6c4', '18088889999', '一直迷路', '46f92d17ba', '', 'cover_img/2018-09-08/63e294ab90d041e55745f145c0bca679.png', 1, '0.0000', '0.0000', '310.0000', 2, 31, 34, 0, 5, 0, '冲冲', '0.0000', '46464639891148877', '中航', '8名问一下', 2147483647, 1536388925, 0, '20.0000', 0, '4f7edddc8ae27b8892fe8bee9200d2c5'),
(1020, '', '18088889991', '18088889991', '46f92d17ba', '', 'cover_img/head.png', 1, '0.0000', '0.0000', '0.0000', 2, 35, 36, 0, 2, 0, NULL, '0.0000', NULL, NULL, NULL, 2002967115, 1536298879, 0, '0.0000', 0, '3c84b25878654407ee881427ed65b202'),
(1021, '8f6a16ba61d437a22537038856d18316', '18088889992', '18088889992', '46f92d17ba', '', 'cover_img/head.png', 1, '2735.2344', '7.4296', '977.3359', 2, 37, 40, 0, 1, 0, NULL, '8.2304', NULL, NULL, NULL, 2147483647, 1536391585, 0, '540.0000', 0, '34e5130a0fdda167882d22f681f149ee'),
(1023, 'f74f057c72a88178b2de2b29147518bf', '15071156941', '123456', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 11, 18, 1005, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536392107, 0, '1000.0000', 0, '3daf924ed8fff4806403e81708329fdb'),
(1024, '', '15342256121', '545878', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 19, 20, 1005, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 0, 1536316836, 0, '0.0000', 0, 'dd9b12e93686e1c864880d19aa8ac357'),
(1025, '22950aa80c9672b5fb852610ba765b07', '13476193089', '147258', 'a9f437846e', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 12, 13, 1023, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 1971868120, 1536391477, 0, '0.0000', 0, 'd0493ed10a8ee244bdcfcb73f2f9afcb'),
(1026, '', '18971614676', '2222', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 14, 17, 1023, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536373834, 0, '0.0000', 0, '7ff0d97ca0637e2e624f1f9bceadff2a'),
(1027, '', '18064101319', '3333', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 0, '0.0000', '0.0000', '0.0000', 2, 15, 16, 1026, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536374804, 0, '0.0000', 0, 'e2519bc9371bdc39a005d94894bee110'),
(1029, '5a40940fdd14f6de2c2dbfaa03087ee0', '15071966369', '6666', '46f92d17ba', '46f92d17ba', 'cover_img/head.png', 1, '3130.0000', '0.0000', '100.0000', 2, 38, 39, 1021, 0, 0, NULL, '0.0000', NULL, NULL, NULL, 2147483647, 1536391913, 0, '520.0000', 0, '727a85994808564962be48631fa8de7f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cates`
--
ALTER TABLE `admin_cates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_cate_has_roles`
--
ALTER TABLE `admin_cate_has_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_cate_has_users`
--
ALTER TABLE `admin_cate_has_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_has_roles`
--
ALTER TABLE `admin_user_has_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_flags`
--
ALTER TABLE `message_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `nick_name` (`nick_name`),
  ADD KEY `mobile_2` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cates`
--
ALTER TABLE `admin_cates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `admin_cate_has_roles`
--
ALTER TABLE `admin_cate_has_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键编号';
--
-- AUTO_INCREMENT for table `admin_cate_has_users`
--
ALTER TABLE `admin_cate_has_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键编号';
--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_user_has_roles`
--
ALTER TABLE `admin_user_has_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键编号';
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message_flags`
--
ALTER TABLE `message_flags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',AUTO_INCREMENT=1030;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
