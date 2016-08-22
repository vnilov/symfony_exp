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
        $generator = $this->get('phrase_generator');
        if ($request->request->has('phrase')) {
            $data = $generator->create($request->request->get('phrase'));
            $response = new JsonResponse($data['response'], $data['code']);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response->send();
        }

        $data = $generator->getAll();
        $response = new JsonResponse($data['response'], $data['code']);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response->send();

    }

    /**
     * @Route("/phrase_generator/{id}", name="get_one_phrase", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getPhrase($id)
    {
        $generator = $this->get('phrase_generator');
        $data = $generator->get($id);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }

    /**
     * @Route("/phrase_generator/{id}", name="update_one_phrase", requirements={"id": "\d+"})
     * @Method("PUT")
     */
    public function updatePhrase(Request $request, $id) {
        $generator = $this->get('phrase_generator');
        $update_data['phrase'] = $request->get('phrase');
        $update_data['id'] = $id;
        $data = $generator->update($update_data);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }

    /**
     * @Route("/phrase_generator/{id}", name="remove_one_phrase", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deletePhrase($id) {
        $generator = $this->get('phrase_generator');
        $data = $generator->delete($id);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }
}