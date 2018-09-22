<?php
namespace app\api\controller;

use app\common;
use think\Loader;

header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 二维码操作
 *
 * Class QrCode
 * @package app\api\controller
 */
class QrCode extends Base
{

    /**
     * 二维码生成
     */
    public function make(){
        Loader::import('phpqrcode',EXTEND_PATH . 'qrcode'.DS);

        $qrcode                 = new \QRcode();

        $flag                   = input('flag', BASE_DOMAIN);

        $content                = input('content', BASE_URL);

        $size                   = input('size', 6);

        $show_type              = input('t', 1);//1 显示图片地址 2 直接显示图片

        $errorCorrectionLevel   = 'L';//容错级别

        $matrixPointSize        = $size;//生成图片大小

        $qr                     = ROOT_PATH.'public/static/upload/qrcode/yhjs_old.png';//生成原始不带logo图片

        //生成二维码图片

        $qrcode->png($content, $qr, $errorCorrectionLevel, $matrixPointSize, 2);

        $logo                   = ROOT_PATH.'public/logo.png';//准备好的logo图片


        if ($logo !== FALSE) {

            $qr                 = imagecreatefromstring(file_get_contents($qr));

            $logo               = imagecreatefromstring(file_get_contents($logo));

            $QR_width           = imagesx($qr);//二维码图片宽度

            $QR_height          = imagesy($qr);//二维码图片高度

            $logo_width         = imagesx($logo);//logo图片宽度

            $logo_height        = imagesy($logo);//logo图片高度

            $logo_qr_width      = $QR_width / 5;

            $scale              = $logo_width/$logo_qr_width;

            $logo_qr_height     = $logo_height/$scale;

            $from_width         = ($QR_width - $logo_qr_width) / 2;

            //重新组合图片并调整大小

            imagecopyresampled($qr, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        }

        //生成图片
        imagepng($qr, ROOT_PATH.'public/static/upload/qrcode/'.$flag.'.png');

        if($show_type == 1){
            $this->ajaxReturn(AJ_RET_SUCC, '成功', array('img'   => STATIC_URL . 'upload/qrcode/'.$flag.'.png'),$this->lang);
        }else{
            echo '<img src="static/upload/qrcode/yhjs.png">';
        }
    }

    /**
     * 读取二维码信息
     */
    public function read(){
        $type   =input('type');


    }
}
