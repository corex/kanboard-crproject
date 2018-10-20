<?php

namespace Kanboard\Plugin\CRProject\Helper;

use Kanboard\Core\Base;

class Request extends Base
{
    /**
     * Controller.
     *
     * @return string
     */
    public function controller()
    {
        return $this->routeValue('controller');
    }

    /**
     * Action.
     *
     * @return string
     */
    public function action()
    {
        return $this->routeValue('action');
    }

    /**
     * Plugin.
     *
     * @return string
     */
    public function plugin()
    {
        return $this->routeValue('plugin');
    }

    /**
     * Route.
     *
     * @return array
     */
    public function route()
    {
        $request = $this->request;

        $result = [
            'controller' => $request->getStringParam('controller'),
            'action' => $request->getStringParam('action'),
            'plugin' => $request->getStringParam('plugin')
        ];

        // If url rewrite and uri specified, set request.
        if (ENABLE_URL_REWRITE) {
            $uri = $this->uri();
            if ($uri !== null) {
                $result = $request->route->findRoute($uri);
            }
        }

        return $result;
    }

    /**
     * Uri.
     *
     * @return string
     */
    public function uri()
    {
        $uri = $this->request->getUri();

        // Remove query string if present.
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }

        if (trim($uri, '/') == '') {
            $uri = null;
        }

        return $uri;
    }

    /**
     * Route value.
     *
     * @param string $property
     * @param mixed $default
     * @return mixed
     */
    private function routeValue($property, $default = null)
    {
        $route = $this->route();
        if (!is_array($route)) {
            $route = array();
        }
        if (array_key_exists($property, $route)) {
            return $route[$property];
        }
        return $default;
    }
}