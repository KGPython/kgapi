<?php
namespace api\utils;

/**
 * Created by PhpStorm.
 * User: he
 * Date: 2016-6-30
 * Time: 11:43
 */
class MethodUtil{

    public static function var_encode($var) {
        if (empty ( $var )) {
            return false;
        }
        if (is_array ( $var )) {
            foreach ( $var as $k => $v ) {
                if (is_scalar ( $v )) {
                    $var [$k] =  mb_convert_encoding($v ,"UTF-8","GBK");
                }else {
                    $var [$k] = MethodUtil::var_encode ( $v );
                }
            }
        }else {
            $var = mb_convert_encoding($var,"UTF-8","GBK"); //urlencode($var)
        }
        return $var;
    }

}
?>
