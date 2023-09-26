<?php

namespace Ledc\Env;

use Closure;

/**
 * 环境变量
 */
class Env
{
    /**
     * 读取
     * @param string $key 键名
     * @param mixed|null $default 默认值（支持传入匿名函数）
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        if (false === $value) {
            return self::value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }
        return $value;
    }

    /**
     * 支持匿名函数
     * @param mixed $value
     * @return mixed
     */
    protected static function value(mixed $value): mixed
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
