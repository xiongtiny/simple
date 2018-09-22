<?php /*a:1:{s:73:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\farm\farm_detail1.html";i:1525860290;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>农场详情</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/css/style.css">
				<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.4.6&key=2b1fab4dad7e85c44f1c72aac9e10ffd"></script>
				<script src="/static/ys/yshi/ezuikit.js"></script>
</head>
<body>
<body>
	<div id="top"><!-- 头部 -->
		<div class="container" id="top_main">
			<span id="top_left">
				联系我们: <a href="#" id="top_phone">400-1895555</a>
			</span>
			<span id="top_right">
				<a href="/index.php/api/v1/index/login1" id="top_login">登录</a>&nbsp;|&nbsp;<a href="/index.php/api/v1/index/register1" id="top_logon">注册</a>
			</span>
		</div>

	</div>

	<div id="navigation_1"><!-- 导航 -->
		<div class="container">
			<div id="navigation_left">
				<a href="/index.php/api/v1/index/index"><img src="/static/image/logo.png" alt=""></a>
			</div>
			<div id="navigation_right">
				<div class="navigation_1 bottom_6_1">
					<a  class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2">智慧农业</div></a>
					<a class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom_6 bottom_7_2">
		<div class="container bottom_7_1">
			<div class="detail_video_left">
				<video id="myPlayer" poster="http://open.ys7.com/asdf.jpg" width="600px" height="330px" controls="controls" style="background-color: #000000;" controls playsInline webkit-playsinline autoplay>
				    <source src="<?php echo htmlentities($data1['hdAddress']); ?>" type="application/x-mpegURL" />

				</video>
				
			</div>
			<div class="video_explain detail_video_right">
				<div class="form-group"><h3>武汉汉南农场一区</h3></div>
				<div class="form-group" style="width: 280px;">
				<button class="bottom_7_3">按需种植</button>&nbsp;&nbsp;
				<button class="bottom_7_3">随时来访</button>&nbsp;&nbsp;
				<button class="bottom_7_3">送货到家</button></div>
				<div class="form-group"><p class="bottom_7_4">面积&nbsp;:&nbsp;1000m²</p></div>
				<div class="form-group bottom_6_1" style="width: 300px;"><p class="bottom_7_4">农场主联系方式&nbsp;:&nbsp; <div>138********8989 <br>（付款后可查看）</div> </p></div>
				<div class="form-group"><p class="bottom_7_4"></p></div>

				
				<div><span class="bottom_7_6">6200</span><span>元/年</span></div><br><br>
				<div><button class="bottom_7_5" onclick="window.open('person_6.html')">立即租赁</button></div>
				
			</div>
		</div>
	</div>
	<div class="container farm_map"><!-- 农场地址 -->
		<h3>农场详细地址</h3>
		<p>湖北省武汉市汉南区物华路564号</p>
		<div id="map_1" style="width: 100%;height: 400px;">
	

		</div>
	</div>

	<div class="bottom_6  ">
		<div class="bottom_7 container ">
		<h3>其他描述</h3>
		<p style="color: #4e4f52;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸场地长宽尺寸，周围气候风貌、人情习俗、适合的作物种类场地长宽尺寸</p>
		</div>
	</div>

		<div id="base"><!-- 底部 -->
		<div class="container">
			<div id="base_up">
				<div id="base_left">
					<p>	
					<div class="bottom_6_1">
						<div style="margin-left: -3px;"><span class="icon-phone" style="font-size: 25px;"></span></div>
						<div><span>&nbsp;&nbsp;&nbsp;132-4711-5682</span><br></div>
					</div>
					</p>
					<p>
					<div class="bottom_6_1">
						<div><span class="icon-phone_1" style="font-size: 20px;"></span></div>
						<div><span style="font-size: 15px;">&nbsp;&nbsp;&nbsp;400-1895555</span><br></div>
					</div>
					</p>
					<p>
					<div class="bottom_6_1">
						<div><span class="icon-map" style="font-size: 20px;"></span></div>
						<div><span style="">&nbsp;&nbsp;&nbsp;湖北省武汉市江岸区汉黄路888号岱家山<br>&nbsp;&nbsp;&nbsp;科技创业城10栋1楼</span></div>
					</div>
					</p>
				</div>
				<div id="base_right">
				<img src="/static/image/code.png" alt="">
				</div>
			</div>
			<div id="base_down">
				<span>版权归00所有</span>
				<p>ICC01225252号ICC01225252号</p>
			</div>
		</div>
	</div>
	<script>
		var map = new AMap.Map('map_1', {
		    resizeEnable: true,
		    zoom:11,
		    center: [116.397428, 39.90923]        
		});
	</script>

</body>
</html>