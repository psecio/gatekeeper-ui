<?php

namespace GatekeeperUI\View;

class TemplateView extends \Slim\Views\Twig
{
	public function render($template, $data = null)
	{
		if (ACCEPT_JSON) {
			echo json_encode($data);
		} else {
			echo parent::render($template, $data);
		}
	}
}