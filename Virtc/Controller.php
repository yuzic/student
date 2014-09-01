<?php
/**
 * Created by JetBrains PhpStorm.
 * User: itcoder
 * Date: 06.10.13
 * Time: 18:25
 * To change this template use File | Settings | File Templates.
 */

class Controller {
    /** @var View */

    protected $view = null;

    public function __construct(){
        $this->view = new View(get_called_class());
    }


}