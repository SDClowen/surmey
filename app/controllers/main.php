<?php
namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Request};
use Core\Attributes\route;

class Main extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function index()
    {
        $this->view("main", "dashboard", "Surmey");
    }

    public function auth()
    {
        if (session_check("user"))
            redirect("/");

        $this->render("auth", [
            "title" => lang("login.required")
        ]);
    }

    #[route(method: route::xhr_post, uri: "auth")]
    public function authAjax()
    {
        if (session_check("user"))
            errorlang("authorize.error");

        $post = Request::post();
        $check = validate($post, [
            "userNameOrEmail" => ["name" => lang("username.or.email"), "required" => true, "dash" => true],
            "password" => ["name" => lang("password"), "required" => true, "min" => 6, "max" => 32],
            "csrf" => ["name" => lang("security.code"), "required" => true]
        ]);


        if ($check)
            error($check);
        elseif (! check_csrf($post->csrf))
            errorlang("csrf.error", scrollTo: true);

        $isEmail = strpos($post->userNameOrEmail, "@");
        if ($isEmail && ! validate_email($post->userNameOrEmail))
            error(lang("validation.email_error"));

        if (! $isEmail && ! alpha_dash($post->userNameOrEmail))
            error(lang("validation.alpha.dash.error", lang("username.or.email")));

        $password = hash("sha256", $post->password);

        $memberDetail = User::validateAuth($post->userNameOrEmail, $password);

        if (! $memberDetail)
            error(lang("wrong.auth.info"));

        session_regenerate_id(true);

        session_set("user", $memberDetail);
        success(redirect: "/");
    }

    #[route(method: route::xhr_post, uri: "change-password", session: "user")]
    public function changePassword()
    {
        $post = Request::post();
        $validate = validate($post, [
            "password" => ["name" => lang("password"), "required" => true, "min" => 6, "max" => 32],
            "newPassword" => ["name" => lang("new.password"), "required" => true, "min" => 6, "max" => 32, "no-match" => "password"],
            "newPasswordConfirm" => ["name" => lang("new.password.confirm"), "required" => true, "min" => 6, "max" => 32, "match" => "newPassword"]
        ]);

        if ($validate)
            warning($validate);

        $post->password = hash("sha256", $post->password);
        $post->newPassword = hash("sha256", $post->newPassword);

        $info = User::info();

        if ($post->password != $info->password)
            warninglang("password.not.correct");
        elseif ($post->newPassword == $info->prevPassword)
            warninglang("password.used.before");

        $result = User::update([
            "prevPassword" => $info->password,
            "password" => $post->newPassword
        ]);

        if ($result) {
            $this->logout();
            successlang("password.successfully.changed", redirect: "/auth:2000");
        }

        getDataError();
    }

    #[route(method: route::get | route::xhr_get)]
    function logout()
    {
        session_remove("user");
        session_destroy();
        success(redirect: "/");
    }
}