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
                'user' => $this->getUser(),
                'image_sizes' => $this->getParameter('image_sizes'),
                'image_manager' => new ImageManager(['driver' => $this->getParameter('image_driver')]),
                'project_dir' => $this->get('kernel')->getRootDir(),
            ], $response);
    }

}
