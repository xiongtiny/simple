<?php /*a:3:{s:72:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\farm\farm_detail.html";i:1526437600;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526437494;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526435605;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>农场详情</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/css/style_1.css">
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=	d1rjXUM25YuupoH4ukBYrLzVkvY9bWmF"></script>
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
			<?php if((empty(app('request')->session('user'))&&empty(app('request')->session('phone')))): ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/index/login1" id="top_login">登录</a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/register1" id="top_logon">注册</a>
			<?php elseif((empty(app('request')->session('user')))): ?>
            <a style="..." href="#" id="top_login">欢迎您，<?php echo htmlentities(app('request')->session('phone')); ?></a>&nbsp;|&nbsp;<a style="..." href="/index.php/api/v1/index/exit_login" id="top_logon">退出</a> &nbsp;<a  href="/index.php/api/v1/user/user_edit" id="top_login">个人中心</a>
			<?php else: ?>
			<a style="text-decoration: none;" href="#" id="top_login">欢迎您，<?php echo htmlentities(app('request')->session('user')); ?></a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/exit_login" id="top_logon">退出</a>  &nbsp;<a  href="/index.php/api/v1/user/user_edit" id="top_login">个人中心</a>
			<?php endif; ?>
			</span>
    </div>
</div>


	<div id="navigation_1"><!-- 导航 -->
		<div class="container">
			<div id="navigation_left">
				<a style="text-decoration: none;" href="/index.php/api/v1/index/index"><img src="/static/image/logo.png" alt=""></a>
			</div>
			<div id="navigation_right">
				<div class="navigation_1 bottom_6_1">
					<a style="text-decoration: none;"  class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
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
				<div class="form-group"><h3><?php echo htmlentities($data['name']); ?></h3></div>
				<div class="form-group" style="width: 280px;">
				<?php foreach($data['service'] as $z): ?>				
			   		<button class="show_farm_button"><?php echo htmlentities($z); ?></button>
			   	<?php endforeach; ?>
				</div>
				<div class="form-group"><p class="bottom_7_4">面积&nbsp;:&nbsp;<?php echo htmlentities($data['acreage']); ?>m²</p></div>
				<div class="form-group bottom_6_1" style="width: 300px;"><p class="bottom_7_4">农场主联系方式&nbsp;:&nbsp; <div><?php echo htmlentities($data['phone']); ?> <br><!-- （付款后可查看） --></div> </p></div>
				<div class="form-group"><p class="bottom_7_4"></p></div>

				
				<div><span class="bottom_7_6"><?php echo htmlentities($data['price']); ?></span><span>元/											<?php switch($data['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?></span></div><br><br>
				<div><button class="bottom_7_5" onclick="window.open('/index.php/api/v1/lease/lease_farm')">立即租赁</button></div>
				
			</div>
		</div>
	</div>
	<div class="container farm_map"><!-- 农场地址 -->
		<h3>农场详细地址</h3>
		<p><?php echo htmlentities($data['province']); ?><?php echo htmlentities($data['city']); ?><?php echo htmlentities($data['address']); ?></p>
		<div id="allmap" style="width: 100%;height: 400px;">
	

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
    var player = new EZUIPlayer('myPlayer');
//    player.on('error', function(){
//        console.log('error');
//    });
//    player.on('play', function(){
//        console.log('play');
//    });
//    player.on('pause', function(){
//        console.log('pause');
//    });
//    player.on('waiting', function(){
//        console.log('waiting');
//    });


   // 日志
   player.on('log', log);
   //
   function log(str){
       var div = document.createElement('DIV');
       div.innerHTML = (new Date()).Format('yyyy-MM-dd hh:mm:ss.S') + JSON.stringify(str);
       document.body.appendChild(div);
   }


</script>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(116.331398,39.897445);
	  map.enableScrollWheelZoom(true);
	map.centerAndZoom(point,12);
	// 创建地址解析器实例
	var myGeo = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	myGeo.getPoint("<?php echo htmlentities($data['province']); ?><?php echo htmlentities($data['city']); ?><?php echo htmlentities($data['address']); ?>", function(point){
		if (point) {
			map.centerAndZoom(point, 16);
			map.addOverlay(new BMap.Marker(point));
		}else{
			alert("您选择地址没有解析到结果!");
		}
	}, "北京市");
</script>
</body>
</html>