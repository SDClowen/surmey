<?php 
namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Request};
use Core\Attributes\route;

class Surveys extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user")]
    public function index()
    {
        $this->view("main", "survey", lang("survey"), ["user" => User::info()]);
    }
    
    #[route(method: route::get, session: "user")]
    public function participate($token)
    {
        $this->render("participate", [
            "title" => "Welcome - Surmey",
            "survey" => (object)[
                "title" => "Thanks for participating to this survey!",
                "token" => $token
            ]
        ]);
    }

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function create()
    {
        $this->view("main", "create-survey", lang("create.survey"), ["user" => User::info()]);
    }
    
    #[route(method: route::xhr_post, uri: "create", session: "user")]
    public function createAjax()
    {
        $post = Request::post();
        $validate = validate($post, [
            "title" => ["name" => lang("title"), "required" => true, "min" => 8, "max" => 250],
            "csrf" => ["name" => lang("csrf"), "required" => true],
            "photo" => ["name" => lang("photo")],
            "data" => ["name" => "data", "required" => true]
        ]);

        if($validate)
            warning($validate);

        $post->confirmPhone = isset($post->confirmPhone);

        successlang("data.successfully.changed");
    }
}