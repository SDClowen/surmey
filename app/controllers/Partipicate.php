<?php

namespace App\Controllers;

use App\Models\Participator;
use App\Models\Personal;
use App\Models\Survey;
use Core\{Controller, Request, Config, Database};
use Core\Attributes\route;
use App\Models\User;

class Partipicate extends Controller
{
	private const isActive = 1;

	public function index()
	{
		if(!session_check("surveySlug"))
			redirect("/");
	
		$slug = session_get("surveySlug");
		$survey = Survey::exists("slug", $slug);

		#session_destroy();
		if (session_check("tempPin"))
			redirect("/partipicate/pin");

		if (session_check("partipicator"))
			redirect("/d/$slug");

		$this->render("survey/auth", [
			"title" => Config::get()->title." - ".$survey->title,
			"survey" => $survey
		]);
	}

	#[route(method: route::xhr_post, uri: "verify-step1")]
	public function verifyPhone()
	{
		if (session_check("tempPin"))
			warning(redirect: "/partipicate/pin");

		if(!session_check("surveySlug"))
			redirect("/");
	
		$slug = session_get("surveySlug");
		if (session_check("partipicator"))
			warning(redirect: "/d/$slug");

		$surveyId = session_get("surveyId");

		$post = Request::post();
		$validate = validate($post, [
			"phone" => ["name" => "Telefon", "required" => true, "min" => 10, "phone" => "true"],
			"csrf" => ["name" => "token", "required" => true]
		]);

		if (! check_csrf($post->csrf))
			warning("TOKEN_ERROR - Sayfayı yenileyip tekrar deneyin");

		if ($validate)
			warning($validate);

		$post->phone = str_replace(["(", ")", " "], "", $post->phone);

		$personalId = Personal::exists($post->phone);
		if (! $personalId)
			warning("Personel bulunamadı!");

		if (Participator::checkSurveyIsPartipicated($surveyId, $personalId, isDone: true))
			warning("Bu anketi daha önce zaten cevapladınız!");

		# find a unique usable pin for the participator
		while (Participator::checkToken(($pin = join(randomSequence(6)))));

		$post->pin = $pin;
		$tokenTime = time();

		$last4 = substr($post->phone, strlen($post->phone) - 4, strlen($post->phone));

		# set temporary pin value to session as tempPin
		session_set("tempPin", (object) [
			"token" => hash("sha256", $pin),
			"time" => $tokenTime,
			"phone" => $post->phone,
			"phoneLastNum4" => substr($last4, 0, 2) . " " . substr($last4, 2, 4)
		]);

		$answerId = Participator::answerExists($surveyId, $personalId);
		if (!$answerId)
			$result = $this->db->from("answers")->insert([
				"surveyId" => $surveyId,
				"personalId" => $personalId,
				"token" => $pin,
				"tokenTime" => $tokenTime
			]);
		else
			$result = $this->db->from("answers")
				->where("id", "=", $answerId)
				->update([
					"token" => $pin,
					"tokenTime" => $tokenTime,
					"done" => false
				]);

		#\SmsHelper::send($post->phone, "HAUS - Çalışma saatleri değerlendirme anketi onay kodu: ". $pin);
		if ($result)
			success(redirect: "/partipicate/pin");

		getDataError();
	}

	#[route(method: route::xhr_get | route::get)]
	public function pin()
	{
		if (!session_check("tempPin"))
			redirect("/");

		$tempPin = session_get("tempPin");
		if (! $tempPin)
			redirect("/");

		$elapsedTime = time() - $tempPin->time;
		if ($elapsedTime > 120) {
			session_destroy();
			redirect("/");
		}

		$this->render("survey/pin", [
			"title" => "Telefon Onayı",
			"pin" => $tempPin,
			"time" => $tempPin->time
		]);
	}

	#[route(method: route::xhr_post, uri: "pin")]
	public function verifyPin()
	{
		if(!session_check("surveySlug"))
			redirect("/");
	
		$slug = session_get("surveySlug");
		if (session_check("partipicator"))
			warning(redirect: "/d/$slug");

		$post = Request::post();
		$validate = validate($post, [
			"pin" => ["name" => "pin", "required" => true, "min" => 6, "max" => 6],
			"token" => ["name" => "token", "required" => true, "min" => 64, "max" => 64],
			"csrf" => ["name" => lang("security.code"), "required" => true]
		]);

		if ($validate)
			error($validate);
		elseif (! check_csrf($post->csrf))
			errorlang("csrf.error");

		$tempPin = session_get("tempPin");
		if ($post->token != $tempPin->token)
			error("UNDEFINED_TOKEN");
		elseif (hash("sha256", $post->pin) != $tempPin->token)
			errorlang("pin.error");

		if (! ($partipicatorInfo = Participator::checkToken($post->pin)))
			warninglang("pin.error");

		session_remove("tempPin");

		#session_regenerate_id(true);

		session_set("partipicator", $partipicatorInfo);
		success(redirect: "/d/$slug");
	}

	#[route(method: route::xhr_post, session: "partipicator", uri: "answer-survey")]
	public function answerSurvey()
	{
		if(!session_check("surveySlug"))
			redirect("/");
	
		$slug = session_get("surveySlug");
		if (!session_check("partipicator"))
			warning(redirect: "/d/$slug");

		$post = Request::post();

		$rules = validate($post, [
			"answer" => ["name" => "Cevap", "numeric" => true, "min" => 0, "max" => 1]
		]);

		if ($rules)
			warning($rules);

		$user = session_get("partipicator");

		if (Participator::checkSurveyIsPartipicated($user->personalId, true))
			warning("Bu anketi daha önce zaten cevapladınız!");

		$result = Database::get()->from("answers")
			->where("personalId", "=", $user->personalId)
			->update([
				"answer" => $post->answer,
				"done" => true
			]);

		if ($result) {
			session_destroy();
			successlang("survey.successfully.answered", redirect: "/:2000");
		}

		getDataError();
	}
}