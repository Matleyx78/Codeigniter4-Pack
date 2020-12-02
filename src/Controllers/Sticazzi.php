<?php namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;

class Sticazzi extends BaseController
{
	use \CodeIgniter\API\ResponseTrait;

	/**
	 * Display informations page
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse|string
	 */
	public function index()
	{
		echo 'controller sticazzi';
	}

}
