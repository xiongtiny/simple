<?php /*a:3:{s:88:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\other\other_about_us.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526436419;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>关于我们</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/css/style.css">
				<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.4.6&key=2b1fab4dad7e85c44f1c72aac9e10ffd"></script>
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
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 ">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<div class="navigation_2 navigation_3_active">关于我们</div>
				</div>
			</div>
		</div>
	</div>

	<div>
		<div class="oration"><img src="/static/image/welcome_2.png" alt="">		
		
		</div>
		<div class="container oration_text">
		<p><span class="oration_text_1">我们</span>是一群热爱互联网，创意设计与农业技术的年轻人，主要成员曾经在国际知名的电信，家电和互联网公司工作。2016年3月正式离职开始“方块智慧农业”的创办和研发，并与2年后正式上线国内第一个开放的农业物联网平台，产品和平台在13年初接收硬件创业孵化器HAXLR8R孵化，并于5月在深圳市成功发布。</p><br>
		<p>我们是一群热爱生活，憧憬美好未来的年轻人，我们用自己的激情去打造服务生活的现代农业物联网服务。相信我们在软件，互联网，通信和硬件全面的研发能力，能够为用户带来更加贴心的智能生活方式。</p>
		</div>

	</div>
	<div class="container question_1 bottom_6_1">	
		<div id="map_2" style="width:600px;height:400px;"></div>
		<div class="locality_2">
			<h2>商业咨询:</h2>
			<span style="color:#4e4e4e;font-size: 20px;">Email&nbsp;:&nbsp;862944395@qq.com <br>QQ&nbsp;:&nbsp;862944395</span>

			<h2>技术支持:</h2>
			<span style="color:#4e4e4e;font-size: 20px;">Email&nbsp;:&nbsp;shinvishilling@163.com <br>QQ&nbsp;:&nbsp;862944395 <br>交流群:83665632</span>
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
		var map = new AMap.Map('map_2', {
		    resizeEnable: true,
		    zoom:11,
		    center: [116.397428, 39.90923]        
		});
	</script>
</body>
</html>