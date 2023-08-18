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

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function create()
    {
        $this->view("main", "survey-crud", lang("create.survey"), [
            "url" => "apply",
            "surveyFormTitle" => lang("create.survey"),
            "user" => User::info(),
            "showIfOnEditMode" => false
        ]);
    }

    /**
     * Create or Update survey
     */
    #[route(method: route::xhr_post, uri: "apply", session: "user")]
    public function apply(int $id = 0)
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

        if (isset($input->photo) && $input->photo->name) {
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
        }

        $result = false;

        $randomString = function ($length) {

            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $index = rand(0, strlen($chars) - 1);
                $randomString .= $chars[$index];
            }

            return $randomString;
        };

        if ($id == 0) {
            $post->userId = User::id();
            $post->slug = $randomString(5);
            $result = $this->db->from("surveys")->insert((array) $post);
        } else
            $result = $this->db->from("surveys")->where("id", "=", $id)->update((array) $post);

        if ($result)
            successlang("data.successfully.changed");

        getDataError();
    }

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function edit(int $surveyId)
    {
        if (! $surveyId)
            warning("DATA_WAS_ZERO");

        $result = Survey::exists("id", $surveyId);
        if (! $result)
            warning("DATA_NOT_FOUND");

        $data = $result->data;
        unset($result->data);

        $result = data_json($result);

        $isOnEditMode = Request::segments()[1] == "edit";
        $surveyFormTitle = $isOnEditMode ? lang("edit.survey") : lang("create.survey");

        $this->view("main", "survey-crud", $surveyFormTitle, [
            "user" => User::info(),
            "surveyFormTitle" => $surveyFormTitle,
            "url" => $isOnEditMode ? "apply/$surveyId" : "apply",
            "showIfOnEditMode" => $isOnEditMode ? "<script>$(()=>{window.prepareSurveyForEditing('$result', '$data')})</script>" : ""
        ]);
    }

    #[route(method: route::get | route::xhr_get, session: "user")]
    public function delete(int $surveyId)
    {
        if (! $surveyId)
            warning("DATA_WAS_ZERO");

        $result = Survey::exists("id", $surveyId);
        if (! $result)
            warning("DATA_NOT_FOUND");

        $isUpdated = Survey::update($surveyId, [
            "status" => 2
        ]);

        if($isUpdated)
            success();

        getDataError();
    }
}