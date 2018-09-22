<?php
namespace app\common\model\memcached;

use think\Cache;

class BaseMemcached extends Cache
{
    /**
     * 初始化缓存
     *
     * @param array $options    缓存配置
     */
    public function __construct(array $options = []){
        $options = [
            'type'       => 'memcached',
            'host'       => '127.0.0.1',
        ];

        parent::init($options);
    }
}
