<?php /*a:1:{s:80:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\index\retrieve_password1.html";i:1526027232;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>忘记密码</title>
	<link rel="stylesheet" href="/phone/css/style.css">
	<script src="/static/js/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>
	<form action="">
	<div class="login_down"><button type="submit" value="确认" class="login_down_button">确认</button></div>
	<div class="login_up">
		<div class="login_up_1">
			<label for="">手机号码:</label>
			<input type="text" class="form-control_style" name="phone" placeholder="请输入手机号码">
		</div>
		<div class="password_1">
			<label for="" class="password_text">验证码:</label>
			<input type="text" name="code" class="form-control_style" placeholder="请输入验证码">
			<div class="password_1_1"><button style="border: 0px;background-color: #ffffff;color:#00A3E8;font-size: 0.8em;margin-top: 0.5em;" type="button" id="send">获取验证码</button></div>
		</div>
		<div class="password_pass">
			<label for="" class="login_up_2_text">密码:</label>
			<input type="password" name="password" class="form-control_style" placeholder="请输入新密码">
		</div>
	</div>
</form>
</body>
</html>
<script type="text/javascript">
    $("form").submit(function () {       
        var url="/api/v2/index/retrieve_password";
        $.ajax({
            url:url,
            type:"post",
            data:$("form").serialize(),
            success:function (data) {
                if(data.code==200){
                	alert(data.message);
                   location.href="/api/v2/index/login1";
                }else{
                	alert(data.message);
                }
               
            }
        })
        return false;
    })
    $("#send").click(function () {

        var phone=$("input[name='phone']").val();
        var url="/api/v2/index/sendSms";
        if(phone==''){
            alert("请填写11位手机号");
        }
        $.ajax({
            url:url,
            data:{phone:phone},
            type:'post',
            success:function(data) {
                if(data.status!=0){
                    alert(data.message);
                    return;
                }
            }

        })
    })
</script>