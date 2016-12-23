<?php


namespace xll\common\helpers;

use common\support\BaseConstant;

class FeatureHelper implements BaseConstant
{
    /**
     * 通过Array转换成String
     * @param $attrs
     * @return string
     */
    public static final function toString($attrs)
    {
        $str = '';
        asort($attrs);
        foreach ($attrs AS $k => $v) {
            if (!empty($v)) {
                $str .= self::encode($k) . self::SSP . self::encode($v) . self::SP;
            }
        }

        return $str;
    }

    /**
     * 通过字符串解析成attributes
     * @param $str
     * @return array
     */
    public static final function fromString($str)
    {
        $attrs = [];
        if (!empty($str)) {
            $arr = explode(self::SP, $str);
            foreach ($arr AS $kv) {
                if (!empty($kv)) {
                    $ar = explode(self::SSP, $kv);
                    error_log(print_r($ar, true));
                    if (count($ar) == 2 && !empty($ar[1])) {
                        $attrs[self::decode($ar[0])] = self::decode($ar[1]);
                    }
                }
            }
        }
        return $attrs;
    }

    private static function encode($str)
    {
        return str_replace([self::SP, self::SSP], [self::R_SP, self::R_SSP], $str);
    }

    private static function decode($str)
    {
        return str_replace([self::R_SP, self::R_SSP], [self::SP, self::SSP], $str);
    }
}