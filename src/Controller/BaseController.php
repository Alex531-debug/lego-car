<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('app.html.twig', ['basePath' => $request->getBasePath()]);
    }
}