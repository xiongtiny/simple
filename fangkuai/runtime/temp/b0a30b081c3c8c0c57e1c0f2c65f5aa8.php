<?php /*a:2:{s:64:"D:\phpStudy\WWW\fangkuai\application\admin\view\index\index.html";i:1525943057;s:64:"D:\phpStudy\WWW\fangkuai\application\admin\view\public\head.html";i:1526435399;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>方块智慧农业</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/static/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/static/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <script src="/static/js/echarts.min.js"></script>
    <link rel="stylesheet" href="/static/css/amazeui.min.css" />
    <link rel="stylesheet" href="/static/css/amazeui.datatables.min.css" />
    <link rel="stylesheet" href="/static/css/app.css">
    <script src="/static/js/jquery.min.js"></script>

</head>
<style>
/*分页样式*/  
.pagination{text-align:center;margin-top:20px;margin-bottom: 20px;}  
.pagination li{margin:0px 10px; border:1px solid #e6e6e6;padding: 3px 8px;display: inline-block;}  
.pagination .active{background-color: #46A3FF;color: #fff;}  
.pagination .disabled{color:#aaa;} 
</style>
<body data-type="index">
    <script src="/static/js/theme.js"></script>
    <div class="am-g tpl-g">
        <!-- 头部 -->
        <header>
            <!-- logo -->
            <div class="am-fl tpl-header-logo">
                <h2 style="color:white;padding-top: 0.5em;padding-right: 0.8em;">方块智慧农业</h2>
            </div>
            <!-- 右侧内容 -->
            <div class="tpl-header-fluid">
                <!-- 侧边切换 -->
                <!--   <div class="am-btn-group am-btn-group-xs" style="padding-top: 1em">  
                                       <button  class="am-btn am-btn-primary tpl-btn-bg-color-success " href="/ami/index/users" /> 返回</button>  
                                       </div>   -->       
                <!-- 其它功能-->
                <div class="am-fr tpl-header-navbar">
                    <ul>
                        <!-- 欢迎语 -->
                        <li class="am-text-sm tpl-header-navbar-welcome">
                            <a href="javascript:;">欢迎你, <span><?php echo htmlentities(app('request')->session('username')); ?></span> </a>
                        </li>                        

                        <!-- 退出 -->
                        <li class="am-text-sm">
                            <a href="/ami/login/loginout;">
                                <span class="am-icon-sign-out"></span> 退出
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </header>
       
        <!-- 侧边导航栏 -->
        <div class="left-sidebar">
            <!-- 用户信息 -->
            <div class="tpl-sidebar-user-panel">
                <div class="tpl-user-panel-slide-toggleable">
                    
                    <!-- <a href="javascript:;" class="tpl-user-panel-action-link"> <span class="am-icon-pencil"></span> 账号设置</a> -->
                </div>
            </div>

            <!-- 菜单 -->
            <ul class="sidebar-nav">
                
                <li class="sidebar-nav-link">
                    <a href="/ami/index/index.html"<?php if(stripos(request()->url(),'/ami/index/index')!==false): ?>class='active'<?php endif; ?>>
                        首页
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/ami/index/users.html"<?php if(stripos(request()->url(),'/ami/index/user')!==false): ?>class='active'<?php endif; ?>>
                          用户列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/ami/farm/index.html"<?php if(stripos(request()->url(),'/ami/farm/index')!==false): ?> class='active'<?php endif; ?>>
                          农场列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/ami/feed/index.html"<?php if(stripos(request()->url(),'/ami/feed/index')!==false): ?> class='active'<?php endif; ?>>
                          反馈列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/ami/order/index.html"<?php if(stripos(request()->url(),'/ami/order/index')!==false): ?> class='active'<?php endif; ?>>
                          订单
                    </a>
                </li>  

                <li class="sidebar-nav-link">
                    <a href="/ami/auth/index.html"<?php if(stripos(request()->url(),'/ami/auth/index')!==false): ?> class="active"<?php endif; ?>>
                        账号管理
                    </a>
                </li>              
               
                <li class="sidebar-nav-link">
                    <a href="/ami/login/login.html">
                        登录
                    </a>
                </li>
                

            </ul>
         </div>
    </div>
</div>
<script src="/static/js/amazeui.min.js"></script>
<script src="/static/js/amazeui.datatables.min.js"></script>
<script src="/static/js/dataTables.responsive.min.js"></script>
<script src="/static/js/app.js"></script>

</body>

</html>

     <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>方块智慧农业</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/static/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/static/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="/static/css/amazeui.min.css" />
    <link rel="stylesheet" href="/static/css/amazeui.datatables.min.css" />
    <link rel="stylesheet" href="/static/css/app.css">
    <script src="/static/js/jquery.min.js"></script>

</head>

<body data-type="login">
    <script src="/static/js/theme.js"></script>
    <div class="am-g tpl-g">
       
        <div class="tpl-login">
            <div class="tpl-login-content">
                <div class="tpl-login-logo">
                    <h2 style="color:white;padding-left: 1em;">方块智慧农业</h2>
                </div>
                
            </div>
        </div>
    </div>
    <script src="/static/js/amazeui.min.js"></script>
    <script src="/static/js/app.js"></script>

</body>

</html>