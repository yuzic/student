<?php
/**
 * Created by JetBrains PhpStorm.
 * User: itcoder
 * Date: 05.10.13
 * Time: 23:23
 * To change this template use File | Settings | File Templates.
 */


class FactoryCache {

    public static function getAdapter(){
        $adapter = Config::load('Project');
        require_once V_VIRTC."/Cache/Adapters/{$adapter['adapterCache']}.php";
        $adapterClass = "Adapter{$adapter['adapterCache']}";
        $connect = Config::load($adapter['adapterCache']);
        return  new $adapterClass($connect);

    }



}