<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/03/2017
 * Time: 14:15.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Tweet;
use AppBundle\Form\TweetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TweetController extends Controller
{
    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        // replace this example code with whatever you need
        $tweets = $this->getTweetManager()->getLast();

        return $this->render(':tweet:list.html.twig', ['tweets' => $tweets]);
    }

    /**
     * @Route("/tweet/{id}", name="app_tweet_view")
     */
    public function viewAction($id)
    {
        $tweet = $this->getTweetManager()->getTweet($id);
        if (!$tweet instanceof Tweet) {
            throw $this->createNotFoundException(sprintf('Le Tweet d\'id : %s n\'existe pas !', $id));
        }

        return $this->render(':tweet:view.html.twig', ['tweet' => $tweet]);
    }

    /**
     * @Route("/tweet/new/", name="app_tweet_new", methods={"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(TweetType::class, $this->getTweetManager()->create()); // retourne un objet Form
        $form->handleRequest($request);
        if ($form->isValid()) {
            $tweet = $form->getData();
            $this->getTweetManager()->save($tweet);
            $this->getEmailMessenger()->sendTweetCreated($tweet);
            $this->addFlash('success', 'Votre Tweet a été crée !');

            return $this->redirectToRoute('app_tweet_view', ['id' => $tweet->getId()]);
        }

        return $this->render(':tweet:new.html.twig', ['form' => $form->createView()]);
    }

    private function getTweetManager()
    {
        return $this->get('app.tweet_manager');
    }

    private function getEmailMessenger()
    {
        return $this->get('app.email_messenger');
    }
}
