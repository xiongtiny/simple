<?php /*a:4:{s:65:"D:\working\Test\ymml\application\admin\view\v1\user\userlist.html";i:1529549528;s:62:"D:\working\Test\ymml\application\admin\view\v1\Inc\header.html";i:1529549528;s:60:"D:\working\Test\ymml\application\admin\view\v1\Inc\main.html";i:1529549528;s:59:"D:\working\Test\ymml\application\admin\view\v1\Inc\nav.html";i:1529549528;}*/ ?>

<html lang="en">
<head>
		<meta charset="utf-8" />
		<title>瑶妹麻辣后台管理</title>
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
	</head>
<body>
<div class="navbar navbar-default" id="navbar" style="background :lightskyblue; height: 5%;">
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-flag"></i>
							瑶妹麻辣后台管理
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background:lightskyblue;">
								<img class="nav-user-photo" width="30"  src="/static/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info" style="background:lightskyblue;">
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
			<i class="icon-dashboard"></i>
			<span class="menu-text"> 控制台 </span>
		</a>
	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-bullhorn"></i>
			<span class="menu-text">商品管理 </span>

			<b class="arrow icon-angle-down"></b>
		</a>
		<!--<?php if(stripos(request()->url(),'/admin/v1/admin')!==false): ?>style='display:block;'<?php endif; ?>-->
		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/goods')!==false): ?> style='display:block'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/goods/add'); ?>">
					<i class="icon-double-angle-right"></i>
					添加商品
				</a>
			</li>
			<li>
				<a href="<?php echo url('/admin/v1/goods/lister'); ?>">
					<i class="icon-double-angle-right"></i>
					商品列表
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="<?php echo url('/admin/v1/index/index'); ?>" class="dropdown-toggle">
			<i class="icon-info-sign"></i>
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
			<i class="icon-info-sign"></i>
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
			<i class=" icon-eye-open"></i>
			<span class="menu-text"> 管理员管理</span>

			<b class="arrow icon-angle-down"></b>
		</a>

		<ul class="submenu" <?php if(stripos(request()->url(),'/admin/v1/admin')!==false): ?>style='display:block;'<?php endif; ?>>
			<li>
				<a href="<?php echo url('/admin/v1/admin/add'); ?>">
					<i class="icon-double-angle-right"></i>
					添加管理员
				</a>
			</li>
			<li>
				<a href="<?php echo url('/admin/v1/admin/oper'); ?>">
					<i class="icon-double-angle-right">	</i>
					管理员列表
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
                    <li class="active">用户列表</li>
                </ul><!-- .breadcrumb -->
            </div>

            <div class="page-content">
                <div class="row" style="margin: 0;">
                        <form action="" method="post">
                            <div>名称:
                                <input type="text" name="name" >
                                <button type="submit">搜索</button>
                            </div>
                        </form>
                        <form action="/admin/v1/user/excel" method="post">
                            <div style="position: relative; left: 300px; top: -40px;">
                                <input type="text" name="name" placeholder="代理关系表" >
                                <button type="submit">导出</button>
                            </div>
                        </form>
                    <div class="page-content">
                    <div style="position:relative; top: -50px; left: -10px">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="font-size: 12px;">
                            <thead style="font-size: 10px;">
                            <tr>
                                <th class="center">用户名称</th>
                                <th class="center">用户手机号</th>
                                <th class="center">身份证</th>
                                <th class="center">性别</th>
                                <th class="center">推荐人</th>
                                <th class="center">总代</th>
                                <th class="center">下级代理</th>
                                <th class="center">地址</th>
                                <th class="center">等级</th>
                                <th class="center">审核状态</th>
                                <th class="center">操作</th>
                            </tr>
                            </thead>

                            <tbody>
                      <?php foreach($users as $user): ?>
                            <tr>
                                <td align="center"><?php echo htmlentities($user->name); ?></td>
                                <td align="center"><?php echo htmlentities($user->phone); ?></td>
                                <td align="center"><?php echo htmlentities($user->id_card); ?></td>
                                <td align="center">
                                    <?php if($user->sex ==1): ?>男
                                    <?php elseif($user->sex ==2): ?>女
                                    <?php else: ?>保密
                                    <?php endif; ?>
                                   </td>
                                <td align="center">
                                     <?php if(empty($user->get_rec_name->name)): ?>无
                                     <?php else: ?>
                                     <?php echo htmlentities($user->get_rec_name->name); endif; ?>
                                </td>
                                <td align="center">
                                     <?php if(empty($user->get_gen_name->name)): ?>无
                                     <?php else: ?>
                                     <?php echo htmlentities($user->get_gen_name->name); endif; ?>
                                 </td>
                                <td align="center">
                                    <a href="/admin/v1/user/lowerRank?id=<?php echo htmlentities($user->id); ?>">查看</a>
                                </td>
                                <td align="center">
                                      <?php if(empty($user->getPro->id)): ?>无
                                      <?php elseif(empty($user->getCity->id)): ?>无
                                      <?php elseif(empty($user->getArea->id)): ?>无
                                     <?php else: ?> <?php echo htmlentities($user->get_pro->name); ?>-<?php echo htmlentities($user->get_city->name); ?>-<?php echo htmlentities($user->get_area->name); ?>-<?php echo htmlentities($user->address_deta); endif; ?>
                                   </td>
                                <td align="center">
                                    <?php if($user->grade ==1): ?>总代
                                    <?php else: ?>一级代理
                                    <?php endif; ?>
                                    </td>
                                <td align="center">
                                     <?php if($user->status == 1): ?>已通过
                                      <?php elseif($user->status == 2): ?>未通过
                                       <?php else: ?>待审
                                      <?php endif; ?>
                                    </td>
                                  <td style="text-align: center">
                                      <a href="/admin/v1/user/addSpecial?id=<?php echo htmlentities($user->id); ?>">添加特价商品</a>
                                      |
                                      <a href="/admin/v1/user/specialList?id=<?php echo htmlentities($user->id); ?>">查看特价商品</a>
                                  </td>
                            </tr>
                         <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
    window.jQuery || document.write("<script src='/static/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="/static/assets/js/bootstrap.min.js"></script>
<script src="/static/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->

<script src="/static/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/static/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="/static/assets/js/jquery.slimscroll.min.js"></script>
<script src="/static/assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="/static/assets/js/jquery.sparkline.min.js"></script>
<script src="/static/assets/js/flot/jquery.flot.min.js"></script>
<script src="/static/assets/js/flot/jquery.flot.pie.min.js"></script>
<script src="/static/assets/js/flot/jquery.flot.resize.min.js"></script>

<!-- ace scripts -->

<script src="/static/assets/js/ace-elements.min.js"></script>
<script src="/static/assets/js/ace.min.js"></script>

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

