<?php
namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Request, Cookie};
use Core\Attributes\route;
use Verot\Upload\Upload;

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
            "survey" => (object) [
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
            "title" => ["name" => lang("title"), "required" => true, "min" => 8, "max" => 255],
            "about" => ["name" => lang("title"), "min" => 0, "max" => 512],
            "csrf" => ["name" => lang("csrf"), "required" => true],
            #"photo" => ["name" => lang("photo")],
            "data" => ["name" => "data", "required" => true]
        ]);

        if ($validate)
            warning($validate);

        if (!check_csrf($post->csrf))
            warninglang("csrf.error");

        $post->verifyPhone = isset($post->verifyPhone);

        unset($post->csrf);

		$input = Request::files();

		if (! isset($input->photo) || ! $input->photo->name)
			warning("Missing input image!");

		$language = Cookie::instance()->get("lang");
		if($language == "en_US")
			$language = "en_GB";
		
		$upload = new Upload($input->photo->tmp_name, $language);
		if ($upload->uploaded) {

			$fileName = gen_pw() . mt_rand(10000, PHP_INT_MAX) . $post->productId;

			$upload->allowed = array('image/*');
			$upload->file_new_name_body = $fileName;
			$upload->image_convert = "png";
			$upload->process(APP_DIR . '/public/products');

			if ($upload->processed) {

				if ($upload->image_src_x >= 100) {
					$upload->file_new_name_body = $fileName;
					$upload->image_convert = "png";
					$upload->image_resize = true;
					$upload->image_x = 250;
					$upload->image_ratio_y = true;
					$upload->process(APP_DIR . '/public/images/survey/thumbnail');
				}

				$post->photo = $upload->file_dst_name;
			} else {
				warning($upload->error);
			}

			$upload->clean();
		}

        $result = $this->db->from("surveys")->insert((array)$post);
        if($result)
            successlang("data.successfully.changed");
	}
}