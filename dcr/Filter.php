<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr;

class Filter
{
    /**
     * 过滤字符串,特殊字符转义，规范配对tag
     * @param string $string 输入string
     * @param int $flag 附加选项flat
     * @return mixed 过滤结果
     */
    public static function filterString($string, $flag = null)
    {
        return filter_var($string, FILTER_SANITIZE_STRING, $flag);
    }

    /**
     * 过滤特殊字符串，不可见字符，html标志<>&
     * @param string $string 输入string
     * @param int $flag 附加选项flat
     * @return mixed 过滤结果
     */
    public static function filterSpecialChars($string, $flag = null)
    {
        return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS, $flag);
    }

    /**
     * 使用Sanitize过滤网址内非法字符串
     * @param string $url
     * @return mixed
     */
    public static function filterUrl($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * 过滤email地址中非法字符
     * @param string $email
     */
    public static function filterEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * 过滤成float
     * @param string $float
     */
    public static function filterFloat($float): float
    {
        return (float)$float;
    }

    /**
     * 过滤成int
     * @param string $float
     */
    public static function filterInt($int): int
    {
        return (int)$int;
    }
}
