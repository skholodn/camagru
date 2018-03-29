<?php

class Controller
{
    public $view;
    protected $model;

    function __construct()
    {
        $this->view = new View();
    }

    /**
	 * Magic method called when a non-existent or inaccessible method is
	 * called on an object of this class. Used to execute before and after
	 * filter methods on action methods. Action methods need to be named
	 * with an "Action" suffix, e.g. indexAction, showAction etc.
	 *
	 * @param string $name  Method name
	 * @param array $arguments Arguments passed to the method
	 *
	 * @return void
	 */
	public function __call($name, $arguments)
	{
		$method = "action".$name;

		if (method_exists($this, $method)) {
			if ($this->before() !== false) {
				call_user_func_array([$this, $method], $arguments);
			}
		} else {
			header('Location: /404');
			exit();
		}
	}

	/**
	 * Before filter - called before an action method.
	 *
	 * @return void
	 */
	protected function before()
	{
	}
}