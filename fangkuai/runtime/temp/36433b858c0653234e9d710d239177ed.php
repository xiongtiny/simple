<?php /*a:1:{s:68:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\index\login1.html";i:1526307827;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
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
<form action="">
	
	<div class="login_up">
		<div class="login_up_1">
			<label for="">手机号码:</label>
			<input type="text" name="phone" class="form-control_style" placeholder="请输入手机号码">
		</div>
		<div class="login_up_2">
			<label for="" class="login_up_2_text">密码:</label>
			<input type="password" name="password" class="form-control_style" placeholder="请输入登录密码">
		</div>
		<div class="login_up_3">
			<div class="login_up_3_left"><a href="/api/v2/index/register1">立即注册</a></div>
			<div class="login_up_3_right"><a href="/api/v2/index/retrieve_password1">忘记密码</a></div>
		</div>
	</div>
	<div class="login_down"><button type="submit" value="" class="login_down_button">确认</button></div>

</form>

</body>
</html>
<script type="text/javascript">
	    $("form").submit(function () {
        var url="/api/v2/index/login";
        $.ajax({
            url:url,
            type:"post",
            data:$("form").serialize(),
            success:function (data) {
            	console.log(data);
                if(data.code==200){
                    swal(data.message);
                    window.location.href="/api/v2/index/index";
                    return;
                }else{
                	swal(data.message);
                 //alert("登陆成功");
                }
            }
        })
        return false;
    })
</script>