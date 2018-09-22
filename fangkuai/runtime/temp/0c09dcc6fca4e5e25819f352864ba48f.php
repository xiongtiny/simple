<?php /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v2\index\register1.html";i:1526372274;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
	<link rel="stylesheet" href="/phone/css/style.css">
	<script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/sweetalert.min.js"></script>
    <link href="/static/css/sweetalert.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>
	<form action="" >
	<div class="login_up">
		<div class="login_up_1">
			<label for="">手机号码:</label>
			<input type="text" name="phone" class="form-control_style" placeholder="请输入手机号码">
		</div>
		<div class="password_1">
			<label for="" class="password_text">验证码:</label>
			<input type="text" name="code" class="form-control_style" placeholder="请输入验证码">
			<div class="password_1_1"><button style="border: 0px;background-color: #ffffff;color:#00A3E8;font-size: 0.8em;margin-top: 0.5em;" type="button" id="send">获取验证码</button></div>
		</div>
		<div class="password_pass">
			<label for="" class="login_up_2_text">密码:</label>
			<input type="password" name="password" class="form-control_style" placeholder="请输入登录密码">
		</div>
		<div class="login_up_3">
			<div class="login_up_3_right"><a href="/api/v2/index/login1">已有账号，去登录</a></div>
		</div>
	</div>
	<div class="login_down"><button type="submit"  class="login_down_button">确认</button></div>
</form>
</body>
</html>
<script type="text/javascript">
    $("form").submit(function () {       
        var url="/api/v2/index/register";
        $.ajax({
            url:url,
            type:"post",
            data:$("form").serialize(),
            success:function (data) {
                if(data.code==200){
                	swal(data.message);
                    window.location.href="/api/v2/index/login1";
                }else{
                	swal(data.message);
                }
               
            }
        })
        return false;
    })
    $("#send").click(function () {

        var phone=$("input[name='phone']").val();
        var url="/api/v2/index/sendSms";
        if(phone==''){
            swal("请填写11位手机号");
        }
        $.ajax({
            url:url,
            data:{phone:phone},
            type:'post',
            success:function(data) {
                if(data.status!=0){
                    swal(data.message);
                    return;
                }
            }

        })
    })
</script>