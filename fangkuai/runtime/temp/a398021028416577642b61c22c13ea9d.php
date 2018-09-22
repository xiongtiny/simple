<?php /*a:3:{s:65:"/home/wwwroot/fangkuai/application/index/view/v1/index/index.html";i:1526446725;s:65:"/home/wwwroot/fangkuai/application/index/view/v1/public/head.html";i:1526446725;s:65:"/home/wwwroot/fangkuai/application/index/view/v1/public/foot.html";i:1526446725;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<!-- 	<link rel="stylesheet" href="/static/css/bootstrap.css"> -->
	<link rel="stylesheet" href="/static/css/style.css">
	<script src="/static/jq/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
<style>
</style>
</head>
<body>
<div id="top"><!-- 头部 -->
    <div class="container" id="top_main">
			<span id="top_left">
				联系我们: <a href="#" id="top_phone">400-1895555</a>
			</span>
        <span id="top_right">
			<?php if((empty(app('request')->session('user')))): ?>
			<a href="/index.php/api/v1/index/login1" id="top_login" style="text-decoration: none;">登录</a>&nbsp;|&nbsp;<a href="/index.php/api/v1/index/register1" style="text-decoration: none;" id="top_logon">注册</a>

			<?php else: ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit" id="top_login">欢迎您，<?php echo htmlentities(app('request')->session('user')); ?></a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/exit_login" id="top_logon">退出</a>
			<?php endif; ?>
			</span>
    </div>
</div>


	<div id="navigation"><!-- 导航 -->
		<div class="container">
			<div id="navigation_left">
				<a style="text-decoration: none;" href="/index.php/api/v1/index/index"><img src="/static/image/logo.png" alt=""></a>
			</div>
			<div id="navigation_right">
				<div class="navigation_1 bottom_6_1">
					<div class="navigation_2 navigation_3_active">首页</div>
					<a style="text-decoration: none;" class="farm" href="/index.php/api/v1/farm/index"><div class="navigation_2">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="#"><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>

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
			<img src="/static/image/carousel_1.png" alt="First slide">
			<div class="carousel-caption"></div>
		</div>
		<div class="item">
			<img src="/static/image/carousel_2.png" alt="Second slide">
			<div class="carousel-caption"></div>
		</div>
		<div class="item">
			<img src="/static/image/carousel_3.png" alt="Third slide">
			<div class="carousel-caption"></div>
		</div>
	</div>
	<!-- 轮播（Carousel）导航 -->
	<a style="text-decoration: none;" class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	</a>
	<a style="text-decoration: none;" class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	</a>
</div> 

</div>
	</div>

	<div id="icon_bottom"><!-- 图标 -->
		<div class="container">
			<ul class="nav nav-tabs  nav-tabs_style" id="icon_main">
				<li id="icon">
					<img src="/static/image/ico_1.png" alt="">		
				</li>
				<li id="icon_text">
					<h4>便捷接入</h4>
					<p>只需最简单步骤即可<br>方便快捷的介入病的设备</p>
				</li>
				<li id="icon">
					<img src="/static/image/ico_2.png" alt="">
				</li>
				<li id="icon_text">
					<h4>云存储</h4>
					<p>安全可靠的云存储，<br>为你保留每一条上传的数据</p>
				</li>
				<li id="icon">
					<img src="/static/image/ico_3.png" alt="">
				</li>
				<li id="icon_text">
					<h4>活跃的交流社区</h4>
					<p>论坛、博客各种社区、<br>活跃用户与您分享交流</p>
				</li>
				<li id="icon">
					<img src="/static/image/ico_4.png" alt="">
				</li>
				<li id="icon_text">
					<h4>多平台的支持</h4>
					<p>对多个平台完美支持、走<br>到哪您都可以享受我们的服务</p>
				</li>
			</ul>
		</div>
	</div>

	<div class="container picture"><!-- 农场直播 -->
		<div class="bottom_6_1">
			<div class="container_1">
				<h2>农场直播<br><small>Farm&nbsp;live</small></h2>
			</div>
			<div class="container_2"><br><br>
				<a href="lease.html">More <img src="/static/image/ico_5.png" alt="">	</a>	
			</div>
		</div>
		<div>
			<div class="show_farm">

					<div class="show_farm">
				

			</div>
		</div>
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
		

</body>
</html>