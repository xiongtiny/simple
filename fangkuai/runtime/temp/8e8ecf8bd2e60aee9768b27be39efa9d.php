<?php /*a:3:{s:99:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\other\other_product_description.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526436419;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526436419;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>产品教程</title>
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


	<div id="navigation_1"><!-- 导航 -->
		<div class="container">
			<div id="navigation_left">
				<a style="text-decoration: none;" href="/index.php/api/v1/index/index"><img src="/static/image/logo.png" alt=""></a>
			</div>
			<div id="navigation_right">
				<div class="navigation_1 bottom_6_1">
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 ">智慧农业</div></a>
					<div class="navigation_2 navigation_3_active">产品教程</div>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
					

				</div>
			</div>
		</div>
	</div>


	<div class="container bottom_6_1 video"><!-- 视频教学区 -->
		<div class="video_1"><video src="/static/video/demo_video.mp4" width="550px" height="300px;" controls="controls" style="background-color: #000000;" ></video></div>
		<div class="video_2"><video src="/static/video/demo_video.mp4" width="550px" height="300px;" controls="controls" style="background-color: #000000;" ></video></div>
	</div>
	<div class="container bottom_6_1 video video_text">
		<div class="video_1" style="margin-left:-10px;">
			<span class="glyphicon glyphicon-eject"></span><br>
			<span>如何租凭农场</span>
		</div>
		<div class="video_2">
			<span class="glyphicon glyphicon-eject"></span><br>
			<span>如何发布自己的农场</span>
		</div>
	</div>
	<div class="guide_backgrund">
		<div class="container bottom_6_1 guide_1"><!-- 指南 -->
			<div class=""><img src="/static/image/icon_1.png" alt=""></div>
			<div class="guide_2"><img src="/static/image/icon.png" alt=""></div>
		</div>
	</div>
	<div class="container question">
		<h3  class="title_1">常见问题</h3><br><br>
		<h4>1.农场主怎么收款？</h4>
			<blockquote>客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，</blockquote>
		<h4>2.农场主怎么收款？</h4>
			<blockquote>客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说</blockquote>
		<h4>3.农场主怎么收款？</h4>
			<blockquote>客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，</blockquote>
		<h4>4.农场主怎么收款？</h4>
			<blockquote>客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是客服如是说，客服如是说，客服如是说，客服如是说，客服如是说，客服如是说</blockquote>
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