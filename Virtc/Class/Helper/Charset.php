<?php
/**
 * Created by JetBrains PhpStorm.
 * User: itcoder
 * Date: 05.10.13
 * Time: 16:10
 * To change this template use File | Settings | File Templates.
 */
class Helper_Charset{
    public static function convert( $string ){
        $engCharset = array('q','w','e','r','t','y','u','i','o','p','[',']','a',
            's','d','f','g','h','j','k','l',';',"'",'z','x','c','v','b','n',
            'm',',','.','/');
        $rusCharset = array('й','ц','у','к','е','н','г','ш','щ','з','х',
            'ъ','ф','ы','в','а','п','р','о','л','д','ж','э',
            'я','ч','с','м','и','т','ь','б','ю',);
        return str_replace($engCharset, $rusCharset, $string);
    }
}