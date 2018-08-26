<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Core\Page;
use App\Core\Product;
use App\Core\Shop;
use App\Core\Collection;
use App\Core\Account;
use App\Core\Basket;

class ViewShare {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('current_routename', Route::getCurrentRoute()->getName());
        view()->share('current_fullurl', str_replace(config('app.url'), '', $request->fullUrl()));
        view()->share('full_page', false);
        view()->share('body_class', 'sidebar-mini');

        return $next($request);
    }
}
