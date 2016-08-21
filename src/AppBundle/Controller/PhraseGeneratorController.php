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
        if ($request->request->has('phrase')) {
            $data = PhraseGenerator::i()->create($request->request->get('phrase'));
            $response = new JsonResponse($data['response'], $data['code']);
            return $response->send();
        }

        $data = PhraseGenerator::i()->getAll();
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();

    }

    /**
     * @Route("/phrase_generator/{id}", name="get_one_phrase", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getPhrase($id)
    {
        $data = PhraseGenerator::i()->get($id);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }

    /**
     * @Route("/phrase_generator/{id}", name="update_one_phrase", requirements={"id": "\d+"})
     * @Method("PUT")
     */
    public function updatePhrase(Request $request, $id) {
        $update_data['phrase'] = $request->get('phrase');
        $update_data['id'] = $id;
        $data = PhraseGenerator::i()->update($update_data);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }

    /**
     * @Route("/phrase_generator/{id}", name="remove_one_phrase", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deletePhrase($id) {
        $data = PhraseGenerator::i()->delete($id);
        $response = new JsonResponse($data['response'], $data['code']);
        return $response->send();
    }
}