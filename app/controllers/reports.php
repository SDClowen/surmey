<?php 
namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Request};
use Core\Attributes\route;

class Reports extends Controller
{
    #[route(method: route::get | route::xhr_get)]
    public function index()
    {
        $this->view("main", "reports", lang("reports"), ["user" => User::info()]);
    }
}