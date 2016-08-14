<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PhraseGeneratorController extends Controller
{
    /**
     * @Route("/phrase_generator", name="get_all_phrases")
     * @Method("GET")
     */
    public function getPhrasesAction()
    {
        return $this->render('/phrase_generator/all.html.twig');
    }

    /**
     * @Route("/phrase_generator/{id}", name="get_one_phrase", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getPhrase()
    {

    }
}