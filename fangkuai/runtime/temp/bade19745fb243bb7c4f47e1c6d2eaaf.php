<?php /*a:3:{s:69:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\user\feedback.html";i:1526465171;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526437494;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526435605;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/sweetalert.css">
    <link href="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.css" rel="stylesheet">
    <script type="text/javascript" src="/static/js/sweetalert.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.js"></script>
    	<style type="text/css">

    #photo {
        max-width:100%;
        max-height:350px;
    }
    .img-preview-box {
        text-align: center;
    }
    .img-preview-box > div {
        display: inline-block;;
        margin-right: 10px;
    }
    .img-preview {
        overflow: hidden;
    }
    .img-preview-box .img-preview-lg {
        width: 150px;
        height: 150px;
    }
    .img-preview-box .img-preview-md {
        width: 100px;
        height: 100px;
    }
    .img-preview-box .img-preview-sm {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>
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
		<div class="container  bottom_6_1">

			<div style="width: 25%;"> <!-- 右侧 -->
				<div class="guide_8_uesr">
					<?php if(empty($user['img'])): ?>
					<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
						<img id="user-photo" src="/static/image/tx.jpeg" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
					</div>
					<?php else: ?>
					<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
						<img id="user-photo" src="<?php echo htmlentities($user['img']); ?>" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
					</div>
					<?php endif; ?>

					<div>
						<?php if((empty($user['name']))): ?>
						<h3></h3>
						<?php else: ?>
						<h3><?php echo htmlentities($user['name']); ?></h3>
						<?php endif; ?>
						<span><?php echo htmlentities($user['phone']); ?></span>
					</div>
				</div>
				<div style="padding-bottom: 100px;font-size: 16px;">
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit"><div class="guide_8_1">资料与安全</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_lease"><div class="guide_8_1">我租赁的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_release"><div class="guide_8_1">我发布的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/transaction_record"><div class="guide_8_1">交易记录</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/feedback"><div class="guide_8_1 guide_8_1_active">意见反馈</div></a>
					</div>
				</div>
			</div>

			<div class="user_1_1">
				<form action="">
				<div  class="form-group">
					<label  for="">联系电话&nbsp;</label>
					<input type="text" id="phone" class="form-control_style_2" readonly value="<?php echo htmlentities($user['phone']); ?>">
						
				</div>
				<div class="form-group bottom_6_1">
					<label  for="">意见反馈&nbsp;&nbsp;</label>
					<div><textarea name="" id="content" cols="30" rows="10" class="form-control_style_3" placeholder="我们将及时与你沟通"></textarea></div>
						
				</div>
				<div style="text-align: center;"><button type="button" onclick="input()" class="user_botton">提交</button></div>
					
				</form>
					
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

<script>
 

	function input() {
	  $.ajax({ 
		    type: "post", 	
			url: "/index.php/api/v1/user/feedback",
			data: {
				phone: $("#phone").val(), 
				content: $("#content").val(), 
			},
			success: function(data) {
				if(data.code==400){
					alert(data.message);
				}
				if(data.code==200){
				    alert(data.message);
                    window.location.href="/api/v1/user/feedback";
				}
			},
			error: function(jqXHR){     
			   alert("发生错误：" + jqXHR.status);  
			},     
		});
	}
		
</script>

</html>