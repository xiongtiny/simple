<?php /*a:4:{s:81:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/goods/add.html";i:1531208823;s:82:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/header.html";i:1531208860;s:80:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/main.html";i:1531208872;s:79:"/home/wwwroot/yao_mei_is_spicy_and_spicy/application/admin/view/v1/Inc/nav.html";i:1530604119;}*/ ?>
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
<body>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="/static/assets/upload_img/jquery.min.js"></script>
<script src="/static/assets/upload_img/amazeui.min.js"></script>
<script src="/static/assets/upload_img/app.js"></script>
<link href="/static/assets/upload_img/fsgallery.css" rel="stylesheet" />
<script type="text/javascript">
      function previewImage3(file)
        {
          var MAXWIDTH  = 118; 
          var MAXHEIGHT = 118;
          var div = document.getElementById('preview3');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead3 onclick=$("#previewImg3").click()>';
              var img = document.getElementById('imghead3');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead3>';
            var img = document.getElementById('imghead3');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
        }

    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight ){
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;
            
            if( rateWidth > rateHeight ){
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else{
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>
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

            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- #sidebar-shortcuts -->

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
                    <li class="active">添加商品</li>
                </ul><!-- .breadcrumb -->
            </div>

            <div class="page-content">

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <form class="form-horizontal" role="form" action="<?php echo url('/admin/v1/goods/save'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="subject"> 产品名称： </label>

                                <div class="col-sm-9">
                                    <input type="text" id="subject" name="name" placeholder="请输入商品名" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="subject"> 产品图片： </label>

                                <div class="col-sm-9">
                                    <input type="file" id="subject" name="img" class="col-xs-10 col-sm-5" />
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="subject"> 产品图片： </label>
                                <div class="col-sm-9" style="margin-top: 5px; float: left;">
                                    <div  style="height:120px;width: 120px; border:1px solid #b43e3a; text-align: center">
                                        <div id="preview3" style="">
                                            <img id="imghead3" border="0" src="/static/assets/upload_img/upload-img.png" width="50px"  onclick="$('#previewImg3').click();" style="padding-top: 30px;">
                                        </div>
                                        <input type="file" name="img" value="" onchange="previewImage3(this)" style="display: none;" id="previewImg3">
                                    </div>
                                    <span>上传图片宽高比例请保持1:1</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">产品净重(克)：</label>

                                <div class="col-sm-9">
                                    <input type="text"  name="weight" placeholder="请输入产品净重量" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">零售价(元)：</label>

                                <div class="col-sm-9">
                                    <input type="text"  name="price" placeholder="请输入产品价格" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">批发价格(元)：</label>

                                <div class="col-sm-9">
                                    <input type="text"  name="whe_price" placeholder="请输入批发价格" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" >混批价格(元)：</label>

                                <div class="col-sm-9">
                                    <input type="text"  name="batch_price" placeholder="请输入混批价格" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" >总代价格(元)：</label>

                                <div class="col-sm-9">
                                    <input type="text"  name="gen_price" placeholder="请输入总代价格" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" >产品口味： </label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="category_id" name="flavor" style="width: 150px;">
                                        <option value="中辣">中辣</option>
                                        <option value="微辣">微辣</option>
                                        <option value="特辣">特辣</option>
                                        <option value="爆辣">爆辣</option>
                                    </select>
                                </div>
                            </div>
                                    <div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button class="btn btn-info" type="submit">
                                        <i class="icon-ok bigger-110"></i>
                                    确认
                                    </button>
                                    <a href="javascript:history.back(-1)"><button class="btn" type="button">
                                        <i class="icon-undo bigger-110"></i>
                                        返回
                                    </button></a>

                                    </div>
                                    </div>

                                    <div class="hr hr-24"></div>

                                        </form>
                                        </div><!-- /.main-content -->

                                    </div><!-- /.main-container-inner -->

                                    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                                        <i class="icon-double-angle-up icon-only bigger-110"></i>
                                        </a>
                                        </div><!-- /.main-container -->

                                        <!-- basic scripts -->

                                        <!--[if !IE]> -->

                                        <script type="text/javascript">
                                        window.jQuery || document.write("<script src='/static/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
                                    </script>

                                    <!-- <![endif]-->

                                    <!--[if IE]>
                                    <script type="text/javascript">
                                        window.jQuery || document.write("<script src='/static/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
                                    </script>
                                    <![endif]-->

                                    <script type="text/javascript">
                                        if("ontouchend" in document) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
                                    </script>
                                    <script src="/static/assets/js/bootstrap.min.js"></script>
                                    <script src="/static/assets/js/typeahead-bs2.min.js"></script>

                                    <!-- page specific plugin scripts -->

                                    <!--[if lte IE 8]>
                                    <script src="/static/assets/js/excanvas.min.js"></script>
                                    <![endif]-->

                                    <script src="/static/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
                                    <script src="/static/assets/js/jquery.ui.touch-punch.min.js"></script>
                                    <script src="/static/assets/js/chosen.jquery.min.js"></script>
                                    <script src="/static/assets/js/fuelux/fuelux.spinner.min.js"></script>
                                    <script src="/static/assets/js/date-time/bootstrap-datepicker.min.js"></script>
                                    <script src="/static/assets/js/date-time/bootstrap-timepicker.min.js"></script>
                                    <script src="/static/assets/js/date-time/moment.min.js"></script>
                                    <script src="/static/assets/js/date-time/daterangepicker.min.js"></script>
                                    <script src="/static/assets/js/bootstrap-colorpicker.min.js"></script>
                                    <script src="/static/assets/js/jquery.knob.min.js"></script>
                                    <script src="/static/assets/js/jquery.autosize.min.js"></script>
                                    <script src="/static/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
                                    <script src="/static/assets/js/jquery.maskedinput.min.js"></script>
                                    <script src="/static/assets/js/bootstrap-tag.min.js"></script>
                                    <script src="/static/assets/js/markdown/markdown.min.js"></script>
                                    <script src="/static/assets/js/markdown/bootstrap-markdown.min.js"></script>
                                    <script src="/static/assets/js/jquery.hotkeys.min.js"></script>
                                    <script src="/static/assets/js/bootstrap-wysiwyg.min.js"></script>
                                    <script src="/static/assets/js/bootbox.min.js"></script>

                                    <!-- ace scripts -->

                                    <script src="/static/assets/js/ace-elements.min.js"></script>
                                    <script src="/static/assets/js/ace.min.js"></script>

                                    <!-- inline scripts related to this page -->

                                    <script type="text/javascript">
                                        jQuery(function($) {
                                            $('#id-disable-check').on('click', function() {
                                                var inp = $('#form-input-readonly').get(0);
                                                if(inp.hasAttribute('disabled')) {
                                                    inp.setAttribute('readonly' , 'true');
                                                    inp.removeAttribute('disabled');
                                                    inp.value="This text field is readonly!";
                                                }
                                                else {
                                                    inp.setAttribute('disabled' , 'disabled');
                                                    inp.removeAttribute('readonly');
                                                    inp.value="This text field is disabled!";
                                                }
                                            });


                                            $(".chosen-select").chosen();
                                            $('#chosen-multiple-style').on('click', function(e){
                                                var target = $(e.target).find('input[type=radio]');
                                                var which = parseInt(target.val());
                                                if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                                                else $('#form-field-select-4').removeClass('tag-input-style');
                                            });


                                            $('[data-rel=tooltip]').tooltip({container:'body'});
                                            $('[data-rel=popover]').popover({container:'body'});

                                            $('textarea[class*=autosize]').autosize({append: "\n"});
                                            $('textarea.limited').inputlimiter({
                                                remText: '%n character%s remaining...',
                                                limitText: 'max allowed : %n.'
                                            });

                                            $.mask.definitions['~']='[+-]';
                                            $('.input-mask-date').mask('99/99/9999');
                                            $('.input-mask-phone').mask('(999) 999-9999');
                                            $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
                                            $(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});



                                            $( "#input-size-slider" ).css('width','200px').slider({
                                                value:1,
                                                range: "min",
                                                min: 1,
                                                max: 8,
                                                step: 1,
                                                slide: function( event, ui ) {
                                                    var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                                                    var val = parseInt(ui.value);
                                                    $('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
                                                }
                                            });

                                            $( "#input-span-slider" ).slider({
                                                value:1,
                                                range: "min",
                                                min: 1,
                                                max: 12,
                                                step: 1,
                                                slide: function( event, ui ) {
                                                    var val = parseInt(ui.value);
                                                    $('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
                                                }
                                            });


                                            $( "#slider-range" ).css('height','200px').slider({
                                                orientation: "vertical",
                                                range: true,
                                                min: 0,
                                                max: 100,
                                                values: [ 17, 67 ],
                                                slide: function( event, ui ) {
                                                    var val = ui.values[$(ui.handle).index()-1]+"";

                                                    if(! ui.handle.firstChild ) {
                                                        $(ui.handle).append("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
                                                    }
                                                    $(ui.handle.firstChild).show().children().eq(1).text(val);
                                                }
                                            }).find('a').on('blur', function(){
                                                $(this.firstChild).hide();
                                            });

                                            $( "#slider-range-max" ).slider({
                                                range: "max",
                                                min: 1,
                                                max: 10,
                                                value: 2
                                            });

                                            $( "#eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
                                                // read initial values from markup and remove that
                                                var value = parseInt( $( this ).text(), 10 );
                                                $( this ).empty().slider({
                                                    value: value,
                                                    range: "min",
                                                    animate: true

                                                });
                                            });


                                            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                                                no_file:'No File ...',
                                                btn_choose:'Choose',
                                                btn_change:'Change',
                                                droppable:false,
                                                onchange:null,
                                                thumbnail:false //| true | large
                                                //whitelist:'gif|png|jpg|jpeg'
                                                //blacklist:'exe|php'
                                                //onchange:''
                                                //
                                            });

                                            $('#id-input-file-3').ace_file_input({
                                                style:'well',
                                                btn_choose:'Drop files here or click to choose',
                                                btn_change:null,
                                                no_icon:'icon-cloud-upload',
                                                droppable:true,
                                                thumbnail:'small'//large | fit
                                                //,icon_remove:null//set null, to hide remove/reset button
                                                /**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
                                                /**,before_remove : function() {
						return true;
					}*/
                                                ,
                                                preview_error : function(filename, error_code) {
                                                    //name of the file that failed
                                                    //error_code values
                                                    //1 = 'FILE_LOAD_FAILED',
                                                    //2 = 'IMAGE_LOAD_FAILED',
                                                    //3 = 'THUMBNAIL_FAILED'
                                                    //alert(error_code);
                                                }

                                            }).on('change', function(){
                                                //console.log($(this).data('ace_input_files'));
                                                //console.log($(this).data('ace_input_method'));
                                            });


                                            //dynamically change allowed formats by changing before_change callback function
                                            $('#id-file-format').removeAttr('checked').on('change', function() {
                                                var before_change
                                                var btn_choose
                                                var no_icon
                                                if(this.checked) {
                                                    btn_choose = "Drop images here or click to choose";
                                                    no_icon = "icon-picture";
                                                    before_change = function(files, dropped) {
                                                        var allowed_files = [];
                                                        for(var i = 0 ; i < files.length; i++) {
                                                            var file = files[i];
                                                            if(typeof file === "string") {
                                                                //IE8 and browsers that don't support File Object
                                                                if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
                                                            }
                                                            else {
                                                                var type = $.trim(file.type);
                                                                if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
                                                                    || ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )//for android's default browser which gives an empty string for file.type
                                                                ) continue;//not an image so don't keep this file
                                                            }

                                                            allowed_files.push(file);
                                                        }
                                                        if(allowed_files.length == 0) return false;

                                                        return allowed_files;
                                                    }
                                                }
                                                else {
                                                    btn_choose = "Drop files here or click to choose";
                                                    no_icon = "icon-cloud-upload";
                                                    before_change = function(files, dropped) {
                                                        return files;
                                                    }
                                                }
                                                var file_input = $('#id-input-file-3');
                                                file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
                                                file_input.ace_file_input('reset_input');
                                            });




                                            $('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
                                                .on('change', function(){
                                                    //alert(this.value)
                                                });
                                            $('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'icon-caret-up', icon_down:'icon-caret-down'});
                                            $('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});



                                            $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
                                                $(this).prev().focus();
                                            });
                                            $('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
                                                $(this).next().focus();
                                            });

                                            $('#timepicker1').timepicker({
                                                minuteStep: 1,
                                                showSeconds: true,
                                                showMeridian: false
                                            }).next().on(ace.click_event, function(){
                                                $(this).prev().focus();
                                            });

                                            $('#colorpicker1').colorpicker();
                                            $('#simple-colorpicker-1').ace_colorpicker();


                                            $(".knob").knob();


                                            //we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
                                            var tag_input = $('#form-field-tags');
                                            if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) )
                                            {
                                                tag_input.tag(
                                                    {
                                                        placeholder:tag_input.attr('placeholder'),
                                                        //enable typeahead by specifying the source array
                                                        source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
                                                    }
                                                );
                                            }
                                            else {
                                                //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                                                tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
                                                //$('#form-field-tags').autosize({append: "\n"});
                                            }




                                            /////////
                                            $('#modal-form input[type=file]').ace_file_input({
                                                style:'well',
                                                btn_choose:'Drop files here or click to choose',
                                                btn_change:null,
                                                no_icon:'icon-cloud-upload',
                                                droppable:true,
                                                thumbnail:'large'
                                            })

                                            //chosen plugin inside a modal will have a zero width because the select element is originally hidden
                                            //and its width cannot be determined.
                                            //so we set the width after modal is show
                                            $('#modal-form').on('shown.bs.modal', function () {
                                                $(this).find('.chosen-container').each(function(){
                                                    $(this).find('a:first-child').css('width' , '210px');
                                                    $(this).find('.chosen-drop').css('width' , '210px');
                                                    $(this).find('.chosen-search input').css('width' , '200px');
                                                });
                                            })
                                            /**
                                             //or you can activate the chosen plugin after modal is shown
                                             //this way select element becomes visible with dimensions and chosen works as expected
                                             $('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
                                             */

                                        });
                                    </script>
                                    <script type="text/javascript">
                                        jQuery(function($){

                                            function showErrorAlert (reason, detail) {
                                                var msg='';
                                                if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
                                                else {
                                                    console.log("error uploading file", reason, detail);
                                                }
                                                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                                                    '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
                                            }

                                            //$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

                                            //but we want to change a few buttons colors for the third style
                                            $('#editor1').ace_wysiwyg({
                                                toolbar:
                                                    [
                                                        'font',
                                                        null,
                                                        'fontSize',
                                                        null,
                                                        {name:'bold', className:'btn-info'},
                                                        {name:'italic', className:'btn-info'},
                                                        {name:'strikethrough', className:'btn-info'},
                                                        {name:'underline', className:'btn-info'},
                                                        null,
                                                        {name:'insertunorderedlist', className:'btn-success'},
                                                        {name:'insertorderedlist', className:'btn-success'},
                                                        {name:'outdent', className:'btn-purple'},
                                                        {name:'indent', className:'btn-purple'},
                                                        null,
                                                        {name:'justifyleft', className:'btn-primary'},
                                                        {name:'justifycenter', className:'btn-primary'},
                                                        {name:'justifyright', className:'btn-primary'},
                                                        {name:'justifyfull', className:'btn-inverse'},
                                                        null,
                                                        {name:'createLink', className:'btn-pink'},
                                                        {name:'unlink', className:'btn-pink'},
                                                        null,
                                                        {name:'insertImage', className:'btn-success'},
                                                        null,
                                                        'foreColor',
                                                        null,
                                                        {name:'undo', className:'btn-grey'},
                                                        {name:'redo', className:'btn-grey'}
                                                    ],
                                                'wysiwyg': {
                                                    fileUploadError: showErrorAlert
                                                }
                                            }).prev().addClass('wysiwyg-style3');



                                            $('#editor2').css({'height':'200px'}).ace_wysiwyg({
                                                toolbar_place: function(toolbar) {
                                                    return $(this).closest('.widget-box').find('.widget-header').prepend(toolbar).children(0).addClass('inline');
                                                },
                                                toolbar:
                                                    [
                                                        'bold',
                                                        {name:'italic' , title:'Change Title!', icon: 'icon-leaf'},
                                                        'strikethrough',
                                                        null,
                                                        'insertunorderedlist',
                                                        'insertorderedlist',
                                                        null,
                                                        'justifyleft',
                                                        'justifycenter',
                                                        'justifyright'
                                                    ],
                                                speech_button:false
                                            });


                                            $('[data-toggle="buttons"] .btn').on('click', function(e){
                                                var target = $(this).find('input[type=radio]');
                                                var which = parseInt(target.val());
                                                var toolbar = $('#editor1').prev().get(0);
                                                if(which == 1 || which == 2 || which == 3) {
                                                    toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
                                                    if(which == 1) $(toolbar).addClass('wysiwyg-style1');
                                                    else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
                                                }
                                            });




                                            //Add Image Resize Functionality to Chrome and Safari
                                            //webkit browsers don't have image resize functionality when content is editable
                                            //so let's add something using jQuery UI resizable
                                            //another option would be opening a dialog for user to enter dimensions.
                                            if ( typeof jQuery.ui !== 'undefined' && /applewebkit/.test(navigator.userAgent.toLowerCase()) ) {

                                                var lastResizableImg = null;
                                                function destroyResizable() {
                                                    if(lastResizableImg == null) return;
                                                    lastResizableImg.resizable( "destroy" );
                                                    lastResizableImg.removeData('resizable');
                                                    lastResizableImg = null;
                                                }

                                                var enableImageResize = function() {
                                                    $('.wysiwyg-editor')
                                                        .on('mousedown', function(e) {
                                                            var target = $(e.target);
                                                            if( e.target instanceof HTMLImageElement ) {
                                                                if( !target.data('resizable') ) {
                                                                    target.resizable({
                                                                        aspectRatio: e.target.width / e.target.height,
                                                                    });
                                                                    target.data('resizable', true);

                                                                    if( lastResizableImg != null ) 
                                                                    lastResizableImg = target;
                                                                }
                                                            }
                                                        })
                                                        .on('click', function(e) {
                                                            if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
                                                                destroyResizable();
                                                            }
                                                        })
                                                        .on('keydown', function() {
                                                            destroyResizable();
                                                        });
                                                }

                                                enableImageResize();

                                                /**
                                                 //or we can load the jQuery UI dynamically only if needed
                                                 if (typeof jQuery.ui !== 'undefined') enableImageResize();
                                                 else );
				} else	enableImageResize();
			});
		}
                                                 */
                                            }


                                        });
                                    </script>

                                    <script type="text/javascript">

                                        //实例化编辑器
                                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                                        var ue = UE.getEditor('editor');


                                    </script>
</body>
</html>
