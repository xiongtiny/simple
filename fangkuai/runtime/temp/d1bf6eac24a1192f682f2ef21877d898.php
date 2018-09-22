<?php /*a:1:{s:72:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\farm\farm_detail.html";i:1526368753;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>农场详情</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>
	<div class="detail">
		
		<div class="detail_top">
			<div class="detail_video">
				<video src="<?php echo htmlentities($data1['hdAddress']); ?>" width="100%" height="170px" style="background-color: #000000;"></video> 
			</div>
			<div class="detail_top_text">
				<div class="detail_top_name">
					<span class=""><?php echo htmlentities($data['name']); ?></span>
					<span class="detail_top_money"><span class="detail_top_money1"><?php echo htmlentities($data['price']); ?></span>元/<?php switch($data['lease_type']): case "1": ?>年<?php break; case "2": ?>半年<?php break; case "3": ?>季<?php break; case "4": ?>月<?php break; default: endswitch; ?></span>
				</div>
				<div class="detail_top_area">面积&nbsp;:&nbsp;<?php echo htmlentities($data['acreage']); ?>m²</div>
				<div class="detail_top_button">
					<?php foreach($data['service'] as $v): ?>
						<button  class="farmlive_button1"><?php echo htmlentities($v); ?></button>
						<?php endforeach; ?>
					
				</div>
			</div>
		</div>

		<div class="detail_address">
			<div class="detail_address1">详细地址&nbsp;:&nbsp;<?php echo htmlentities($data['province']); ?><?php echo htmlentities($data['city']); ?><?php echo htmlentities($data['area']); ?><?php echo htmlentities($data['address']); ?></div>
			<div class="detail_address1">农场主电话&nbsp;:&nbsp;<?php echo htmlentities($data['phone']); ?></div>
		</div>

		<div class="detail_depict">
			<div class="farmlive_top_title"><span class="course_top">•</span><span class="course_title">其他描述</span><span class="course_top">•</span></div>
			<div class="detail_depict1">
				<?php echo htmlentities($data['describe']); ?>
			</div>
		</div>
		<div class="detail_button"><button class="detail_button1"><span class="detail_button_text">立即租赁</span></button></div>

		


	</div>
</body>
</html>