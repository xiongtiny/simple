<?php /*a:1:{s:63:"D:\phpStudy\WWW\fangkuai\application\index\view\v2\user\my.html";i:1526441772;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我的</title>
	<link rel="stylesheet" href="/phone/css/bootstrap.css">
	<link rel="stylesheet" href="/phone/css/style.css">
	<script src="/static/js/jquery.min.js"></script>
	<link href="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.js"></script>
    <script src="/phone/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<meta name="apple-mobile-web-app-capable" content="yes"> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="format-detection" content="telephone=no"> 
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
	<div class="my">

		<div class="my_top">
			<?php if((empty($user['img']))): ?>
			<div class="my_head"> <!-- 头像 -->			
			<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
				<img id="user-photo" src="/phone/image/tx.jpeg" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;" name="img">
			</div>
			</div>
			<?php else: ?>
			<div class="my_head"> <!-- 头像 -->			
			<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
				<img id="user-photo" src="<?php echo htmlentities($user['img']); ?>" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;" name="img">
			</div>
			</div>
			<?php endif; ?>
			<div class="my_name">
				<?php if((empty($user['name']))): ?>
				<div class="my_name1"></div>
				<?php else: ?>
			<div class="my_name1"><?php echo htmlentities($user['name']); ?></div>
			<?php endif; ?>
				<div class="my_name2"><?php echo htmlentities($user['phone']); ?></div>
			
			</div>
		</div>

		<div class="my_main">
			<a href="data.html" style="color: #000000;">
			<div class="my_main_1">
				<div class="my_main_2">
					<span class="icon-ico_1_1 my_ico_color1"></span>
				</div>
				<div>
					<span>资料与安全</span>
				</div>
				
				
			</div>
			</a>
			<a href="trade.html" style="color: #000000;">
			<div class="my_main_1">
			<div class="my_main_2">
				<span class="icon-ico_1_2 my_ico_color2"></span>
			</div>
			<div>
				<span>交易记录</span>
			</div>
			
			</div>
			</a>
			<a href="feedback1.html" style="color: #000000;">
			<div class="my_main_1">
			<div class="my_main_2">
				<span class="icon-ico_1_3 my_ico_color3"></span>
			</div>
			<div>
				<span>意见反馈</span>
			</div>
				
			</div>
			</a>
			<a href="aboutus.html">
			<div class="my_main_1" style="color: #000000;">
			<div class="my_main_2">
				<span class="icon-ico_1_4 my_ico_color4"></span>
			</div>
			<div>
				<span>关于我们</span>
			</div>
		
			</div>
			</a>
		</div>

		<div class="my_button">
			<a href="/api/v2/index/exit_login">	<button class="my_button1">退出登录</button></a>
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
	<a href="/api/v2/user/user_lease.html" class="bottom_a">
		<div><span class="icon-ico_3 ico_size"></span></div>
		<div><span>我的农场</span></div>
	</a>
	</div>
	<div class="bottom_1">
	<a href="/api/v2/user/my.html" class="bottom_a_active">
		<div><span class="icon-ico_1 ico_size"></span></div>
		<div><span>我的</span></div>
	</a>
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
                        location.href="/api/v2/user/my"
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
</body>
</html>