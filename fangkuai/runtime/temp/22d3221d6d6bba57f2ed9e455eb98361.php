<?php /*a:3:{s:70:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\user\user_edit.html";i:1526451667;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\head.html";i:1526437494;s:67:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\public\foot.html";i:1526435605;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/static/css/style.css">
    <link href="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   <!--  <script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.js"></script> -->
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.js"></script>
	<style type="text/css">

    #photo {
        max-width:100%;
        max-height:350px;
    }
    .img-preview-box {
        text-align: center;
    }
    .img-preview-box > div {
        display: inline-block;;
        margin-right: 10px;
    }
    .img-preview {
        overflow: hidden;
    }
    .img-preview-box .img-preview-lg {
        width: 150px;
        height: 150px;
    }
    .img-preview-box .img-preview-md {
        width: 100px;
        height: 100px;
    }
    .img-preview-box .img-preview-sm {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>
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
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/index/index"><div class="navigation_2">首页</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/farm/index"><div class="navigation_2 ">智慧农业</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_product_description"><div class="navigation_2">产品教程</div></a>
					<a style="text-decoration: none;" class="navigation_3" href=""><div class="navigation_2">论坛</div></a>
					<a style="text-decoration: none;" class="navigation_3" href="/index.php/api/v1/other/other_about_us"><div class="navigation_2">关于我们</div></a>
				</div>
			</div>
		</div>
	</div>


	<div class="bottom_6 bottom_6_1">
		<div class="container  bottom_6_1">

			<div style="width: 25%;"> <!-- 右侧 -->
				<div class="guide_8_uesr">


				<?php if(empty($user['img'])): ?>
				<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
					<img id="user-photo" src="/static/image/tx.jpeg" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;"><small>点击头像修改</small>
				</div>
				<?php else: ?>
				<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
					<img id="user-photo" src="<?php echo htmlentities($user['img']); ?>" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;"><small>点击头像修改</small>
				</div>
				<?php endif; ?>

					<div>
						<?php if((empty($user['name']))): ?>
						<h3></h3>
						<?php else: ?>
						<h3><?php echo htmlentities($user['name']); ?></h3>
						<?php endif; ?>
						<span><?php echo htmlentities($user['phone']); ?></span>
					</div>
				</div>
				<div style="padding-bottom: 100px;font-size: 16px;">
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit"><div class="guide_8_1 guide_8_1_active">资料与安全</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_lease"><div class="guide_8_1">我租赁的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_release"><div class="guide_8_1">我发布的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/transaction_record"><div class="guide_8_1">交易记录</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/feedback"><div class="guide_8_1">意见反馈</div></a>
					</div>
				</div>
			</div>

			<div class="user_1">
				<form action="" method="post">
					<div  class="form-group">
						<label  for="">&nbsp;&nbsp;&nbsp;昵称&nbsp;</label>
			<?php if(empty($user['name'])): ?>
			<input type="text" id="name" class="form-control_style_user" placeholder="请输入用户名">
			<?php else: ?>
			<input type="text" id="name" class="form-control_style_user" value="<?php echo htmlentities($user['name']); ?>">
			<?php endif; ?>
					</div>
					<div class="form-group">
						<label  for="">旧密码&nbsp;</label>
						<input type="password" id="password" class="form-control_style_user" placeholder="请输入旧密码">

					</div>
					<div class="form-group" >
						<label  for="">新密码&nbsp;</label>
						<input type="password" id="password2" class="form-control_style_user" placeholder="请输入新密码">

					</div>
					<div class="form-group" >
						<label  for="">支付宝&nbsp;</label>
						<input type="text" id="alipay" class="form-control_style_user" value="<?php echo htmlentities($user['alipay']); ?>">
					</div>
					<div style="text-align: center;margin-left: -80px;"><button type="button" onclick="input()" class="user_botton">保存</button></div>

				</form>

			</div>
		</div>
	</div>


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

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-primary">
            <i class="fa fa-pencil"></i>
                        更换头像
            </h4>
        </div>
        <div class="modal-body">
            <p class="tip-info text-center">
                未选择图片
            </p>
            <div class="img-container hidden">
                <img src="" alt="" id="photo">
            </div>
            <div class="img-preview-box hidden">

            </div>
        </div>
        <div class="modal-footer">
            <label class="btn btn-danger pull-left" for="photoInput">
            <input type="file" class="sr-only" id="photoInput" accept="image/*">
            <span>打开图片</span>
            </label>
            <button class="btn btn-primary disabled" disabled="true" onclick="sendPhoto();">提交</button>
            <button class="btn btn-close" aria-hidden="true" data-dismiss="modal">取消</button>
        </div>
    </div>
</div>
</div>

<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</body>

<script>


	function input() {
	  $.ajax({
		    type: "post",
			url: "/index.php/api/v1/user/user_edit",
			data: {
				name:$("#name").val(),
				password:$("#password").val(),
				password2:$("#password2").val(),
				alipay:$("#alipay").val(),
			},
			success: function(data) {
				if(data.code==400){
					alert(data.message);
                    location.href="/api/v1/user/user_edit"
				}
				if(data.code==200){
				    alert(data.message);
                    location.href="/api/v1/user/user_edit"

				}
			},
			error: function(jqXHR){
			   alert("发生错误：" + jqXHR.status);
			},
		});
	}


</script>
<script type="text/javascript">
    var initCropperInModal = function(img, input, modal){
        var $image = img;
        var $inputImage = input;
        var $modal = modal;
        var options = {
            aspectRatio: 1, // 纵横比
            viewMode: 2,
            preview: '.img-preview' // 预览图的class名
        };
        // 模态框隐藏后需要保存的数据对象
        var saveData = {};
        var URL = window.URL || window.webkitURL;
        var blobURL;
        $modal.on('show.bs.modal',function () {
            // 如果打开模态框时没有选择文件就点击“打开图片”按钮
            if(!$inputImage.val()){
                $inputImage.click();
            }
        }).on('shown.bs.modal', function () {
            // 重新创建
            $image.cropper( $.extend(options, {
                ready: function () {
                    // 当剪切界面就绪后，恢复数据
                    if(saveData.canvasData){
                        $image.cropper('setCanvasData', saveData.canvasData);
                        $image.cropper('setCropBoxData', saveData.cropBoxData);
                    }
                }
            }));
        }).on('hidden.bs.modal', function () {
            // 保存相关数据
            saveData.cropBoxData = $image.cropper('getCropBoxData');
            saveData.canvasData = $image.cropper('getCanvasData');
            // 销毁并将图片保存在img标签
            $image.cropper('destroy').attr('src',blobURL);
        });
        if (URL) {
            $inputImage.change(function() {
                var files = this.files;
                var file;
                if (!$image.data('cropper')) {
                    return;
                }
                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {

                        if(blobURL) {
                            URL.revokeObjectURL(blobURL);
                        }
                        blobURL = URL.createObjectURL(file);

                        // 重置cropper，将图像替换
                        $image.cropper('reset').cropper('replace', blobURL);

                        // 选择文件后，显示和隐藏相关内容
                        $('.img-container').removeClass('hidden');
                        $('.img-preview-box').removeClass('hidden');
                        $('#changeModal .disabled').removeAttr('disabled').removeClass('disabled');
                        $('#changeModal .tip-info').addClass('hidden');

                    } else {
                        window.alert('请选择一个图像文件！');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).addClass('disabled');
        }
    }

    var sendPhoto = function () {
        // 得到PNG格式的dataURL
        var photo = $('#photo').cropper('getCroppedCanvas', {
            width: 300,
            height: 300,
        }).toDataURL('image/png');

        $.ajax({

            url: '/api/v2/user/user_img', // 要上传的地址
            type: 'post',
            data: {
                photo: photo
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.code == 200) {
                    alert(data.message);
                    location.href="/api/v1/user/user_edit"
                } else {
                    alert(data.message);
                }
            }
        });
    }

    $(function(){
        initCropperInModal($('#photo'),$('#photoInput'),$('#changeModal'));
    });
</script>
</html>