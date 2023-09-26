<?php

use Ledc\Env\Env;

if (!function_exists('env')) {
    /**
     * 读取Env环境变量
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    function env(string $key, mixed $default = null): mixed
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('env_boolean')) {
    /**
     * 读取Env环境变量，格式化为布尔值
     * @param string $key
     * @return boolean 格式化后的变量
     */
    function env_boolean(string $key): bool
    {
        $value = getenv($key);
        return match (true) {
            is_bool($value) => $value,
            is_numeric($value) => $value > 0,
            is_string($value) => in_array(strtolower($value), ['ok', 'true', 'success', 'on', 'yes', '(ok)', '(true)', '(success)', '(on)', '(yes)']),
            is_array($value) => !empty($value),
            default => (bool)$value,
        };
    }
}
