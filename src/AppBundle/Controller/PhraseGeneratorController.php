<?php


namespace AppBundle\Controller;

use AppBundle\API\PhraseGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhraseGeneratorController extends Controller
{
    /**
     * @Route("/phrase_generator", name="index_phrase")
     * @Method("GET")
     */
    public function indexAction()
    {
        $data = PhraseGenerator::i()->getAll();
        $status_code = $data['code'];
        $response = new JsonResponse($data['response'], $status_code);
        $response->send();
    }

    /**
     * @Route("/phrase_generator/{id}", name="get_one_phrase",
     *                                  requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getPhrase()
    {
        return $this->render('/phrase_generator/one.html.twig');
    }
    
    /**
     * @Route("/phrase_generator/, name="add_one_phrase")
     * 
     * @Method("POST")
     */
    public function addPhrase(Request $request)
    {
        if ($request->has('phrase')) {
            $res = PhraseGenerator::i()->create($request->get('phrase'));
        }
    }
    
}