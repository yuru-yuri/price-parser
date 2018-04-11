<?php

namespace App\Bundles\Frontend\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{

    public function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        return parent::render($view, $parameters + [
                'profile' => $this->getUser(),
            ], $response);
    }

}
