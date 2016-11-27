<?php

class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Returns request string
     */
    private function getURI()
    {
		
        if (!empty($_SERVER['REQUEST_URI'])) {
           // print_r(trim($_SERVER['REQUEST_URI'], '/'));
            return str_replace("site_1", "", trim($_SERVER['REQUEST_URI'], '/'));
            //return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // получаємо радок запиту (URL)
        $uri = $this->getURI();
       // print_r ($uri);
        // обробка запиту у routes.php
        foreach ($this->routes as $uriPattern => $path) {
            
           if (preg_match("~$uriPattern~", $uri)) {
                
               // отримуємо внутрішній шлях із зовнішнього 
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                                
                // визначається контроллер, action, параметри

                $segments = explode('/', $internalRoute);

               // echo $internalRoute;
               // print_r ($segments);
              if ($segments[0]=="")  unset($segments[0]); // видаляємо перші два елементи (залежить від сервера)
              if ($segments[1]=="index.php")  unset($segments[1]); 
             // print_r ($segments);
              // unset($segments[1]);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);  //назва контроллера
                
                //print_r ($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments)); //назва методу у контроллері
                 // print_r ($actionName . '**');

                $parameters = $segments;
                //print_r ($segments ."**");
                
                // підключення файлу класу-контроллера
                $controllerFile = ROOT . '/controllers/' .
                        $controllerName . '.php';
               //print_r ($controllerFile . "**");

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // створюється об'єкт, викликається метод (action)
                $controllerObject = new $controllerName;
		//print_r ($controllerName);
                
                //print_r ($controllerObject);
               $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
		//$result = $controllerObject -> $actionName($parameters);
               // $result = call_user_func_array($parameters, array($controllerObject, $actionName));
                
                if ($result != null) {
                    break;
                }
            }
        }
    }

}
