<?php
class View
{
    /** @var string Расширение для видов */
    const EXPANSION = '.php';

    /** @var Controller Контролляра для которого вызван View */
    private $_controller = null;

    /** @var array Переменные окружнения */
    private $_attrs = array();

    /** @var ViewHelper */
    private $_helper = null;

    public function __construct($controller)
    {
        $this->_controller = $controller;
    }

    public function setViewHelper()
    {
        $this->_helper = Safix::app()->getViewHelper();
    }

    /**
     * Загрузка макета(вида) по его имени
     * Имя макета(вида) пишется с расширением.
     * Пример: $layout = 'podmaket'
     * @param string $lyauout Имя макета(вида)
     */
    public function render($layout)
    {
        $path = $this->getPathViewController() .'/'. $layout . self::EXPANSION;

        if (file_exists($path)) {
            include $path;
        } else {
            throw  VException::run('Вид '. ($path) .' не найден!');
        }
    }

    /**
     * Загрузка макета(вида) по его имени c другого вида
     * Имя макета(вида) пишется с расширением.
     * Пример: $layout = 'ajaxClient/show'
     * @param string $lyauout Имя макета(вида)
     */
    public function renderAny($layout)
    {
        $path = $this->getFullPathController() .'/'.$layout . self::EXPANSION;

        if (file_exists($path)) {
            include $path;
        } else {
            throw new ViewException('Вид загружаемый из другого view'. Html::encode($path) .' не найден!');
        }
    }
    /**
     * @return string Имя контроллера
     */
    public function getControllerName()
    {
        return $this->_controller;
    }

    /**
     * @return Controller Контроллер
     */
    public function getController()
    {
        return $this->_controller;
    }



    /**
     * @return string Путь до папки с макетами (видами) для нужного контроллера
     */
    public function getPathViewController()
    {
        $path = 'Application/View/'.$this->getControllerName();

        return $path;
    }

    /**
     * @return string Путь до папки с макетами (видами) для нужного контроллера
     */
    public function getFullPathController()
    {
        $path = V_SELF .'/modules/'. $this->getModuleName() . Safix::getLocate()->getPath(true) .
            '/views/controllers';

        return $path;
    }


    /**
     * Путь до папки с плугинами
     *
     * @return string
     */
    public function getUrlPlugins()
    {
        $path =  SF_URL .'/plugins';

        return $path;
    }

    /**
     * Путь до папки с плугинами
     *
     * @return string
     */
    public function getPathPlugins()
    {
        $path =  SF_PATH .'/plugins';

        return $path;
    }

    /**
     * Путь до папки с макетами(видами) не включая конроллер
     *
     * @param string $module Если не указан модуль,то берется системный
     * @return string
     */
    public function getUrlView($module = '')
    {
        $module = ('' == $module)? $this->getModuleName(): $module;
        $path =  SF_URL .'/modules/'. $module . Safix::getLocate()->getPath(true) .'/views';

        return $path;
    }

    /**
     * @return string Путь до папки с макетами
     */
    public function getPathLayout()
    {
        $path = SF_PATH .'/layouts'. Safix::getLocate()->getPath(true);

        return $path;
    }

    /**
     * @return string URL Путь до папки с макетами
     */
    public function getUrlLayout()
    {
        $path = SF_URL .'/layouts'. Safix::getLocate()->getPath(true);

        return $path;
    }

    /**
     * @return string Адресс текущего запроса
     */
    public function getUri($displayAction = true)
    {
        $uri  = SF_URL;
        $uri .= (($lang = Safix::getLanguage()->getLang()) != Config::get('lang.default'))? '/'. $lang: '';
        $uri .= Safix::getLocate()->getUri(true);
        if ($displayAction) {
            $uri .= ('' != ($action = Safix::app()->getActionName()))? '/'. $action: '';
        }

        return $uri;
    }

    /**
     * @return string Адресс текущего запроса полностью
     */
    public function getUriFull()
    {
        return Safix::getRewrite()->getUri();
    }

    function __call($name, $args)
    {
        if (method_exists($this->_helper, $name)) {
            return call_user_func_array(array($this->_helper, $name), $args);
        }
    }

    function __get($key)
    {
        return (isset($this->_attrs[$key]))? $this->_attrs[$key]: null;
    }

    function __set($key, $value)
    {
        $this->_attrs[$key] = $value;
    }

    function __isset($key)
    {
        return isset($this->_attrs[$key]);
    }

    function __unset($key)
    {
        unset($this->_attrs[$key]);
        return true;
    }

    public function _l($key) {
        return Safix::getLanguage()->getWord($key);
    }
}
