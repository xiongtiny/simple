<?php /*a:1:{s:65:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\user\data.html";i:1526289148;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>资料与安全</title>
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
	<div class="login_down"><button type="submit" value="确认" class="login_down_button">确认</button></div>
	<div class="login_up">
		<?php if((empty($user_data['name']))): ?>
		<div class="data_name">
			<label for="" class="data_text_1">昵称:</label>
			<input type="text" name="name" class="form-control_style" placeholder="输入用户名">
		</div>
		<?php else: ?>
		<div class="data_name">
			<label for="" class="data_text_1">昵称:</label>
			<input type="text" name="name" class="form-control_style" value="<?php echo htmlentities($user_data['name']); ?>" \>
		</div>
		<?php endif; ?>
		<div class="data_password">
			<label for="" class="data_text_2">旧密码:</label>
			<input type="password" name="password" class="form-control_style" placeholder="请输入旧密码">
		</div>
		<div class="data_new_password">
			<label for="" class="data_text_2">新密码:</label>
			<input type="password" name="password2" class="form-control_style" placeholder="请输入新密码">
		</div>
		<?php if((empty($user_data['alipay']))): ?>
		<div class="data_zfb">
			<label for="" class="data_text_2">支付宝:</label>
			<input type="text" name="alipay" class="form-control_style" placeholder="请输入支付宝账号">
		</div>
		<?php else: ?>
		<div class="data_zfb">
			<label for="" class="data_text_2">支付宝:</label>
			<input type="text" name="alipay" class="form-control_style" value="<?php echo htmlentities($user_data['alipay']); ?>">
		</div>
		<?php endif; ?>
		<div style="height: 30px;"></div>

	</div>
</form>
</body>
</html>
<script type="text/javascript">
$("form").submit(function () {
	var url="/api/v2/user/user_edit";
	$.ajax({
	    url:url,
	    type:"post",
	    data:$("form").serialize(),
	    success:function (data) {
	    	console.log(data);
	        if(data.code==200){
	            swal(data.message);
	            location.href="/api/v2/user/my";
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