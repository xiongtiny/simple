<?php /*a:1:{s:66:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\user\trade.html";i:1526287008;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>交易记录</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">
	<script src="/static/layui/layui.all.js"></script>
   	<link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
</head>
<body>
	<div class="trade">
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
	<div class="trade_1">
			<div class="trade_time"><?php echo htmlentities($vo['create_time']); ?></div>
			<div class="trade_main">
				<label for="">订单号&nbsp;:&nbsp;</label><span class="trade_num"><?php echo htmlentities($vo['order_number']); ?></span><br><br>
				<label for="">交易内容&nbsp;:&nbsp;</label><span class="trade_text"><?php echo htmlentities($vo['type']); ?>———<?php echo htmlentities($vo['farm_name']); ?></span><br><br>
				<label for="">交易金额&nbsp;:&nbsp;</label><span class="trade_num"><?php echo htmlentities($vo['price']); ?></span>
			</div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<!-- <div class="tab-content" class="add_list" id='add_list'>
  </div> -->
<!-- 加载更多 -->
<!-- <script type="text/javascript">

var page=0;
layui.use('flow', function(){
  var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
  var flow = layui.flow;
  flow.load({
    elem: '#add_list' //指定列表容器
    ,scrollElem: '#add_list'
    ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
      var lis = [];
      //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
      $.get("/api/v2/user/trade", function(res){
	        //假设你的列表返回在data集合中
	       var pages=res.pages;
	       var data=res.data;
	       var length=res.data.length;
	       console.log(data);
	       var lis = [];
  	  if(res.data){
	 			var num = res.data.length;
	 			for(var i=0;i<num;i++){	 				
	 				var id=data[i].id;
	 				var order_number=data[i].order_number;
	 		 		var create_time=data[i].create_time;
	 		 		var type=data[i].type;
	 		 		var farm_id=data[i].farm_id;
	 		 		var price=data[i].price;
	            	// var res1="<div class='trade_1'>";
	            	
	            	$('#add_list').before(res);
	            }
	 			 next(lis.join(''), page < pages);
  	  }
    });
    page++;
  }
});
});
</script> -->
</body>
</html>