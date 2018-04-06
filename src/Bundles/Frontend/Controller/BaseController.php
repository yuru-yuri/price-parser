<?php

namespace App\Bundles\Frontend\Controller;

use Intervention\Image\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{

    public function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        return parent::render($view, $parameters + [
                'i' => $this->getUser(),
            ], $response);
    }

}
