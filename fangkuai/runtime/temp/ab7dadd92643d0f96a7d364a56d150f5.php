<?php /*a:1:{s:65:"D:\phpStudy\WWW\fangkuai\application\index\view\v1\index\hls.html";i:1525869033;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="renderer" content="webkit">
    <title>测试页面</title>
    <style>
        body{margin:0;}
        #myPlayer{max-width: 1200px;width: 100%;}
    </style>
</head>
<script>
</script>
<body>
<!--<script src="https://open.ys7.com/sdk/js/1.3/ezuikit.js"></script>-->
<script src="/static/ys/yshi/ezuikit.js"></script>

<video id="myPlayer" poster="http://open.ys7.com/asdf.jpg" controls playsInline webkit-playsinline autoplay>
    <source src="http://hls.open.ys7.com/openlive/d257c0965db9400fab9c625acc5b1bd7.hd.m3u8" type="application/x-mpegURL" />

</video>

<script>
    var player = new EZUIPlayer('myPlayer');
//    player.on('error', function(){
//        console.log('error');
//    });
//    player.on('play', function(){
//        console.log('play');
//    });
//    player.on('pause', function(){
//        console.log('pause');
//    });
//    player.on('waiting', function(){
//        console.log('waiting');
//    });


   // 日志
   player.on('log', log);
   
   function log(str){
       var div = document.createElement('DIV');
       div.innerHTML = (new Date()).Format('yyyy-MM-dd hh:mm:ss.S') + JSON.stringify(str);
       document.body.appendChild(div);
   }


</script>
</body>
</html>