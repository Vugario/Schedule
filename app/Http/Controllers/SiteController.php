<?php namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller {

	public function getHome()
    {
        $days = [];
        $items = Entry::query()->where('visit_at', '>=', Carbon::now()->setTime(0, 0))->orderBy('visit_at')->get();

        foreach ($items as $item)
        {
            $days[$item->visit_at->format('d-m')][] = $item;
        }

        return view('site.home', compact('days'));
    }

}
