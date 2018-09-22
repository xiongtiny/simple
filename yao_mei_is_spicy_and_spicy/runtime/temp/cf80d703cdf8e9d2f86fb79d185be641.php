<?php /*a:4:{s:84:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/order/review.html";i:1531205106;s:82:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/header.html";i:1531208860;s:80:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/main.html";i:1531208872;s:79:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/nav.html";i:1530604119;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<title>瑶妹麻辣后台管理系统</title>
		<meta name="keywords" />
		<meta name="description" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/static/assets/css/font-awesome.min.css" />
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<link rel="stylesheet" href="/static/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/static/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/static/assets/css/ace-skins.min.css" />
		  <link rel="stylesheet" href="/static/assets/css/ace-ie.min.css" />
		<script src="/static/assets/js/ace-extra.min.js"></script>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<!--layer-->
		<!-- <link rel="stylesheet" href="/static/assets/layer/layui.css">
		<script src="/static/assets/layer/layui.all.js"></script> -->
	</head>
<style>
    #table tr td{
        width:150px;
        height: 35px;
        text-align: center;
        color: black;
        font-family: "Adobe 楷体 Std R";
        font-size: 15px;
    }
</style>
<body>
<div class="navbar navbar-default" id="navbar" style="background :#b43e3a; height: 5%;">
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-flag"></i>
							瑶妹麻辣后台管理系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background:#b43e3a;">
								<img class="nav-user-photo" width="30"  src="/static/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info" style="background:#b43e3a;">
									<small>欢迎光临,</small>
									<?php echo htmlentities(app('session')->get('name')); ?>
								</span>
								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?php echo url('/admin/v1/index/logout'); ?>">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>



            <ul class="nav nav-list">

	<li class="active">
		<a href="/admin/v1/index/index">
			<i class="icon-home"></i>
			<span class="menu-text"> 首页 </span>
		</a>
	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-truck"></i>
			<span class="menu-text">商品管理 </span>

			<b class="arrow icon-angle-down"></b>
		</a>
		<!--<?php if(stripos(request()->url(),'/admin/v1/admin')!==false): ?>style='display:block;'<?php endif; ?>-->
		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/goods')!==false): ?> style='display:block'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/goods/lister'); ?>">
					<i class="icon-double-angle-right"></i>
					商品列表
				</a>
			</li>
			<li>
				<a href="<?php echo url('/admin/v1/goods/add'); ?>">
					<i class="icon-double-angle-right"></i>
					添加商品
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-shopping-cart"></i>
			<span class="menu-text">订单管理 </span>

			<b class="arrow icon-angle-down"></b>
		</a>

		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/order')!==false): ?>style='display:block'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/order/orderlist'); ?>">
					<i class="icon-double-angle-right"></i>
					订单列表
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-group"></i>
			<span class="menu-text">用户管理 </span>

			<b class="arrow icon-angle-down"></b>
		</a>

		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/user')!==false): ?>style='display:block'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/user/userList'); ?>">
					<i class="icon-double-angle-right"></i>
					用户列表
				</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-legal"></i>
			<span class="menu-text"> 管理员管理</span>

			<b class="arrow icon-angle-down"></b>
		</a>

		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/admin')!==false): ?>style='display:block;'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/admin/oper'); ?>">
					<i class="icon-double-angle-right">	</i>
					管理员列表
				</a>
			</li>
			<li>
				<a href="<?php echo url('/admin/v1/admin/add'); ?>">
					<i class="icon-double-angle-right"></i>
					添加管理员
				</a>
			</li>
		</ul>
	</li>
</ul><!-- /.nav-list -->


            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>

        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="<?php echo url('/admin/v1/index/index'); ?>">首页</a>
                    </li>
                    <li class="active"> 订单详情</li>
                </ul><!-- .breadcrumb -->
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <form class="form-horizontal" role="form" action="/admin/v1/order/cheked?order_no=<?php echo htmlentities($orders->order_no); ?>" method="post" >
                                    <div class="form-group" style="position:relative;left:-170px; top: 410px;">
                                        <label class="col-sm-3 control-label no-padding-right" >审&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;核:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select class="form-control" name="status" style="width: 150px;">
                                            <option value="2">
                                                <?php if($status ==2): ?>待审状态
                                                <?php else: endif; ?>
                                            </option>
                                            <option value="3">已审核</option>
                                            <option value="4">已驳回</option>
                                        </select>
                                    </div>
                                    <table border="2px" id="table">
                                        <tr>
                                            <td >订单编号:</td>
                                            <td colspan="2"><?php echo htmlentities($orders->order_no); ?></td>
                                            <td >电&nbsp;&nbsp;&nbsp;话:</td>
                                            <td colspan="2"><?php echo htmlentities($orders->phone); ?></td>
                                        </tr>
                                        <tr>
                                            <td>购买用户:</td>
                                            <td colspan="2"><?php echo htmlentities($orders->get_user->name); ?></td>
                                            <td>收货人:</td>
                                            <td colspan="2"><?php echo htmlentities($orders->consignee); ?></td>
                                        </tr>
                                        <tr>
                                            <td>商品名称</td>
                                            <td>商品数量</td>
                                            <td>商品价格</td>
                                            <td>总代价格</td>
                                            <td>商品总价</td>
                                            <td>总代总价</td>
                                        </tr>
                                        <?php foreach($arr as $a): ?>
                                        <tr>
                                            <td><?php echo htmlentities($a->get_name->name); ?></td>
                                            <td><?php echo htmlentities($a->sum); ?></td>
                                            <td><?php echo htmlentities($a->price); ?></td>
                                            <td><?php echo htmlentities($a->gen_price); ?></td>
                                            <td><?php echo htmlentities($a->total_price); ?></td>
                                            <td><?php echo htmlentities($a->gen_total_price); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td >快递方式:</td>
                                            <td colspan="2">
                                                <?php if($orders->log_type == 1): ?>顺丰空运
                                                <?php elseif($orders->log_type == 2): ?>顺丰陆运
                                                <?php else: ?>普通物流
                                                <?php endif; ?>
                                            </td>
                                            <td >邮&nbsp;&nbsp;&nbsp;&nbsp;费：</td>
                                            <td colspan="2"><?php echo htmlentities($orders->postage); ?></td>
                                        </tr>
                                        <tr>
                                            <td >订单商品总数:</td>
                                            <td colspan="2"><?php echo htmlentities($orders->sum); ?></td>
                                            <td >订单总价：</td>
                                            <td colspan="2"><?php echo htmlentities($orders->price); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">收货地址：</td>
                                            <td colspan="4"><?php echo htmlentities($orders->get_pro->name); ?>-<?php echo htmlentities($orders->get_city->name); ?>-<?php echo htmlentities($orders->get_area->name); ?>-<?php echo htmlentities($orders->address_deta); ?></td>
                                        </tr>
                                    </table>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="btn btn-info" type="submit">
                                                <i class="icon-ok bigger-110"></i>
                                                提交
                                            </button>
                                        </div> </div>
                                </form>
                            </div>
                        </div>
                    </div><!--col-xs-12-->
                </div><!--row-->
            </div><!--page-content-->

        </div>



        <div class="hr hr32 hr-dotted"></div>


        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->

</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<!-- basic scripts -->


<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='__ROOT__/static/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='__ROOT__/static/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="__ROOT__/static/assets/js/bootstrap.min.js"></script>
<script src="__ROOT__/static/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->

<script src="__ROOT__/static/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="__ROOT__/static/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="__ROOT__/static/assets/js/jquery.slimscroll.min.js"></script>
<script src="__ROOT__/static/assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="__ROOT__/static/assets/js/jquery.sparkline.min.js"></script>
<script src="__ROOT__/static/assets/js/flot/jquery.flot.min.js"></script>
<script src="__ROOT__/static/assets/js/flot/jquery.flot.pie.min.js"></script>
<script src="__ROOT__/static/assets/js/flot/jquery.flot.resize.min.js"></script>

<!-- ace scripts -->

<script src="__ROOT__/static/assets/js/ace-elements.min.js"></script>
<script src="__ROOT__/static/assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    jQuery(function($) {
        $('.easy-pie-chart.percentage').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                size: size
            });
        })

        $('.sparkline').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
            $(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
        });




        var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
        var data = [
            { label: "social networks",  data: 38.7, color: "#68BC31"},
            { label: "search engines",  data: 24.5, color: "#2091CF"},
            { label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
            { label: "direct traffic",  data: 18.6, color: "#DA5430"},
            { label: "other",  data: 10, color: "#FEE074"}
        ]
        function drawPieChart(placeholder, data, position) {
            $.plot(placeholder, data, {
                series: {
                    pie: {
                        show: true,
                        tilt:0.8,
                        highlight: {
                            opacity: 0.25
                        },
                        stroke: {
                            color: '#fff',
                            width: 2
                        },
                        startAngle: 2
                    }
                },
                legend: {
                    show: true,
                    position: position || "ne",
                    labelBoxBorderColor: null,
                    margin:[-30,15]
                }
                ,
                grid: {
                    hoverable: true,
                    clickable: true
                }
            })
        }
        drawPieChart(placeholder, data);

        /**
         we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
         so that's not needed actually.
         */
        placeholder.data('chart', data);
        placeholder.data('draw', drawPieChart);



        var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
        var previousPoint = null;

        placeholder.on('plothover', function (event, pos, item) {
            if(item) {
                if (previousPoint != item.seriesIndex) {
                    previousPoint = item.seriesIndex;
                    var tip = item.series['label'] + " : " + item.series['percent']+'%';
                    $tooltip.show().children(0).text(tip);
                }
                $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
            } else {
                $tooltip.hide();
                previousPoint = null;
            }

        });






        var d1 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d1.push([i, Math.sin(i)]);
        }

        var d2 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d2.push([i, Math.cos(i)]);
        }

        var d3 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.2) {
            d3.push([i, Math.tan(i)]);
        }


        var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
        $.plot("#sales-charts", [
            { label: "Domains", data: d1 },
            { label: "Hosting", data: d2 },
            { label: "Services", data: d3 }
        ], {
            hoverable: true,
            shadowSize: 0,
            series: {
                lines: { show: true },
                points: { show: true }
            },
            xaxis: {
                tickLength: 0
            },
            yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
            },
            grid: {
                backgroundColor: { colors: [ "#fff", "#fff" ] },
                borderWidth: 1,
                borderColor:'#555'
            }
        });


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('.tab-content')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }


        $('.dialogs,.comments').slimScroll({
            height: '300px'
        });


        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
            $('#tasks').on('touchstart', function(e){
                var li = $(e.target).closest('#tasks li');
                if(li.length == 0)return;
                var label = li.find('label.inline').get(0);
                if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
            });

        $('#tasks').sortable({
                opacity:0.8,
                revert:true,
                forceHelperSize:true,
                placeholder: 'draggable-placeholder',
                forcePlaceholderSize:true,
                tolerance:'pointer',
                stop: function( event, ui ) 
            }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
            if(this.checked) $(this).closest('li').addClass('selected');
            else $(this).closest('li').removeClass('selected');
        });


    })
</script>

</body>
</html>

