<?php 
namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Request};
use Core\Attributes\route;

class Settings extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function index()
    {
        $this->view("main", "settings", lang("settings"), ["user" => User::info()]);
    }
}