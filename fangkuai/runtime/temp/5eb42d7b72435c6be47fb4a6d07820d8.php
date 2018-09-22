<?php /*a:1:{s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\index\login.html";i:1525945752;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/css/style.css">
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
					<a class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 ">智慧农业</div></a>
					<a class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>



	<div class="bottom_6 ">
		<div class="container bottom_9_1">
		<div class="bottom_9 bottom_6_1">
			<div class="bottom_9_2 ">

				<div class="login_ico"><img src="/static/image/logo_1.png" alt=""></div>
			
			</div>
			<div class="bottom_9_2 bottom_9_3">
				<span style="font-size: 30px;">登录</span><br><br>
				<form action="">
						<div class="form-group user_input"><!--   手机号码输入框 -->
							<input type="text" id="phone" class="form-control_style_login" placeholder="手机号码">
							<img  class="user_ico" src="/static/image/user_1.png" alt="">
						</div>
						<div class="form-group user_input">	<!-- 	密码输入框 -->
							<input type="password" id="password" class="form-control_style_login" placeholder="密码">
							<img class="user_ico" src="/static/image/user_2.png" alt="">
							<div style="text-align: right;width: 78%;color: #00a3e8;padding-top: 4px;">
							<a href="/index.php/api/v1/index/register1" style="color: #00a3e8;">立即注册</a> | <a href="/index.php/api/v1/index/retrieve_password1" style="color: #00a3e8;">忘记密码</a>
						</div>
						</div>
						<br>
						<div class="form-group">
						<button class="bottom_9_4" type="button" onclick="input()">确认</button>
						</div>
						
					
					
				</form>
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
<script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.js"></script>
<script>
 

	function input() {
	  $.ajax({ 
		    type: "post", 	
			url: "/index.php/api/v1/index/login",
			data: {
				phone: $("#phone").val(), 
				password: $("#password").val(), 
			},
			success: function(data) {
				if(data.code==400){
					alert(data.message)
				}
				if(data.code==200){
					console.log(data);
				    alert(data.message)
				    window.location.href='/index.php/api/v1/index/index';
				}
			},
			error: function(jqXHR){     
			   alert("发生错误：" + jqXHR.status);  
			},     
		});
	}
		
</script>
</body>
</html>