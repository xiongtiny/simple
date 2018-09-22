<?php /*a:2:{s:67:"/home/wwwroot/fangkuai/application/index/view/v1/farm/add_farm.html";i:1526446725;s:65:"/home/wwwroot/fangkuai/application/index/view/v1/public/head.html";i:1526446725;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>农场发布</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css">
		<link rel="stylesheet" href="/static/css/style_1.css">
		<link rel="stylesheet" href="/static/css/font-awesome.css">
		<link rel="stylesheet" href="/static/css/awesome-bootstrap-checkbox.css">
		<link href="/static/css/bootstrap-fileinput.css" rel="stylesheet">
	
		<link rel="stylesheet" href="/static/css/basic.css">
			<script src="/static/jq/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<script src="/static/js/distpicker.data.js"></script>
	<script src="/static/js/distpicker.js"></script>
	<script src="/static/js/main.js"></script>

		    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <!--  	<script src="/static/js/style.js"></script> -->
			<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=d1rjXUM25YuupoH4ukBYrLzVkvY9bWmF"></script>
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
					<a style="text-decoration: none;"  class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>




	<div class="bottom_6">
		<form action="/index.php/api/v1/farm/add_farm"  method="post" onsubmit="return check()" >
		<div class="container bottom_6_rim">农场发布<br><br>
		<div class="bottom_6_color bottom_6_1">
			<div><!-- 左侧表单 -->
			
				
				<div class="form-group">
					<label for="">农场名称&nbsp;</label>
					<input type="text" name="name" id="name" class="form-control_style" placeholder="取个独特的名字，让更多人发现你的农场">
					
						
				</div>
				<div class="form-group bottom_6_1">
					<label for="" style="margin-top: 5px;">所在地区&nbsp;&nbsp;</label>
							<div data-toggle="distpicker" class="bottom_6_1">
								<select class="form-control" id="province1" name="province"></select>
								<label for="province1" style="margin-top: 5px;">&nbsp;省&nbsp;</label>
								<select class="form-control" id="city1" name="city"></select>
								<label for="city1" style="margin-top: 5px;">&nbsp;市&nbsp;</label>
								<select class="form-control" id="district1" name="area"></select>
								<label for="district1" style="margin-top: 5px;">&nbsp;区&nbsp;</label>
						    </div>
						
				</div>
				<div class="form-group">
					<label for="">具体地址&nbsp;</label>
					<input id="address" name="address" type="text" class="form-control_style" placeholder="请填写农场的具体位置"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="prompt">在右侧地图标注详细位置</span>
						
				</div>
				<div  class="form-group">
					<label  for="">联系电话&nbsp;</label>
					<input id="phone" name="phone" type="text" class="form-control_style" placeholder="买主付费后可联系你">
						
				</div>
				<div class="form-group">
					<label  for="">设备编号&nbsp;</label>
					<input id="number" name="equipment_number" type="text" class="form-control_style" placeholder="添加摄像头编号">
						
				</div>
				<div class="form-group" >
					<label  for="">农场面积&nbsp;</label>
					<input id="area" name="acreage" type="text" class="form-control_style_4" placeholder="该农场面积">&nbsp;m²
						
				</div>
				<div class="form-group" >
					<label  for="">价格设定&nbsp;</label>
					<input id="price" name="price" type="text" class="form-control_style" placeholder="填写价格" style="width: 58%;">
					&nbsp;元&nbsp;/&nbsp;
					<select name="lease_type" id="lease_type" class="form-control_style" style="width: 15%;">
					<option value="1">年</option>
					<option value="2">半年</option>
					<option value="3">季度</option>
					<option value="4">月</option>
					</select>	
					
						
				</div>
				<div  class="form-group">
					<label for="">提供服务&nbsp;</label>
					<input name="service" id="service" type="checkbox" value="1">
					<label for="">&nbsp;按需种植&nbsp;</label>
					<input name="service" id="service" type="checkbox" value="2">
					<label for="">&nbsp;随时来访&nbsp;</label>
					<input name="service" id="service" type="checkbox" value="3">
					<label for="">&nbsp;送货上门&nbsp;</label>
						
				</div>
				<div class="form-group bottom_6_1">
					<label  for="">其他描述&nbsp;</label>
					<div><textarea name="" id="" cols="30" rows="10" class="form-control_style_1" placeholder="场地长宽、周围气候风貌、人情风俗、适合的作物种类"></textarea></div>
						
				</div>

				<p><input id="protocol" class="styled" type="checkbox">我已阅读<a href="" style="color:#67bdee;">发布农场规则及其责任告知书</a>，并遵守相关规则</p>
				<button onclick="input()" type="button" class="bottom_6_2">确认发布</button>
			
			</div>

			<div>
					<div id="map_3" style="width: 400px;height: 350px;"><!-- 地图定位 -->	
					</div>


					<div class="avatar">

            <div class="form-group" id="uploadForm" enctype='multipart/form-data'>
                <div class="h4">上传农场照片</div>
                <div class="fileinput fileinput-new" data-provides="fileinput"  id="exampleInputUpload">
                    <div class="fileinput-new thumbnail" style="width: 300px;height:150px;">
                        <img id='picImg' style="max-width: 100%;max-height: 100%;" src="/static/image/noimage.png" alt="" />
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 300px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-primary btn-file">
                            <span class="fileinput-new">选择文件</span>
                            <span class="fileinput-exists">换一张</span>
                            <input type="file" name="img" id="picID" accept="/static/image/gif,image/jpeg,image/x-png">
                        </span>
                        <a href="javascript:;" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">移除</a>
                    </div>
                </div>
            </div>


                    </div>

			</div>
			</form>

			<div>
				
			</div>

			</div>
		</div>

	</div>
	
	<!-- 	翻页 -->











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
    // 百度地图API功能
    var map = new BMap.Map("map_3");
    var point = new BMap.Point(116.331398,39.897445);
    map.centerAndZoom(point,12);
    map.enableScrollWheelZoom(true);
    var geoc = new BMap.Geocoder();    

    map.addEventListener("click", function(e){        
        var pt = e.point;
        geoc.getLocation(pt, function(rs){
            var addComp = rs.addressComponents;
            // alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
            document.getElementById("address").value = addComp.city+','+addComp.district+','+addComp.street+','+addComp.streetNumber;
        });        
    });
 
	</script>
		<script type="text/javascript">
    $(function () {
        //比较简洁，细节可自行完善
        $('#uploadSubmit').click(function () {
            var data = new FormData($('#uploadForm')[0]);
            $.ajax({
                url: '/index.php/api/v1/farm/add_farm',
                type: 'POST',
                data:{
                	img:data,
                },
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if(data.status){
                        console.log('upload success');
                    }else{
                        
                    }
                },
                error: function (data) {
                   
                }
            });
        });

    })
</script>

	<script src="/static/js/bootstrap-fileinput.js"></script>

<script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.js"></script>
<script>
 

	function input() {
	  $.ajax({ 
		    type: "post", 	
			url: "/index.php/api/v1/farm/add_farm",
			data: {
				name:$("#name").val(),
                province:$("#province1").val(),
                city:$("#city1").val(),
                area:$("#district1").val(),
                address:$("#address").val(),
                phone: $("#phone").val(), 
                equipment_number:$("#number").val(),
                acreage:$("#area").val(),
                price:$("#price").val(),
                lease_type:$("#lease_type").val(),
                service:$("#service").val(),

			},
			
			success: function(data) {
				if(data.code==400){
					alert(data.message)

				}
				if(data.code==200){
				    alert(data.message)
				}
			},
			error: function(jqXHR){     
			   alert("发生错误：" + jqXHR.status);  
			},     
		});
	}
		
</script>
</body>
</html>