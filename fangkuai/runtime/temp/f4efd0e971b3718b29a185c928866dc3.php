<?php /*a:2:{s:85:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v2\user\user_release.html";i:1526433135;s:79:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v2\public\foot.html";i:1526433135;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我的农场</title>	
<body>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>方块智慧农业</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">	
	<script src="/phone/jq/jquery.min.js"></script>
	<script src="/phone/js/bootstrap.min.js"></script>
	<script src="/phone/js/toucher.js"></script>
	<link href="/phone/css/cropper.min.css" rel="stylesheet">
	<link href="/phone/css/sitelogo.css" rel="stylesheet">
	<script src="/phone/js/cropper.min.js"></script>
	<script src="/phone/js/sitelogo.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>

<script> 
var myTouch = util.toucher(document.getElementById('myCarousel')); 
myTouch.on('swipeLeft',function(e){ 
$('#carright').click(); 
}).on('swipeRight',function(e){ 
$('#carleft').click(); 
}); 
</script>
</body>
</html>
	<div class="myFarm">

		<div class="myFarm_top"><!-- 头部 -->
			<div class="myFarm_top_left">
			<a href="user_lease.html" style="color: #000000;">
				<div class="myFarm_title">我租赁的农场</div></a>
			</div>
			<div class="myFarm_top_right"><a href="user_release.html">
				<div class="myFarm_title_active">我发布的农场</div></a>
			</div>
		</div>
			
	<!-- 	<div>
			<button></button>
		</div> -->
		<div class="myFarm_content"><!-- 内容 -->
			
			<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
			<form action="" >

			<div class="myFarm_content_1"><!-- 已上线 -->
					<div class="farmlive_1 myFarm_content_1_up">
						<a href="/api/v2/farm/farm_detail.html?farm_id=<?php echo htmlentities($vo['id']); ?>">
						<div class="farmlive_2">
							<div class="farmlive_pic"><img src="<?php echo htmlentities($vo['img']); ?>" alt=""></div>
							<div class="farmlive_text">
								<div class="farmlive_top">
									<div class="farmlive_top_left"><span class="farmlive_top"><?php echo htmlentities($vo['name']); ?></span></div>
									<div class="farmlive_top_right"><span class="farmlive_money_color"><?php echo htmlentities($vo['price']); ?></span><span class="farmlive_money">元/
										<?php switch($vo['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?></span></div>			
								</div>
								<div class="farmlive_address"><img src="/phone/image/ico_6.png" alt="" style="width:5%;height:5%;margin-right:2px;"><?php echo htmlentities($vo['province']); ?><?php echo htmlentities($vo['city']); ?><?php echo htmlentities($vo['area']); ?></div>
								<?php if($vo['type'] == 0): ?>
								<div class="farmlive_button">
									<span class="myFarm_time">上线时间&nbsp;:&nbsp;<?php echo htmlentities(date("Y-m-d",!is_numeric(strtotime($vo['start_time']))? strtotime(strtotime($vo['start_time'])) : strtotime($vo['start_time']))); ?></span>
								</div>
								
								<?php else: ?>
								<div class="farmlive_button">
									<span class="myFarm_time">租赁时间&nbsp;:&nbsp;&nbsp;<?php echo htmlentities(date("Y-m-d",!is_numeric(strtotime($vo['start_time']))? strtotime(strtotime($vo['start_time'])) : strtotime($vo['start_time']))); ?>至&nbsp;<?php echo htmlentities(date("Y-m-d",!is_numeric(strtotime($vo['downline_time']))? strtotime(strtotime($vo['downline_time'])) : strtotime($vo['downline_time']))); ?></span>
								</div>
								<?php endif; ?>								
								
							</div>
						</div>
						</a>
					</div>
					
					<?php if($vo['type'] == 0): ?>
					<div class="myFarm_content_1_down">
						<div class="myFarm_content_1_down_left">已上线

						<button  class="myFarm_button del_farm" id="<?php echo htmlentities($vo['id']); ?>">删除</button>
						<button  class="myFarm_button_1 downline" id="<?php echo htmlentities($vo['id']); ?>">下线</button>	
						</div>
					</div>
					<?php endif; if($vo['type'] == 1): ?>
					<div class="myFarm_content_1_down">
						<div class="myFarm_content_1_down_left">已出租						
						</div>
					</div>
					<?php endif; if($vo['type'] == 2): ?>
					<div class="myFarm_content_1_down_left">已下线
						<button  class="myFarm_button del_farm" id="<?php echo htmlentities($vo['id']); ?>">删除</button>
						<!-- <button class="myFarm_button_1" onclick="window.open('publish1.html')">修改</button>-->

						</div>
					<?php endif; if($vo['type'] == 3): ?>
					<div class="myFarm_content_1_down_left">已下线
						<button  class="myFarm_button del_farm" id="<?php echo htmlentities($vo['id']); ?>">删除</button>
						<!-- <button  class="myFarm_button_1" onclick="window.open('publish1.html')">修改</button> -->
						<a  class="myFarm_button_1" href="/api/v2/farm/edit_farm?farm_id=<?php echo htmlentities($vo['id']); ?>">修改</a>
						</div>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>	

			</div>
			</form>	

		</div>
		<div class="bottom_jia">
			<a href="/api/v2/farm/publish"><button type="button" class="bottom_jia1" ><span class="icon-ico_jia"></span></button></a>
		</div>	

	</div>
	<div class="bottom"><!-- 底部 -->
	<div class="bottom_1">
	<a href="/api/v2/index/index.html" class="bottom_a">
		<div><span class="icon-ico_5 ico_size"></span></div>
		<div><span>首页</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/farm/farm_list.html" class="bottom_a">
		<div><span class="icon-ico_2 ico_size"></span></div>
		<div><span>智慧农业</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/user/user_lease.html" class="bottom_a_active">
		<div><span class="icon-ico_3 ico_size"></span></div>
		<div><span>我的农场</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/user/my.html" class="bottom_a">
		<div><span class="icon-ico_1 ico_size"></span></div>
		<div><span>我的</span></div>
	</a>
	</div>
</div>

	
</body>
</html>
<script src="/static/js/jquery.min.js"></script>
<script type="text/javascript">		
	   $(".del_farm").click(function () {
	   	var farm_id = $(this).attr('id');
	   
        $.ajax({
            url:"/api/v2/user/del_farm",
            type:"post",
            data:{farm_id:farm_id},
            success:function (data) {
                if(data.code==200){
                    alert(data.message);
                    location.href="/api/v2/user/user_release";              
                    return;
                }else{
                	alert(data.message);
                }
            }
        })
        return false;
    })
</script>
<script type="text/javascript">		
	   $(".downline").click(function () {
	   	var farm_id = $(this).attr('id');
	   	console.log(farm_id);
        $.ajax({
            url:"/api/v2/user/downline",
            type:"post",
            data:{farm_id:farm_id},
            success:function (data) {
                if(data.code==200){
                    alert(data.message);
                    location.href="/api/v2/user/user_release";              
                    return;
                }else{
                	alert(data.message);
                }
            }
        })
        return false;
    })
</script>
