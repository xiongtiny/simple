<?php /*a:2:{s:70:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\farm\farm_list.html";i:1526377585;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\public\foot.html";i:1526378661;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>智慧农业</title>
	<script src="/phone/js/iscroll.js"></script>
	<link rel="stylesheet" href="/phone/css/swiper.css">
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
	<script src="/phone/js/swiper.js"></script>
</head>
<body>
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
	<div class="smartFarm">
		<div class="smartFarm_top">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide smartFarm_top_pic1">
						<img src="/phone/image/picture_3.png" alt="">
						<div class="smartFarm_top_text">工业化设计</div>
					</div>
					<div class="swiper-slide smartFarm_top_pic">
						<img src="/phone/image/picture_2.png" alt="">
						<div class="smartFarm_top_text1">农田灌溉</div>
					</div>
					<div class="swiper-slide smartFarm_top_pic">
						<img src="/phone/image/picture_1.png" alt="">
						<div class="smartFarm_top_text1">农业大棚</div>
					</div>
				</div>
			</div>
		</div>

		<div class="smartFarm_main">
			<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
			<div class="farmlive_1"><!-- 第一个农场 -->
			<a href="/api/v2/farm/farm_detail.html?farm_id=<?php echo htmlentities($vo['id']); ?>">
			<div class="farmlive_2">
				<div class="farmlive_pic"><img src="<?php echo htmlentities($vo['img']); ?>" alt=""></div>
				<div class="farmlive_text">
					<div class="farmlive_top">
						<div class="farmlive_top_left"><span class="farmlive_top"><?php echo htmlentities($vo['name']); ?></span></div>
						<div class="farmlive_top_right"><span class="farmlive_money_color"><?php echo htmlentities($vo['price']); ?></span><span class="farmlive_money">元/<?php switch($vo['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?></span></div>			
					</div>
					<div class="farmlive_address"><img src="/phone/image/ico_6.png" alt="" style="width:4%;height:4%;margin-right:2px;margin-bottom: 5px;"><?php echo htmlentities($vo['province']); ?><?php echo htmlentities($vo['city']); ?><?php echo htmlentities($vo['area']); ?></div>
					<div class="farmlive_button">
						<?php foreach($vo['service'] as $v): ?>
						<button  class="farmlive_button1"><?php echo htmlentities($v); ?></button>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			</a>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		

						

		</div>

		<div class="smartFarm_botton">没有更多了</div>


	</div>
	<div class="bottom"><!-- 底部 -->
	<div class="bottom_1">
	<a href="/api/v2/index/index.html" class="bottom_a">
		<div><span class="icon-ico_5 ico_size"></span></div>
		<div><span>首页</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/farm/farm_list.html" class="bottom_a_active">
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
	<script>
	var mySwiper = new Swiper('.swiper-container', {
	    autoplay: true,//可选选项，自动滑动
	    freeMode:true,//滑动不够一格，不会自动贴合
	    slidesPerView:2.2,//设置slider容器能够同时显示的slides数量
	})

	</script>
</body>
</html>