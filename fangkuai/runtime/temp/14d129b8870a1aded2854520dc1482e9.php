<?php /*a:1:{s:80:"D:\phpstudy\PHPTutorial\WWW\fangkuai\application\index\view\v2\farm\publish.html";i:1526433135;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>发布农场</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">
	<link rel="stylesheet" href="/phone/css/font-awesome.css">
<!-- 	<link href="/phone/css/layout.min.css" rel="stylesheet" /> -->
    <link href="/phone/css/scs.min.css" rel="stylesheet" />
	<script src="/phone/jq/jquery.min.js"></script>
    <script src="/phone/jq/jquery.scs.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/phone/css/mui.picker.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>
    <form action=""  id="form" enctype="multipart/form-data">  
	<div class="publish">
		<div class="publish_up">
			<div class="publish_1">
				<label for="">农场名称&nbsp;:&nbsp;</label>
				<input type="text" name="name" class="form-control_style_3" placeholder="取个独特的名字让更多人发现你的农场">
			</div>
            <div class="publish_1">
                <label for="">所在地区&nbsp;:&nbsp;</label>        
                <button type="button" id="origin"  class="form-control_style_3" style="text-align: left" >请选择农场所在地区</button>
                  <input type="hidden" name="province" value="" id="origin_province">
                  <input type="hidden" name="city" value="" id="origin_city">
                  <input type="hidden" name="area" value="" id="origin_area">
            </div>			
			<div class="publish_1">
				<label for="">具体地址&nbsp;:&nbsp;</label>
				<input type="text" name="address" class="form-control_style_3" placeholder="请填写农场具体地址">
			</div>
			<div class="publish_1">
				<label for="">联系电话&nbsp;:&nbsp;</label>
				<input type="text" name="phone" class="form-control_style_3" placeholder="请填写联系方式">
			</div>
			<div class="publish_1">
				<label for="">设备编号&nbsp;:&nbsp;</label>
				<input type="text" name="equipment_number" class="form-control_style_3" placeholder="请填写设备编号">
			</div>
			<div class="publish_1">
				<label for="">农场面积&nbsp;:&nbsp;</label>
				<input type="text" name="acreage" class="form-control_style_3" placeholder="请填写该农场面积(默认m²)">
			</div>
			<div class="publish_1">
				<label for="">价格设定&nbsp;:&nbsp;</label>                
				<input type="text" name="price" class="form-control_style_3" placeholder="请填写价格(单位默认元)">
			</div>
			<div class="publish_1">
				<label for="">价格单位&nbsp;:&nbsp;</label>
                <select  name="lease_type" class="form-control_style_3">
                    <option value="1">半年</option>
                    <option value="2">一年</option>
                    <option value="3">一季</option>
                    <option value="4">一月</option>                    
                </select>
			</div>
			<div class="publish_1">
				<label for="">提供服务&nbsp;:&nbsp;</label>
                <?php foreach($data as $k => $v): ?>
    			<input type="checkbox" value="<?php echo htmlentities($v['id']); ?>" name="service[]"><label for="1"><?php echo htmlentities($v['name']); ?></label>
                <?php endforeach; ?>				
			</div>
			<div class="publish_2">
				<label for="">其他描述&nbsp;:&nbsp;</label>
				<textarea name="describe" id="" cols="30" rows="10" class="form-control_style_2" placeholder="场地长宽、风貌、适合作物"></textarea>
			</div>
            <!-- 图片上传 -->
            <div class="publish_3">
                <em style="width: 200px;display: block;position: absolute;">
                <input type="file" id="file" style="display:none;" onchange="filechange(event)" name="img" value="" />
                <img src="/phone/image/upload.png" style="height: 80px; width: 140px;" id="img-change">
            </em>
        </div>		

			<div class="publish_4">
				<input type="checkbox" checked="checked" class="publish_checkbox"><label for="">我已阅读<a href="#">发布农场规则及其责任告知书</a>，并遵守相关规则</label>
			</div>

		</div>
		<div class="publish_down"><button type="button" class="publish_button" onclick="input()">确认</button></div>
	</div>
     </form>
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
        var url="/api/v2/farm/add_farm";
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
                if (data.code == 400) {
                    alert(data.message);
                    
                }
                if (data.code == 200) {
                    alert(data.message);
                    window.location.href="/api/v2/user/user_release"
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