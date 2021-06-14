<?php

namespace GoNetwork\Core;

class View
{
    protected static $mainLayout = "layouts/main";

    /**
     *
     * @param string $__vista
     * @param array $__data
     * @param null|string
     * @todo
     */
    public static function render($__vista, $__data = [], $layout = null)
    {
        $layout = $layout ?? self::$mainLayout;

        ob_start();
        
        foreach ($__data as $key => $value) {
            ${$key} = $value;
        }

        require App::getViewsPath() . "/" . View::$mainLayout . ".php";

        $__content__ = ob_get_contents();
        ob_clean();

        require App::getViewsPath() . "/" . $__vista . ".php";

        $__view__ = ob_get_contents();

        ob_end_clean();

        $__content__ = str_replace("@{{content}}", $__view__, $__content__);

        echo $__content__;
    }

    /**
     *
     * @param mixed $data
     */
    public static function renderJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}