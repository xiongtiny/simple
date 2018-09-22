<?php /*a:2:{s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\index\index.html";i:1526377608;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\public\foot.html";i:1526378661;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>方块智慧农业</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">	
	<script src="/phone/jq/jquery.min.js"></script>
	<script src="/phone/js/bootstrap.min.js"></script>
	<script src="/phone/js/toucher.js"></script>
	<link href="/phone/css/cropper.min.css" rel="stylesheet">
	<link href="/phone/css/sitelogo.css" rel="stylesheet">
	<script src="/phone/js/cropper.min.js"></script>
	<script src="/phone/js/sitelogo.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>

<script> 
var myTouch = util.toucher(document.getElementById('myCarousel')); 
myTouch.on('swipeLeft',function(e){ 
$('#carright').click(); 
}).on('swipeRight',function(e){ 
$('#carleft').click(); 
}); 
</script>
</body>
</html>
<div><!-- 轮播 -->
		<div>
			<div id="myCarousel" class="carousel slide">
	<!-- 轮播（Carousel）指标 -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>   
	<!-- 轮播（Carousel）项目 -->
	<div class="carousel-inner">
		<div class="item active">
			<img src="/phone/image/carousel_1.png" alt="First slide">
			<div class="carousel-caption"></div>
		</div>
		<div class="item">
			<img src="/phone/image/carousel_2.png" alt="Second slide">
			<div class="carousel-caption"></div>
		</div>
		<div class="item">
			<img src="/phone/image/carousel_3.png" alt="Third slide">
			<div class="carousel-caption"></div>
		</div>
	</div>
	<!-- 轮播（Carousel）导航 -->
	<a id="carleft" class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	</a>
	<a id="carright" class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	</a>
</div>
</div>
</div>

<div class="trait"><!-- 特点 -->
	<div class="trait_1">
		<div class="trait_ico"><img src="/phone/image/ico_1.png" alt=""></div>
		<div class="trait_text_2_1">
			<span style="color: #797979;">便捷接入</span><br>
			<span class="trait_text">只需要简单步骤即可方便快捷的介入病的设备</span>
		</div>
	
		<div class="trait_ico"><img src="/phone/image/ico_2.png" alt=""></div>
		<div class="trait_text_2">
			<span style="color: #797979;">云存储</span><br>
			<span class="trait_text">安全可靠的云存储，为你保留每一条上传的数据</span>
		</div>
	</div>
		<div class="trait_1">
		<div class="trait_ico"><img src="/phone/image/ico_3.png" alt=""></div>
		<div class="trait_text_2_1">
			<span style="color: #797979;">活跃的交流社区</span><br>
			<span class="trait_text">论坛，博客各种社区，活跃用户与您分享交流</span>
		</div>
	
		<div class="trait_ico"><img src="/phone/image/ico_4.png" alt=""></div>
		<div class="trait_text_2">
			<span style="color: #797979;">多平台的支持</span><br>
			<span class="trait_text">对多个平台完美支持，走到哪您都可以享受我们的服务</span>
		</div>
	</div>
<!-- 	<div class="trait_1">
		<div class="trait_ico"><img src="/phone/image/ico_3.png" alt=""></div>
		<div class="trait_text_2_1">
			<span style="color: #797979;">活跃的交流社区</span><br>
			<span class="trait_text">论坛，博客各种社区，活跃用户与您分享交流</span>
		</div>

		<div class="trait_ico"><img src="/phone/image/ico_4.png" alt=""></div>
		<div class="trait_text_2">
			<span style="color: #797979;">多平台的支持</span><br>
			<span class="trait_text">对多个平台完美支持，走到哪您都可以享受我们的服务</span>
		</div>
	</div> -->
</div>


<div class="course"><!-- 产品教程 -->

	<div class="course_main">
	<div class="course_1"><span class="course_top">•</span><span class="course_title">产品教程</span><span class="course_top">•</span></div>
	<div class="course_video">
		<div class="course_video1">
		<video src="/phone/video/demo_video.mp4" style="width:170px;height:100px;" controls="controls"></video>
		<br><span style="color: #797979;">如何租赁农场</span></div>
		<div class="course_video2">
		<video src="/phone/video/demo_video.mp4" style="width:170px;height:100px;" controls="controls"></video>
		<br><span style="color: #797979;">如何发布自己的农场</span></div>
	</div>

	<div class="course_1"><span class="course_top">•</span><span class="course_title">农场主指南</span><span class="course_top">•</span></div>
	<div class="course_ico"><img src="/phone/image/ico_5.png" alt=""></div>
	</div>

</div>


<div class="farmlive1">
<div class="farmlive"><!-- 农场直播 -->
	<div class="farmlive_top_title"><span class="course_top">•</span><span class="course_title">农场直播</span><span class="course_top">•</span></div>
	<div class="farmlive_main">
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
		<div class="farmlive_1">
		<a href="/api/v2/farm/farm_detail.html?farm_id=<?php echo htmlentities($vo['id']); ?>">
		<div class="farmlive_2">
			<div class="farmlive_pic"><img src="<?php echo htmlentities($vo['img']); ?>" alt=""></div>
			<div class="farmlive_text">
				<div class="farmlive_top">
					<div class="farmlive_top_left"><span class="farmlive_top"><?php echo htmlentities($vo['name']); ?></span></div>
					<div class="farmlive_top_right"><span class="farmlive_money_color"><?php echo htmlentities($vo['price']); ?></span><span class="farmlive_money">元/<?php switch($vo['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?></span></div>			
				</div>
				<div class="farmlive_address"><img src="/phone/image/ico_6.png" alt="" style="width:4%;height:4%;margin-right:2px;margin-bottom: 5px;"><?php echo htmlentities($vo['province']); ?><?php echo htmlentities($vo['city']); ?><?php echo htmlentities($vo['area']); ?></div>
				<?php foreach($vo['service'] as $v): ?>
						<button  class="farmlive_button1"><?php echo htmlentities($v); ?></button>
						<?php endforeach; ?>
			</div>
		</div>
		</a>
		</div>

<?php endforeach; endif; else: echo "" ;endif; ?>
		
		<a href="#">
		<div class="better">
			<span>查看更多</span>
		</div>
		</a>



	</div>

</div>
</div>
	<div class="bottom"><!-- 底部 -->
	<div class="bottom_1">
	<a href="/api/v2/index/index.html" class="bottom_a_active">
		<div><span class="icon-ico_5 ico_size"></span></div>
		<div><span>首页</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/farm/farm_list.html" class="bottom_a">
		<div><span class="icon-ico_2 ico_size"></span></div>
		<div><span>智慧农业</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/user/user_lease.html" class="bottom_a">
		<div><span class="icon-ico_3 ico_size"></span></div>
		<div><span>我的农场</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/user/my.html" class="bottom_a">
		<div><span class="icon-ico_1 ico_size"></span></div>
		<div><span>我的</span></div>
	</a>
	</div>
</div>

