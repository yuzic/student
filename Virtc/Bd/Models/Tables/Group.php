<?php
/**
 * Created by JetBrains PhpStorm.
 * User: itcoder
 * Date: 05.10.13
 * Time: 22:09
 * To change this template use File | Settings | File Templates.
 */

class UserGroup extends Model {


    /**
     * @desc описываем поля модели
     */
    private static $fields = array(
        'id' => null,
        'name' => null,

    );

    /**
     * @desc описываем настройки кеширования
     *
     * @var type array
     */
    private static $cacheSettings = array(
        'time_reload'  => 300,   // время очистки кеша
        'chached'	   => true,
        'isHot'        =>false,// подогрев кеша
        'prefix'	   =>'user_data',
        'limit_records' => true,    //  разбивать записи по лиммитам
        'count_limit_records' => 10 // по сколько разбивать
    );
}
