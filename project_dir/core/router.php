<?php

class Router
{

	protected $routes = [];

	public function __construct()
	{
		$this->routes = Config::ROUTES;
	}

	private function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run()
	{
		Session::start();
		// get URI string
		$uri = $this->getURI();
		// check request for routes
		foreach($this->routes as $uriPattern => $path) {
			// on coincidence, determine controller and action

			if (preg_match("~$uriPattern~", $uri)) {
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				$segments = explode('/', $internalRoute);
				$controllerName = ucfirst(array_shift($segments)).'Controller';
				$actionName = 'action'.ucfirst(array_shift($segments));

				$parameters = $segments;


				$controllerFile = ROOT.'/../app/controllers/'.$controllerName.'.php';
				// Include file Controller class
				if (file_exists($controllerFile)){
					include_once($controllerFile);
				}
				// create object, raise method (action)
				$controllerObject = new $controllerName;
				$result = call_user_func_array(array($controllerObject, $actionName),
					$parameters);
				if ($result != null) {
					return ;
				}
			}
		}
	}
		
	public static function goPath($path) {
		return '//' . $_SERVER['HTTP_HOST'] . $path;
	}
}