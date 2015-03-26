<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

class ContactController
{

	public function getForm(Request $request, Application $app){
		$data = array(
        	"menu" => $app["mainMenu"]->getData(), 
        	"status" => $app["session"]->get("contact_status", NULL), 
        	"errors" => $app["session"]->get("contact_errors", NULL), 
        	"error_mail" => $app["session"]->get("error_mail", NULL), 
        	"data_form" => $app["session"]->get("contact_data_form", NULL)
   		);

   		$this->resetStatus($app);	

    	return $app["twig"]->render('contact/index.html', $data);
	}

	public function postMessage(Request $request, Application $app){

		$redirect = "";
		$errors = array();

		$this->resetStatus($app);

		$campos = array(
			"name" => $request->request->get("name"), 
			"email" => $request->request->get("email"), 
			"message" => $request->request->get("message"), 
			"topic" => $request->request->get("topic", "Ninguno")
		);

		$constraint = new Assert\Collection(array(
			"name" => new Assert\NotBlank(), 
			"email" => array(new Assert\NotBlank(), new Assert\Email()), 
			"message" => new Assert\NotBlank(), 
			"topic" => new Assert\NotBlank()
		));

		$errors_validator = $app["validator"]->validateValue($campos, $constraint);

		if(count($errors_validator) == 0){
			if($this->sendEmail($app, $campos)){
				$app["session"]->set("contact_status", "success");
			}
			else{
				$app["session"]->set("contact_status", "fail");
				$app["session"]->set("error_mail", true);
			}
		}
		else{
			//Guardamos los errores en una variable más cómoda para leer con TWIG
			foreach($errors_validator as $error){
				//errors["[field]"] = "error message"
				$errors[$error->getPropertyPath()] = $error->getMessage();
			}

			$app["session"]->set("contact_status", "fail");
			$app["session"]->set("contact_errors", $errors);
			$app["session"]->set("contact_data_form", $campos);
		}


		return $app->redirect($app["url_generator"]->generate("contacta"));
	}

	protected function sendEmail($app, $data){

		$body = $app["twig"]->render("contact/contact-email.html", $data);

	    $message = \Swift_Message::newInstance()
	        ->setSubject('Formulario de contacto')
	        ->setFrom(array($data["email"]))
	        ->setTo(array(OWNER_MAIN_EMAIL))
	        ->setBody($body);

	    return $app['mailer']->send($message);

	}

	protected function resetStatus($app){
		$app["session"]->remove("contact_status");
		$app["session"]->remove("contact_errors");
		$app["session"]->remove("contact_data_form");
		$app["session"]->remove("error_mail");
	}

}