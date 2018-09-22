<?php /*a:1:{s:80:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\user\transaction_record1.html";i:1526053161;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/static/css/style.css">
    <link href="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.css" rel="stylesheet">
    <script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/cropper/3.1.3/cropper.min.js"></script>
</head>
<body>
<body>
	<div id="top"><!-- 头部 -->
		<div class="container" id="top_main">
			<span id="top_left">
				联系我们: <a style="text-decoration: none;" href="#" id="top_phone">400-1895555</a>
			</span>
			<span id="top_right">
			<?php if((empty($name))): ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/index/login1" id="top_login">登录</a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="/index.php/api/v1/index/register1" id="top_logon">注册</a>

			<?php else: ?>
			<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit1" id="top_login">欢迎您，<?php echo htmlentities($name); ?>用户</a>&nbsp;|&nbsp;<a style="text-decoration: none;" href="#" id="top_logon">退出</a>
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
					<div>

							<div data-target="#changeModal" data-toggle="modal" class="user-photo-box" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
							    <img id="user-photo" src="/static/image/tx.jpeg" style="width: 100px; height: 100px; margin:0px auto;border-radius: 100em;">
							</div>
					</div>
					<div>
						<h3><?php echo htmlentities($name); ?>用户</h3>
						<span><?php echo htmlentities($phone); ?></span>
					</div>
				</div>
				<div style="padding-bottom: 100px;font-size: 16px;">
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_edit1"><div class="guide_8_1">资料与安全</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_lease1"><div class="guide_8_1">我租赁的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/user_release1"><div class="guide_8_1">我发布的农场</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/transaction_record1"><div class="guide_8_1 guide_8_1_active">交易记录</div></a>
					</div>
					<div class="guide_8">
						<a style="text-decoration: none;" href="/index.php/api/v1/user/feedback1"><div class="guide_8_1">意见反馈</div></a>
					</div>
				</div>
			</div>

				<div class="user_2_4"><!-- 左侧 -->
						
					<table>
						<thead>
							<tr>
								<td style="width:250px;color: #000000;">订单号</td>
								<td style="width:400px;color: #000000; ">交易时间</td>
								<td style="width:400px;color: #000000;">交易内容</td>
								<td style="width:250px;color: #000000;">金额</td>
							</tr>
						</thead>
						<tbody>
						
								<tr>
									<td></td>
									<td>2018-04-18&nbsp;12:54:45</td>
									<td>租赁农场:杰克叔叔的农场</td>
									<td>600000元</td>
								</tr>
									<td>1155151</td>
									<td>2018-04-18&nbsp;12:54:45</td>
									<td>租赁农场:杰克叔叔的农场</td>
									<td>600000元</td>
								</tr>
						
						</tbody>

					
					</table>




				</div>
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

    var sendPhoto = function(){
        $('#photo').cropper('getCroppedCanvas',{
            width:300,
            height:300
        }).toBlob(function(blob){
            // 转化为blob后更改src属性，隐藏模态框
            $('#user-photo').attr('src',URL.createObjectURL(blob));
            $('#changeModal').modal('hide');
        });
    }


        // var sendPhoto = function () {
        //     // 得到PNG格式的dataURL
        //     var photo = $('#photo').cropper('getCroppedCanvas', {
        //         width: 300,
        //         height: 300,
        //     }).toDataURL('image/png');

        //     $.ajax({
        //         url: '/static/image', // 要上传的地址
        //         type: 'post',
        //         data: {
        //             'imgData': photo
        //         },
        //         dataType: 'json',
        //         success: function (data) {
        //             if (data.status == 0) {
        //                 // 将上传的头像的地址填入，为保证不载入缓存加个随机数
        //                 $('.user-photo').attr('src', '/static/image?t=' + Math.random());
        //                 $('#changeModal').modal('hide');
        //             } else {
        //                 alert(data.info);
        //             }
        //         }
        //     });
        // }

    $(function(){
        initCropperInModal($('#photo'),$('#photoInput'),$('#changeModal'));
    });
</script>
</body>
</html>