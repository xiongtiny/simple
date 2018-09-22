<?php /*a:3:{s:69:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\farm\add_farm.html";i:1526462267;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526437494;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526435605;}*/ ?>
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
	<script src="/static/js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="/phone/css/mui.picker.css">
	<script src="/phone/jq/jquery.min.js"></script>
	<script src="/phone/jq/jquery.scs.min.js"></script>

		    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <!--  	<script src="/static/js/style.js"></script> -->
			<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7VPQYgQRsPCQ1POSV4i4fW0uYNVoy0Pu"></script>
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
		<form action=""  id="form" enctype="multipart/form-data">
		<div class="container bottom_6_rim">农场发布<br><br>
		<div class="bottom_6_color bottom_6_1">
			<div><!-- 左侧表单 -->
			
				
				<div class="form-group">
					<label for="">农场名称&nbsp;</label>
					<input type="text" name="name" id="name" class="form-control_style" placeholder="取个独特的名字，让更多人发现你的农场">
					
						
				</div>
				<div class="form-group">
					<label for="">所在地区&nbsp;</label>
					<button type="button" id="origin"  class="form-control_style" style="text-align: left" >请选择农场所在地区</button>
					<input type="hidden" name="province" value="" id="origin_province">
					<input type="hidden" name="city" value="" id="origin_city">
					<input type="hidden" name="area" value="" id="origin_area">
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
					<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
					<input name="service[]" id="service" type="checkbox" value="<?php echo htmlentities($vo['id']); ?>">
					<label for="">&nbsp;<?php echo htmlentities($vo['name']); ?>&nbsp;</label>

					<?php endforeach; endif; else: echo "" ;endif; ?>
						
				</div>
				<div class="form-group bottom_6_1">
					<label  for="">其他描述&nbsp;</label>
					<div><textarea name="describe" id="" cols="30" rows="10" class="form-control_style_1" placeholder="场地长宽、周围气候风貌、人情风俗、适合的作物种类"></textarea></div>
						
				</div>

				<p><input id="protocol" class="styled" type="checkbox" checked="checked">我已阅读<a href="" style="color:#67bdee;">发布农场规则及其责任告知书</a>，并遵守相关规则</p>
				<button type="button" class="bottom_6_2" onclick="input()">确认</button>

			</div>

			<div>
					<div id="map_3" style="width: 400px;height: 350px;"><!-- 地图定位 -->
					</div>

				<div class="avatar">
					<div class="publish_3">
						<em style="width: 200px;display: block;position: absolute;">
						</em>
					</div>
					<div class="form-group">
                <div class="h4">上传农场照片</div>

                    <div class="fileinput-new thumbnail" style="width: 300px;height:150px;">
                        <img style="max-width: 100%;max-height: 100%;" src="/static/image/noimage.png" id="img-change" />
                    </div>
				<input type="file" id="file" style="display:none;" onchange="filechange(event)" name="img" value="" />


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
    //添加比例尺控件
    var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
    var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
    var top_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}); //右上角，仅包含平移和缩放按钮
    //展示比例尺
    map.addControl(top_left_control);
    map.addControl(top_left_navigation);
    map.addControl(top_right_navigation);
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
<script src="/phone/js/data.city.js"></script>
<script src="/phone/js/jquery-1.9.1.js"></script>
<script src="/phone/js/mui.min.js"></script>
<script src="/phone/js/mui.picker.min.js"></script>
<script type="text/javascript">
    //选择省市区
    var city_picker = new mui.PopPicker({layer:3});
    city_picker.setData(init_city_picker);
    //籍贯
    $("#origin").on("tap", function(){
        setTimeout(function(){
            city_picker.show(function(items){
                $("#origin_province").val((items[0] || {}).text);
                $("#origin_city").val((items[1] || {}).text);
                $("#origin_area").val((items[2] || {}).text);
                //该ID为接收城市ID字段
                $("#origin").html((items[0] || {}).text + " " + (items[1] || {}).text + " " + (items[2] || {}).text);
            });
        },200);
    });
</script>
<script>
    //	图片上传
    $(function(){

    })

    $("#img-change").click(function () {
        $("#file").click();
    })

	/*$("#file").change(function (event) {*/
    function filechange(event){
        var files = event.target.files, file;
        if (files && files.length > 0) {
            // 获取目前上传的文件
            file = files[0];// 文件大小校验的动作
            if(file.size > 1024 * 1024 * 2) {
                alert('图片大小不能超过 2MB!');
                return false;
            }
            // 获取 window 的 URL 工具
            var URL = window.URL || window.webkitURL;
            // 通过 file 生成目标 url
            var imgURL = URL.createObjectURL(file);
            //用attr将img的src属性改成获得的url
            $("#img-change").attr("src",imgURL);
            // 使用下面这句可以在内存中释放对此 url 的伺服，跑了之后那个 URL 就无效了
            // URL.revokeObjectURL(imgURL);
        }
    };
</script>

<script type="text/javascript">
    function input(){
        var url="/api/v1/farm/add_farm";
        var data = new FormData($("#form")[0]);
        $.ajax({
            url: url,
            type: "post",
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if (data.code == 400) {
                    alert(data.message);
                }
                if (data.code == 200) {
                    alert(data.message);
                    window.location.href="/api/v1/user/user_release";
                }

            }
        })
    }
    //     $("form").click(function () {

    //     return false;
    // })
</script>
</body>
</html>