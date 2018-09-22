<?php /*a:1:{s:73:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\lease\lease_farm1.html";i:1526178645;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>订单支付</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
<body>
	<div id="top"><!-- 头部 -->
		<div class="container" id="top_main">
			<span id="top_left">
				联系我们: <a style="text-decoration: none;" href="#" id="top_phone">400-1895555</a>
			</span>
			<span id="top_right">
			<?php if((empty($name))): ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/index/login1" id="top_login">登录</a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/register1" id="top_logon">注册</a>

			<?php else: ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit" id="top_login">欢迎您，<?php echo htmlentities($name); ?>用户</a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/exit_login" id="top_logon">退出</a>
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
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 ">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>
	

<div class="bottom_6 bottom_6_1">
		<div class="container   pay_color">

			<div><h2>订单支付</h2></div>
			<div class="bottom_6_1 pay_address">
				<div class="pay_address_1">				
					<span class="pay_name">武汉汉南农场一区</span><br>
					<span class="pay_area">面积:1000m²</span><br>
					<span class="pay_address_3">湖北省武汉市汉南区物华路564号</span>
				</div>
				<div class="pay_money">
					<span class="pay_area">总计&nbsp;:&nbsp;<span class="pay_money_1">6200</span>元</span>
				</div>
			</div>
			<div class="pay_code"><img src="/static/image/code_1.png" alt=""><br>微信扫码支付</div>


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