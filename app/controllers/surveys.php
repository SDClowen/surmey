<?php
namespace App\Controllers;

use App\Models\{User, Survey};
use Core\{Controller, Request, Cookie};
use Core\Attributes\route;
use Verot\Upload\Upload;

class Surveys extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user")]
    public function index()
    {
        $user = User::info();

        $this->view("main", "survey", lang("survey"), [
            "user" => $user,
            "surveys" => Survey::all($user->id)
        ]);
    }

    #[route(method: route::get, session: "user")]
    public function participate($token)
    {
        $this->render("participate", [
            "title" => "Welcome - Surmey",
            "survey" => (object) [
                "title" => "Thanks for participating to this survey!",
                "token" => $token
            ]
        ]);
    }

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function create()
    {
        $this->view("main", "survey-crud", lang("create.survey"), ["user" => User::info()]);
    }

    #[route(method: route::xhr_post, uri: "create", session: "user")]
    public function createAjax()
    {
        $post = Request::post();
        $validate = validate($post, [
            "title" => ["name" => lang("title"), "required" => true, "min" => 8, "max" => 255],
            "about" => ["name" => lang("title"), "min" => 0, "max" => 512],
            "csrf" => ["name" => lang("csrf"), "required" => true],
            #"photo" => ["name" => lang("photo")],
            "data" => ["name" => "data", "required" => true]
        ]);

        if ($validate)
            warning($validate);

        if (! check_csrf($post->csrf))
            warninglang("csrf.error");

        $post->verifyPhone = (int) isset($post->verifyPhone);

        unset($post->csrf);

        $input = Request::files();

        if (! isset($input->photo) || ! $input->photo->name)
            warning("Missing input image!");

        $language = Cookie::instance()->get("lang");
        if ($language == "en_US")
            $language = "en_GB";

        $upload = new Upload($input->photo->tmp_name, $language);
        if ($upload->uploaded) {

            $fileName = gen_pw() . mt_rand(10000, PHP_INT_MAX) . _e($post->title);

            $upload->allowed = array('image/*');
            $upload->file_new_name_body = $fileName;
            $upload->image_convert = "png";
            $upload->process(ROOT_DIR . '/public/images/survey');

            if ($upload->processed) {

                if ($upload->image_src_x >= 100) {
                    $upload->file_new_name_body = $fileName;
                    $upload->image_convert = "png";
                    $upload->image_resize = true;
                    $upload->image_x = 250;
                    $upload->image_ratio_y = true;
                    $upload->process(ROOT_DIR . '/public/images/survey/thumbnail');
                }

                $post->photo = $upload->file_dst_name;
            } else {
                warning($upload->error);
            }

            $upload->clean();
        }

        $post->userId = User::id();
        $result = $this->db->from("surveys")->insert((array) $post);
        if ($result)
            successlang("data.successfully.changed");
    }

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function edit(int $surveyId)
    {
        $data = $this->db->from("surveys")->where("id", "=", $surveyId)->result();
        if (! $data)
            warning("DATA_NOT_FOUND");

        $isOnEditMode = Request::segments()[1] == "edit";

        $this->view("main", "survey-crud", lang("create.survey"), [
            "user" => User::info(), 
            "showIfOnEditMode" => $isOnEditMode ? "<script>$(()=>{window.renderSurvey('".data_json((array)$data)."')})</script>" : ""
        ]);
    }
}