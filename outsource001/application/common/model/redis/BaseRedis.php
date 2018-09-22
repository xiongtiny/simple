<?php
namespace app\common\model\redis;

use think\Cache;

class BaseRedis extends Cache
{
    /**
     * 初始化缓存
     *
     * @param array $options    缓存配置
     */
   public function __construct(array $options = []){
       $options = [
           'type'       => 'redis',
           'host'       => '127.0.0.1',
       ];
       parent::init($options);
   }
}
