<?php


namespace AppBundle\Controller;

use AppBundle\API\PhraseGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PhraseGeneratorController
 * @package AppBundle\Controller
 */
class PhraseGeneratorController extends Controller
{
    /**
     * @Route("/phrase_generator", name="index_phrase")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        var_dump($request->request->all());
        if ($request->request->has('phrase')) {
            $data = PhraseGenerator::i()->create($request->request->get('phrase'));
            $response = new JsonResponse($data['response'], $data['code']);
            $response->send();
            return;
        }

        $data = PhraseGenerator::i()->getAll();
        $response = new JsonResponse($data['response'], $data['code']);
        $response->send();

    }

    /**
     * @Route("/phrase_generator/{id}", name="get_one_phrase", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getPhrase()
    {
        return $this->render('/phrase_generator/one.html.twig');
    }
    
    /**
     * @Route("/phrase_generator/" , name="add_one_phrase")
     *
     * @Method("POST")
     */
    public function addPhrase(Request $request)
    {

    }
    
}