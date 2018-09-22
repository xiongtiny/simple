<?php /*a:1:{s:70:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\user\feedback1.html";i:1526193748;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>意见反馈</title>
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
	<div class="login_down"><button type="submit" value="" class="login_down_button">确认</button></div>
	<div class="login_up">
		<div class="login_up_1">
			<label for="phone">联系方式:</label>
			<input id="phone" name="phone" type="text" class="form-control_style" placeholder="我们将及时与你沟通">
		</div>
		<div class="feedback">
			<label for="feedback">意见反馈:</label>
			<textarea name="content" id="" cols="30" rows="10" class="form-control_style_1"  placeholder="请输入您的意见或建议"></textarea>
		</div>
		<div style="height: 30px;"></div>

	</div>
	</form>
<script src="/static/js/sweetalert.min.js"></script>
<link href="/static/css/sweetalert.css" rel="stylesheet">
<script type="text/javascript">
	    $("form").submit(function () {
        var url="/api/v2/user/feedback";
        $.ajax({
            url:url,
            type:"post",
            data:$("form").serialize(),
            success:function (data) {
            	console.log(data);
                if(data.code==200){
                    swal(data.message);
                     window.location.href="/api/v2/user/my";
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
</body>
</html>