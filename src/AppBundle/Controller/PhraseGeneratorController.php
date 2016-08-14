<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PhraseGeneratorController
{
    /*
     * @Route("/phrase_generator")
     */
    public function getPhrasesAction()
    {
        return new Response(
          '<html><body>Test</body></html>'
        );
    }

}