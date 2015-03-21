<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller {

	public function getHome()
    {
        return view('site.home');
    }

}
