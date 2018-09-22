-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-06-29 15:34:20
-- 服务器版本： 5.6.36-log
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fk`
--

-- --------------------------------------------------------

--
-- 表的结构 `fk_banner`
--

CREATE TABLE `fk_banner` (
  `id` int(11) NOT NULL,
  `img` text COMMENT '轮播图',
  `url` text COMMENT '轮播图链接',
  `type` int(11) NOT NULL COMMENT '0:第一张1:第二张2:第三章'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `fk_banner`
--

INSERT INTO `fk_banner` (`id`, `img`, `url`, `type`) VALUES
(18, '/uploads/20180606/f016b4280a78cba50efbcbbb8781f611.jpg', '', 0),
(19, '/uploads/20180606/6569ad45f9f7a40c6d9193b68e727638.jpg', '', 1),
(20, '/uploads/20180606/b0930bf84294b0d1dd880a5ffa23429a.jpg', '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `fk_ecosphere`
--

CREATE TABLE `fk_ecosphere` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL COMMENT '生态产品圈图片',
  `url` text NOT NULL COMMENT '链接',
  `describe` varchar(255) NOT NULL COMMENT '文字描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `fk_ecosphere`
--

INSERT INTO `fk_ecosphere` (`id`, `img`, `url`, `describe`) VALUES
(3, '/uploads/20180524/5c93500f326971aa0112d83fbf853a32.png', 'http://fanyi.youdao.com/', '就是这么狂'),
(4, '/uploads/20180524/72a97c5a3071f7d87eea54ee67f6c255.png', 'http://fanyi.youdao.com/', '生无可恋装'),
(6, '/uploads/20180524/72a97c5a3071f7d87eea54ee67f6c255.png', 'http://fanyi.youdao.com/', '生无可恋装'),
(7, '/uploads/20180524/5c93500f326971aa0112d83fbf853a32.png', 'http://fanyi.youdao.com/', '就是这么狂'),
(8, '/uploads/20180524/72a97c5a3071f7d87eea54ee67f6c255.png', 'http://fanyi.youdao.com/', '生无可恋装'),
(9, '/uploads/20180524/5c93500f326971aa0112d83fbf853a32.png', 'http://fanyi.youdao.com/', '就是这么狂'),
(10, '/uploads/20180606/108b0577c20d80707f5407ba9e61dd66.jpg', '', ''),
(11, '/uploads/20180608/49420a4986881b3e8fb07218fbb1212e.JPG', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `fk_equipment`
--

CREATE TABLE `fk_equipment` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL COMMENT '设备序列号',
  `liveAddress` varchar(255) NOT NULL COMMENT 'hls标清地址',
  `hdAddress` varchar(255) NOT NULL COMMENT 'hls高清地址',
  `rtmp` varchar(255) NOT NULL COMMENT 'rtmp标清地址',
  `rtmpHd` varchar(255) NOT NULL COMMENT 'rtmp高清地址',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_equipment`
--

INSERT INTO `fk_equipment` (`id`, `serial_number`, `liveAddress`, `hdAddress`, `rtmp`, `rtmpHd`, `create_time`, `update_time`) VALUES
(1, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-04-27 09:21:13', '2018-04-27 09:21:13'),
(2, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-04-27 09:23:44', '2018-04-27 09:23:44'),
(3, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-04-27 09:24:25', '2018-04-27 09:24:25'),
(4, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-04-27 09:26:41', '2018-04-27 09:26:41'),
(5, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-05-17 06:53:28', '2018-05-17 06:53:28'),
(6, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-05-17 12:16:09', '2018-05-17 12:16:09'),
(7, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-05-17 12:16:15', '2018-05-17 12:16:15'),
(8, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-05-20 06:57:31', '2018-05-20 06:57:31'),
(9, '824873787', 'http://hls.open.ys7.com/openlive/e91e43ec6d724f30a115796ee8eee312.m3u8', 'http://hls.open.ys7.com/openlive/e91e43ec6d724f30a115796ee8eee312.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/e91e43ec6d724f30a115796ee8eee312', 'rtmp://rtmp.open.ys7.com/openlive/e91e43ec6d724f30a115796ee8eee312.hd', '2018-05-22 03:10:36', '2018-05-22 03:10:36'),
(10, '130393594', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.m3u8', 'http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd', '2018-06-02 05:15:25', '2018-06-02 05:15:25'),
(11, '166798102', 'http://hls.open.ys7.com/openlive/f93f02d8ecb04b71a919b9492c785bd7.m3u8', 'http://hls.open.ys7.com/openlive/f93f02d8ecb04b71a919b9492c785bd7.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7rtmp://rtmp.open.ys7.com/openlive/f93f02d8ecb04b71a919b9492c785bd7', 'rtmp://rtmp.open.ys7.com/openlive/f93f02d8ecb04b71a919b9492c785bd7.hd', '2018-06-03 07:49:27', '2018-06-02 05:15:25'),
(12, '154070292', 'http://hls.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.m3u8', 'http://hls.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec', 'rtmp://rtmp.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.hd', '2018-06-05 15:14:09', '2018-06-05 15:14:09'),
(13, '154070292', 'http://hls.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.m3u8', 'http://hls.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.hd.m3u8', 'rtmp://rtmp.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec', 'rtmp://rtmp.open.ys7.com/openlive/006783ddb8a34985b397e96a8761baec.hd', '2018-06-05 15:14:12', '2018-06-05 15:14:12');

-- --------------------------------------------------------

--
-- 表的结构 `fk_farm`
--

CREATE TABLE `fk_farm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(255) NOT NULL COMMENT '农场名称',
  `img` varchar(255) NOT NULL COMMENT '农场图片',
  `province` varchar(25) NOT NULL COMMENT '省份',
  `city` varchar(25) NOT NULL COMMENT '市',
  `area` varchar(25) NOT NULL COMMENT '区',
  `address` varchar(255) NOT NULL COMMENT '详细地址',
  `phone` varchar(25) NOT NULL COMMENT '联系电话',
  `equipment_number` varchar(25) NOT NULL COMMENT '设备编号',
  `acreage` int(11) NOT NULL COMMENT '面积',
  `price` int(11) NOT NULL COMMENT '价格',
  `lease_type` int(11) NOT NULL COMMENT '租赁时间(1为年,2为半年,3为一季,4为月)',
  `service` varchar(25) DEFAULT NULL COMMENT '提供服务(多种服务)',
  `describe` text COMMENT '描述',
  `type` int(11) DEFAULT '0' COMMENT '0代表已上线,1代表已租出,2代表租赁到期下线,3代表用户手动下线',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `downline_time` datetime DEFAULT NULL COMMENT '下线时间',
  `del_time` timestamp NULL DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_farm`
--

INSERT INTO `fk_farm` (`id`, `user_id`, `name`, `img`, `province`, `city`, `area`, `address`, `phone`, `equipment_number`, `acreage`, `price`, `lease_type`, `service`, `describe`, `type`, `create_time`, `update_time`, `downline_time`, `del_time`) VALUES
(45, 3, '测试12', '/uploads/20180522/e9db87124449038f534313e174fcc477.png', '北京市', '北京市', '西城区', '洪山区', '13016448730', '123456', 1000, 1000, 1, '1,2', '文字描述', 0, '2018-05-24 09:26:04', '2018-05-24 09:26:04', NULL, '2018-05-24 09:26:04'),
(47, 4, '小泽', '/uploads/20180523/892dd7ce924c1fc5cec8a5d2db152ba1.png', '湖北省', '武汉市', '江岸区', '岱家山科技创业园', '13016448730', '123456789', 1000, 1000, 1, '1', '<p>sdadasdasdasdas</p>', 0, '2018-05-24 07:47:27', '2018-05-23 02:25:56', NULL, NULL),
(48, 4, 'hah ', '/uploads/20180523/594d736743d76b85827ec060ea4b0c5e.png', '北京市', '北京市', '西城区', 'dsdad ', '31312131', '1313123131', 231, 123, 3, '1,2', '<p>313123</p>', 0, '2018-05-24 07:47:29', '2018-05-23 02:24:31', NULL, NULL),
(46, 4, '只能五个个', '/uploads/20180523/892dd7ce924c1fc5cec8a5d2db152ba1.png', '湖北省', '武汉市', '江岸区', '岱家山科技创业园', '13016448730', '123456789', 1000, 1000, 1, '1,2', '<p>sdadasdasdasdas</p>', 1, '2018-06-02 02:22:46', '2018-05-23 02:21:43', NULL, NULL),
(49, 6, '12345678990', '/uploads/20180601/8a4989f5b4217894c0968b608e886f8a.jpg', '湖北省', '武汉市', '武昌区', '晒湖路,25号', '13247115682', '12121212121', 12, 500, 3, '1,2,3', '<p><img src=\"/upload/image/20180601/1527854191122399.jpg\" title=\"1527854191122399.jpg\" width=\"325\" height=\"308\"/></p><p><img src=\"/upload/image/20180601/1527854191488672.jpg\" title=\"1527854191488672.jpg\" width=\"449\" height=\"477\"/></p><p><br/></p>', 0, '2018-06-02 05:07:06', '2018-06-02 05:07:06', NULL, '2018-06-02 05:07:06'),
(50, 3, '大叔大婶大所多是的撒多撒大所啊', '/uploads/20180602/21f0a51c8f390b39d114f2b872aec426.jpg', '湖北省', '武汉市', '硚口区', '江岸区,,', '撒大声地', '奥术大师多', 1000, 1000, 1, '2', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)</p>', 3, '2018-06-14 08:48:56', '2018-06-05 02:52:49', '2018-06-14 16:48:56', NULL),
(51, 6, '易钧的超级农场1号', '/uploads/20180602/4d10020b529cfa40c292e48cb1659d89.jpg', '湖北省', '武汉市', '武昌区', '雄楚大道44号', '13247115682', '154070292', 20, 4000, 1, '1,2,3', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)</p><p>农场位于武汉市武昌区雄楚大道44号，毗邻武昌火车站，交通便利，适合种植生菜，莴苣等南方适合的一切蔬菜。周围商店密集，拥有武汉热干面等特产。<img src=\"/upload/image/20180602/1527915874947438.jpg\" title=\"1527915874947438.jpg\" alt=\"地图.JPG\"/></p><p><img src=\"/upload/image/20180602/1527915889836749.jpg\" title=\"1527915889836749.jpg\" alt=\"摄像头.jpg\"/></p>', 0, '2018-06-02 05:07:12', '2018-06-02 05:07:12', NULL, '2018-06-02 05:07:12'),
(52, 6, '11111', '/uploads/20180602/33f2d9bebcae4122652394559c03007b.jpg', '湖北省', '武汉市', '武昌区', '雄楚大道42号', '13247115682', '166798102', 20, 15, 4, '2', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)</p><p><img src=\"/upload/image/20180602/1527916104252336.jpg\" title=\"1527916104252336.jpg\" alt=\"耕地面积变化趋势.jpg\"/><img src=\"/upload/image/20180602/1527916107310059.jpg\" title=\"1527916107310059.jpg\" alt=\"非最大化.JPG\" width=\"450\" height=\"382\"/></p>', 0, '2018-06-11 03:15:32', '2018-06-11 03:15:32', NULL, NULL),
(53, 6, '22222222222222', '/uploads/20180602/085abf30f9a60c6bd159fb264c3f27a2.JPG', '北京市', '北京市', '不限', '清华大学', '13247115682', '130393594', 40, 1000, 1, '1,2,3', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)<img src=\"/upload/image/20180602/1527916502652381.jpg\" title=\"1527916502652381.jpg\" alt=\"耕地面积变化趋势.jpg\"/><img src=\"/upload/image/20180602/1527916514955927.jpg\" title=\"1527916514955927.jpg\" alt=\"方块智慧农业.jpg\"/></p>', 3, '2018-06-03 07:46:06', '2018-06-02 05:15:25', '2018-06-03 15:46:06', NULL),
(54, 6, '小易的农场1号', '/uploads/20180611/0480acb8f06f5029ca495da2ddd86989.jpg', '湖北省', '武汉市', '江夏区', '江夏区,,', '13247115682', '166798102', 60, 20, 4, '1,2', '<p><br/></p><p>您即将租赁的场地位于江夏区蓝波湾水文化度假村，环境优美，可以随时来此地进行轰趴等活动。也可住宿，享受自然美景。</p><p>场地位于别墅周围，周围也有其他农场，可根据您的需求种植属于自己的时令蔬菜。武汉市适合种植的蔬菜这里均可种植 。您在这里种植后可委托我来管理，并且可远程查看种植情况，实时过来采摘，支持将新鲜的蔬菜快递到家。包年（5900元）。</p><p style=\"text-align:center\"><img src=\"/upload/image/20180611/1528686320664494.jpg\" title=\"1528686320664494.jpg\" alt=\"蓝波湾1.jpg\" width=\"478\" height=\"354\"/></p><p style=\"text-align:center\"><img src=\"/upload/image/20180611/1528686373241982.jpg\" title=\"1528686373241982.jpg\" alt=\"蓝波湾2.jpg\" width=\"484\" height=\"310\"/></p><p style=\"text-align:center\"><img src=\"/upload/image/20180611/1528686432464162.jpg\" title=\"1528686432464162.jpg\" alt=\"蓝波湾3.jpg\" width=\"480\" height=\"323\"/></p><p style=\"text-align:center\"><img src=\"/upload/image/20180611/1528686490713149.jpg\" title=\"1528686490713149.jpg\" alt=\"蓝波湾4.jpg\" width=\"477\" height=\"380\"/></p><p style=\"text-align:center\"><img src=\"/upload/image/20180611/1528686512964698.jpg\" title=\"1528686512964698.jpg\" alt=\"蓝波湾5.jpg\" width=\"483\" height=\"263\"/></p><p><img src=\"/upload/image/20180611/1528686265333710.jpg\" title=\"1528686265333710.jpg\" alt=\"蓝波湾1.jpg\" width=\"1\" height=\"1\"/><br/></p>', 0, '2018-06-19 02:58:16', '2018-06-19 02:58:16', NULL, NULL),
(55, 6, '易钧的农场222', '/uploads/20180605/79a74ac3618bb976387edefdd3c0d1d9.jpg', '湖北省', '武汉市', '武昌区', '武珞路222号', '13247115682', '154070292', 20, 1300, 1, '1,2,3', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)</p><p><img src=\"/upload/image/20180605/1528211631818975.jpg\" title=\"1528211631818975.jpg\" alt=\"农药残留.jpg\"/></p>', 0, '2018-06-05 15:14:03', '2018-06-05 15:14:03', NULL, NULL),
(56, 6, '易钧的农场222', '/uploads/20180605/26cd6b0ac5b3884180f52da582de7133.jpg', '湖北省', '武汉市', '武昌区', '武珞路222号', '13247115682', '154070292', 20, 1300, 1, '1,2,3', '<p>(请对农场所在的地理位置、适合种植的作物、附近风土人情、游玩项目等进行描述，并赋予不少于两张图片)</p><p><img src=\"/upload/image/20180605/1528211631818975.jpg\" title=\"1528211631818975.jpg\" alt=\"农药残留.jpg\"/></p>', 0, '2018-06-05 15:14:12', '2018-06-05 15:14:12', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `fk_feedback`
--

CREATE TABLE `fk_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `phone` varchar(25) NOT NULL COMMENT '手机号',
  `content` varchar(255) NOT NULL COMMENT '反馈内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_feedback`
--

INSERT INTO `fk_feedback` (`id`, `user_id`, `phone`, `content`, `create_time`, `update_time`) VALUES
(1, 6, '13247115682', '好好的运营。', '2018-05-20 07:08:56', '2018-05-20 07:08:56');

-- --------------------------------------------------------

--
-- 表的结构 `fk_login`
--

CREATE TABLE `fk_login` (
  `id` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL COMMENT '用户',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `type` int(11) DEFAULT NULL COMMENT '0:超管,1:其他'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_login`
--

INSERT INTO `fk_login` (`id`, `user`, `password`, `type`) VALUES
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `fk_order`
--

CREATE TABLE `fk_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `order_number` varchar(255) NOT NULL COMMENT '订单号',
  `type` int(11) NOT NULL COMMENT '0为未支付,1为租赁,2为租出,3为已过期',
  `order_type` int(11) DEFAULT '0' COMMENT '0:未收款1:已收款',
  `farm_id` int(11) NOT NULL COMMENT '农场id',
  `price` varchar(100) NOT NULL COMMENT '价格',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间(交易时间)',
  `update_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL COMMENT '租赁到期时间',
  `del_time` timestamp NULL DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_order`
--

INSERT INTO `fk_order` (`id`, `user_id`, `order_number`, `type`, `order_type`, `farm_id`, `price`, `create_time`, `update_time`, `end_time`, `del_time`) VALUES
(138, 3, '201805243489', 0, 0, 47, '1000', '2018-05-24 09:55:55', '2018-05-24 09:55:55', NULL, NULL),
(137, 3, '201805241573', 0, 0, 47, '1000', '2018-05-24 09:54:45', '2018-05-24 09:54:45', NULL, NULL),
(135, 3, '20180524993', 0, 0, 47, '1000', '2018-05-24 09:54:17', '2018-05-24 09:54:17', NULL, NULL),
(136, 3, '201805249424', 0, 0, 47, '1000', '2018-05-24 09:54:44', '2018-05-24 09:54:44', NULL, NULL),
(134, 3, '201805249091', 0, 0, 47, '1000', '2018-05-24 09:53:14', '2018-05-24 09:53:14', NULL, NULL),
(133, 4, '201805241820', 2, 1, 46, '1000', '2018-05-28 12:09:01', '2018-05-24 09:41:19', '2019-05-24 09:41:05', NULL),
(132, 3, '201805241820', 1, 1, 46, '1000', '2018-06-05 03:14:49', '2018-05-24 09:41:05', '2019-05-24 09:41:05', NULL),
(139, 6, '201805289290', 0, 0, 47, '1000', '2018-05-28 11:01:52', '2018-05-28 11:01:52', NULL, NULL),
(140, 6, '201805284691', 0, 0, 47, '1000', '2018-05-28 11:02:00', '2018-05-28 11:02:00', NULL, NULL),
(141, 6, '201805287219', 0, 0, 47, '1000', '2018-05-28 11:02:43', '2018-05-28 11:02:43', NULL, NULL),
(142, 7, '201806019981', 0, 0, 47, '1000', '2018-06-01 12:56:19', '2018-06-01 12:56:19', NULL, NULL),
(143, 7, '201806037098', 0, 0, 47, '1000', '2018-06-03 06:20:20', '2018-06-03 06:20:20', NULL, NULL),
(144, 6, '201806038006', 0, 0, 50, '1000', '2018-06-03 06:24:12', '2018-06-03 06:24:12', NULL, NULL),
(145, 3, '201805241821', 1, 1, 46, '1000', '2018-06-13 03:14:47', '2018-05-24 09:41:05', '2019-05-24 09:41:05', NULL),
(146, 9, '201806119915', 0, 0, 54, '20', '2018-06-11 03:27:26', '2018-06-11 03:27:26', NULL, NULL),
(147, 9, '201806119467', 0, 0, 54, '20', '2018-06-11 03:27:57', '2018-06-11 03:27:57', NULL, NULL),
(148, 9, '201806112781', 0, 0, 54, '20', '2018-06-11 03:28:28', '2018-06-11 03:28:28', NULL, NULL),
(149, 3, '201806119136', 0, 0, 48, '123', '2018-06-11 03:44:35', '2018-06-11 03:44:35', NULL, NULL),
(150, 3, '201806117232', 0, 0, 54, '20', '2018-06-11 03:46:32', '2018-06-11 03:46:32', NULL, NULL),
(151, 3, '201806114289', 0, 0, 54, '20', '2018-06-11 03:46:43', '2018-06-11 03:46:43', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `fk_send_sms`
--

CREATE TABLE `fk_send_sms` (
  `id` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `code` int(5) NOT NULL COMMENT '验证码',
  `code_out_time` datetime NOT NULL COMMENT '验证码过期时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信表';

--
-- 转存表中的数据 `fk_send_sms`
--

INSERT INTO `fk_send_sms` (`id`, `phone`, `code`, `code_out_time`, `create_time`, `update_time`) VALUES
(1, '18064109218', 6919, '2018-05-31 16:26:50', '2018-05-16 08:25:50', '2018-05-16 08:25:50'),
(2, '13016448730', 1430, '2018-05-16 20:14:17', '2018-05-16 12:13:17', '2018-05-16 12:13:17'),
(3, '13971976817', 9030, '2018-05-17 14:49:54', '2018-05-17 06:48:54', '2018-05-17 06:48:54'),
(4, '15623568979', 8983, '2018-05-18 12:04:15', '2018-05-18 04:03:15', '2018-05-18 04:03:15'),
(5, '13016448730', 1041, '2018-05-18 12:06:49', '2018-05-18 04:05:49', '2018-05-18 04:05:49'),
(6, '13016448730', 2409, '2018-05-18 12:07:59', '2018-05-18 04:06:59', '2018-05-18 04:06:59'),
(7, '13247115682', 1892, '2018-05-19 08:26:21', '2018-05-19 00:25:21', '2018-05-19 00:25:21'),
(8, '13016448730', 1951, '2018-05-20 12:54:25', '2018-05-20 04:53:25', '2018-05-20 04:53:25'),
(9, '13016448730', 6319, '2018-05-20 12:57:01', '2018-05-20 04:56:01', '2018-05-20 04:56:01'),
(10, '13016448730', 2532, '2018-05-20 12:58:33', '2018-05-20 04:57:33', '2018-05-20 04:57:33'),
(11, '13016448730', 8501, '2018-05-20 12:59:54', '2018-05-20 04:58:54', '2018-05-20 04:58:54'),
(12, '13016448730', 3996, '2018-05-20 13:02:15', '2018-05-20 05:01:15', '2018-05-20 05:01:15'),
(13, '13016448730', 7211, '2018-05-20 13:03:26', '2018-05-20 05:02:26', '2018-05-20 05:02:26'),
(14, '13016448730', 9793, '2018-05-20 13:05:00', '2018-05-20 05:04:00', '2018-05-20 05:04:00'),
(15, '13016448730', 8717, '2018-05-20 13:06:10', '2018-05-20 05:05:10', '2018-05-20 05:05:10'),
(16, '13016448730', 5385, '2018-05-20 13:08:17', '2018-05-20 05:07:17', '2018-05-20 05:07:17'),
(17, '13016448730', 5670, '2018-05-20 13:11:53', '2018-05-20 05:10:53', '2018-05-20 05:10:53'),
(18, '13016448730', 7359, '2018-05-20 13:14:40', '2018-05-20 05:13:40', '2018-05-20 05:13:40'),
(19, '15071281528', 4123, '2018-06-01 20:55:56', '2018-06-01 12:54:56', '2018-06-01 12:54:56'),
(20, '15107102269', 4858, '2018-06-04 12:25:28', '2018-06-04 04:24:28', '2018-06-04 04:24:28'),
(21, '13545878747', 9785, '2018-06-11 11:27:45', '2018-06-11 03:26:45', '2018-06-11 03:26:45'),
(22, '18182990296', 2396, '2018-06-28 16:07:26', '2018-06-28 08:06:26', '2018-06-28 08:06:26');

-- --------------------------------------------------------

--
-- 表的结构 `fk_service`
--

CREATE TABLE `fk_service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '服务名称',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_service`
--

INSERT INTO `fk_service` (`id`, `name`, `create_time`, `update_time`) VALUES
(1, '按需种植', '2018-04-20 08:28:31', NULL),
(2, '随时来访', '2018-04-20 08:28:48', NULL),
(3, '送货上门', '2018-04-20 08:29:02', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `fk_teach`
--

CREATE TABLE `fk_teach` (
  `id` int(11) NOT NULL,
  `url` text COMMENT '视频链接',
  `type` int(11) DEFAULT '0',
  `name` text COMMENT '视频名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `fk_teach`
--

INSERT INTO `fk_teach` (`id`, `url`, `type`, `name`) VALUES
(18, '\'http://player.youku.com/embed/XMzY1MDMzNzU4OA==\'', 0, '111'),
(20, '\'http://player.youku.com/embed/XMzY0NDcxODg4OA==\'', 0, '开车'),
(21, '\'http://player.youku.com/embed/XMzY1NjE3MjM3Ng==\'', 0, '方块智慧农业操作指导'),
(22, '\'http://player.youku.com/embed/XMzY3MzQ0MTA2MA==\'', 0, '方块智慧农业网上操作指导');

-- --------------------------------------------------------

--
-- 表的结构 `fk_user`
--

CREATE TABLE `fk_user` (
  `id` int(11) NOT NULL COMMENT '用户注册手机号',
  `name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `img` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `phone` varchar(25) NOT NULL,
  `alipay` varchar(255) DEFAULT NULL COMMENT '支付宝',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fk_user`
--

INSERT INTO `fk_user` (`id`, `name`, `img`, `phone`, `alipay`, `password`, `create_time`, `update_time`) VALUES
(2, '还不是因为你长的不好看', '/uploads/20180518/15266134619971.png', '18064109218', '18064109218@163.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-16 08:31:03', '2018-05-16 08:31:03'),
(3, '超群', '/uploads/20180520/15268047613705.png', '13016448730', NULL, 'e10adc3949ba59abbe56e057f20f883e', '2018-05-16 12:13:42', '2018-05-16 12:13:42'),
(4, '泽强', '/uploads/20180517/15265657251238.png', '13971976817', NULL, '202cb962ac59075b964b07152d234b70', '2018-05-17 06:49:12', '2018-05-17 06:49:12'),
(5, NULL, NULL, '15623568979', NULL, 'e10adc3949ba59abbe56e057f20f883e', '2018-05-18 04:03:39', '2018-05-18 04:03:39'),
(6, '易钧', '/uploads/20180520/15268259751241.png', '13247115682', '13247115682', '25d55ad283aa400af464c76d713c07ad', '2018-05-19 00:26:14', '2018-05-19 00:26:14'),
(7, NULL, NULL, '15071281528', NULL, '24ac8a071daf5d6bc2d6fc41359c1eb0', '2018-06-01 12:55:13', '2018-06-01 12:55:13'),
(8, NULL, NULL, '15107102269', NULL, 'd2e44da94df56dcd3591ec8fe89f78fd', '2018-06-04 04:24:43', '2018-06-04 04:24:43'),
(9, NULL, NULL, '13545878747', NULL, 'd13f3d24395510dcdb77697882f94f57', '2018-06-11 03:27:03', '2018-06-11 03:27:03'),
(10, '18182990296', NULL, '18182990296', NULL, '28240bc954ef362399250b1c1838ec89', '2018-06-28 08:06:45', '2018-06-28 08:06:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fk_banner`
--
ALTER TABLE `fk_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_ecosphere`
--
ALTER TABLE `fk_ecosphere`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_equipment`
--
ALTER TABLE `fk_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_farm`
--
ALTER TABLE `fk_farm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_feedback`
--
ALTER TABLE `fk_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_login`
--
ALTER TABLE `fk_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_order`
--
ALTER TABLE `fk_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_send_sms`
--
ALTER TABLE `fk_send_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_service`
--
ALTER TABLE `fk_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_teach`
--
ALTER TABLE `fk_teach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fk_user`
--
ALTER TABLE `fk_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `fk_banner`
--
ALTER TABLE `fk_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `fk_ecosphere`
--
ALTER TABLE `fk_ecosphere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `fk_equipment`
--
ALTER TABLE `fk_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `fk_farm`
--
ALTER TABLE `fk_farm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- 使用表AUTO_INCREMENT `fk_feedback`
--
ALTER TABLE `fk_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `fk_login`
--
ALTER TABLE `fk_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `fk_order`
--
ALTER TABLE `fk_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
--
-- 使用表AUTO_INCREMENT `fk_send_sms`
--
ALTER TABLE `fk_send_sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- 使用表AUTO_INCREMENT `fk_service`
--
ALTER TABLE `fk_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `fk_teach`
--
ALTER TABLE `fk_teach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- 使用表AUTO_INCREMENT `fk_user`
--
ALTER TABLE `fk_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户注册手机号', AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
