<?php /*a:3:{s:78:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\farm\index.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526436419;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>智慧农业</title>
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
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 navigation_3_active">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>

	<div>
		<div><img src="/static/image/welcome.png" alt=""></div>
		<div class="button">
			<button class="button_1 button_2" onclick="window.open('/index.php/api/v1/farm/farm_list')">我要租赁农场</button>
			<button class="button_1 button_3" onclick="window.open('/index.php/api/v1/farm/add_farm')">发布我的农场</button>
		</div>
	</div>

	<div class="container picture_">
			<div class="bottom_6_1">
				<div class="container_1">
					<h2>农场租赁<br><small>Farm&nbsp;lease</small></h2>
				</div>
				<div class="container_2"><br><br>
					<a style="text-decoration: none;" href="lease.html">More	<img src="/static/image/ico_5.png" alt="">	</a>	
				</div>
			</div>
			<div>  <!-- 农场租赁 -->
					<div class="show_farm">
						
						<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($data) ? array_slice($data,0,6, true) : $data->slice(0,6, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
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
						<?php endforeach; endif; else: echo "" ;endif; ?>
						
<!-- 						<div class="show_farm_1">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div>
						<div class="show_farm_2">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div>
						<div class="show_farm_3">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div>
						<div class="show_farm_1">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div>
						<div class="show_farm_2">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div>
						<div class="show_farm_3">
							<a style="text-decoration: none;" href="/index.php/api/v1/farm/farm_detail1">
								<img src="/static/image/picture_1.png" alt="">
								<div class="show_farm_text">
									<div class="show_farm_name"><span>武汉汉南农场一区</span></div>
										<div  class="bottom_6_1 show_farm_map">
												<div class="show_farm_map_left"><img src="/static/image/ico_9.png" alt=""></div>
												<div class="show_farm_map_right">湖北省武汉市汉南区物华路</div>
										</div>
									<div class="bottom_6_1 show_farm_money">
											<div class="show_farm_money_left small-font smallsize-font">
												<button class="show_farm_button">按需种植</button>
												<button class="show_farm_button">随时来访</button>
												<button class="show_farm_button">送货到家</button>
											</div>
											<div class="show_farm_money_right"><span style="font-size: 23px;color:#e00000; ">6200</span>元/年</div>
									</div>
								</div>
							</a>
						</div> -->



					</div>
			</div>
	</div>

	<div class="show">
		<div class="container show_1">
			
			<div><h2>产品生态圈<br><small>Product&nbsp;ecosystem</small></h2></div>
			<div class="show_farm">
				<div class="shop">
					<a style="text-decoration: none;" href="#">
					<img src="/static/image/picture_1.png" alt="">
					<div class="shop_text"><h1>工业化设计</h1></div>
					</a>
				</div>
				<div class="shop">
					<a style="text-decoration: none;" href="#">
					<img src="/static/image/picture_2.png" alt="">
					<div class="shop_text"><h1>农田灌溉</h1></div>
					</a>
				</div>
				<div class="shop">
					<a style="text-decoration: none;" href="#">
					<img src="/static/image/picture_3.png" alt="">
					<div class="shop_text"><h1>农业大棚</h1></div>
					</a>
				</div>
			</div>	
	
		</div>
	</div>

	<div class="container show_1">
		<div><h2>商务合作<br><small>Business&nbsp;cooperation</small></h2></div>
		<div>
			<div class="show_farm">

				<div class="company_logo"><img src="/static/image/picture_1.png" alt=""></div>
				<div class="company_logo"><img src="/static/image/picture_2.png" alt=""></div>
				<div class="company_logo_right"><img src="/static/image/picture_3.png" alt=""></div>
				<div class="company_logo"><img src="/static/image/picture_1.png" alt=""></div>
				<div class="company_logo"><img src="/static/image/picture_2.png" alt=""></div>
				<div class="company_logo_right"><img src="/static/image/picture_3.png" alt=""></div>



				

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