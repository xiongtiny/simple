<?php /*a:3:{s:70:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\farm\farm_list.html";i:1526441606;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526437494;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526435605;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>农场租赁</title>
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
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 navigation_3_active">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>






	<!-- 	翻页 -->

	<div class="container">
		<br><span style="color: #7e7f7e;">农场租赁</span><br><br>
					<div class="show_farm" style="height: 400px;">
					<?php foreach($data as $v): ?>
						<div class="show_farm_1"><!-- 第一个农场 -->
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail?farm_id=<?php echo htmlentities($v['id']); ?>">

								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span><?php echo htmlentities($v['name']); ?></span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right"><?php echo htmlentities($v['province']); ?><?php echo htmlentities($v['city']); ?><?php echo htmlentities($v['address']); ?></div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left" style="width: 220px;">
												<?php foreach($v['service'] as $z): ?>
										<!-- 	    <button class="show_farm_button">按需种植</button>
											    <button class="show_farm_button">随时来访</button> -->
											   <button class="show_farm_button"><?php echo htmlentities($z); ?></button>
											   <?php endforeach; ?>


											</div>
											<div class="show_farm_money_right" style="margin-left: 0px;"><span style="font-size: 23px;color:#e00000; "><?php echo htmlentities($v['price']); ?></span>元/
											<?php switch($v['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?>
											</div>
									</div>
								</div>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
		<?php echo $data; ?>


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