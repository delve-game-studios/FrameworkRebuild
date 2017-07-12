<?php

namespace System;
use \Application\Models;

class Route extends Application {
	public static $_route;
    private $rootPath = '';

    public function __construct($root) {
        $this->rootPath = $root;
        $model = Models\Route::model();
        $routes = $model->getCustomRoutes();

        self::$_route = array_merge(self::$_route, $routes);
    }

    private function getBaseDir() {
        return end(explode('/', $this->rootPath));
    }
    
    public function executeRoute($app) {
        $_SERVER['REQUEST_URI'] = preg_replace('/\?.*$/is', '', $_SERVER['REQUEST_URI']);
        $route_path_pattern = '/^' . preg_quote($this->rootPath, '/') . '/i';

        $route_path = preg_replace(
            $route_path_pattern, 
            '', 
            parse_url($_SERVER['REQUEST_URI'], 5)
        );

        $GLOBALS['route_path'] = $route_path;
    
        if (!$route_path) {
            $route_path = '/';
        }

        $segments = $this->urlEval($route_path);

        
        $application = $app;

        $controller = null;
        $action = null;

        if ($segments) {

            if($segments['controller'] != 'Application') {
                $controllerFile = $this->rootPath . '/Controllers/' . $segments['controller'] . '.controller.php';
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                }
            }

            $segments['namespaceController'] = "{$segments['namespace']}{$segments['controller']}";

            if (class_exists($segments['namespaceController'])) {
                $controllerObject = null;

                if($segments['controller'] != 'Application') {
                    if($segments['action'] === 'showDynamic') {
                        $controllerObject = new $segments['namespaceController']($app, true);
                    } else {
                        $controllerObject = new $segments['namespaceController']($app);
                    }
                } else {
                    $controllerObject = $application;
                }

                if (is_subclass_of($controllerObject, 'System\Application')) {
                    $controller = $controllerObject;

                    if (method_exists($controller, $segments['action']) && is_callable(array($controller, $segments['action']))) {
                        $action = $segments['action'];
                    }
                }
            }
        }
        parent::$currentRoute = $segments;

    
       if(!is_null($controller) && !is_null($action)) {
            $controller->$action();
        }
    }

    public function urlEval($path) {
        $segments = false;
	      $route = self::$_route;
        foreach ($route as $key => $execution) {
            if (preg_match('@^' . preg_replace('/:[^\/]+/i', '[^\/]+', $key) . '(\/|)$@i', $path)) {

                $segments = $execution;

                $route_segments = $this->urlSegmentation($key);
                $path_segments = $this->urlSegmentation($path);
                foreach ($route_segments as $val) {
                    if (is_integer(strpos($val, ':')) && strpos($val, ':') == 0) {
                        $segments[str_ireplace(':', '', $val)] = current($path_segments);
                    }
                    next($path_segments);
                }
                break;
            }
        }
        if ($segments) {
            $segments_ = $segments;
            unset($segments_[0]);
            $_REQUEST = array_merge($_REQUEST, $segments_);
        }
	    return $this->fixSegments($segments);
    }

    public function urlSegmentation($path) {
        $segments = explode('/', $path);
        unset($segments[0]);

        return $segments;
    }

    private function fixSegments($_tmpSegments) {
        $default = $_tmpSegments[0];
        $segments = array('controller' => '', 'namespace' => '', 'action' => '');

        $arr = explode("\\", $default);
        $lastEl = explode("::", $arr[count($arr) - 1]);
        
        if(is_array($lastEl) && !empty($lastEl) && count($lastEl) > 1) {
  
          $segments['controller'] = $lastEl[0];
          $segments['action'] = "show{$lastEl[1]}";
          unset($arr[count($arr) - 1]);
  
          foreach($arr as $k => $v) {
              $segments['namespace'] .= "$v\\";
          }
          $segments['namespace'] .= "\\Application\Controllers\\";
  
          foreach($_tmpSegments as $key => $val) {
              if(!in_array($key, array('action','controller'))) $segments[$key] = $val;
              unset($_tmpSegments[$key]);
          }
          return $segments;
        }
        return $_tmpSegments;
    }
}

?>