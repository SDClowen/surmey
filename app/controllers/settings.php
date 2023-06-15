<?php 
namespace App\Controllers;

use Core\{Controller, Request};
use Core\Attributes\route;

class Settings extends Controller
{
    #[route(method: route::get | route::xhr_get)]
    public function index()
    {
        $this->view("main", "settings", lang("settings"));
    }
}