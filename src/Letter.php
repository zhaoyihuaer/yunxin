<?php

namespace Yihuaer\Yunxin;

/**
 * 实例化动作入口
 * Class Letter
 * @package Yihuaer\Yunxin
 */
class Letter
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }

    /**
     * @param $name
     * @param array $config
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $name));
        $namespace = str_replace(' ', '', $value);

        // 所有动作地址
        $application = "\\Yihuaer\\Yunxin\\Achieve\\{$namespace}";

        return new $application($config);
    }
}