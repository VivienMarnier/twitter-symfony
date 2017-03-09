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
        $tweets = $this->getDoctrine()->getManager()->getRepository(Tweet::class)->getLastTweets($this->getParameter('app.tweet.nb_last', 10));

        return $this->render(':tweet:list.html.twig', ['tweets' => $tweets]);
    }

    /**
     * @Route("/tweet/{id}", name="app_tweet_view")
     */
    public function viewAction($id)
    {
        $tweet = $this->getDoctrine()->getManager()->getRepository(Tweet::class)->getTweet($id);
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
        $form = $this->createForm(TweetType::class, new Tweet()); // retourne un objet Form
        $form->handleRequest($request);
        if ($form->isValid()) {
            $tweet = $form->getData();
            $this->getDoctrine()->getManager()->persist($tweet);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre Tweet a été crée !');

            return $this->redirectToRoute('app_tweet_view', ['id' => $tweet->getId()]);
        }

        return $this->render(':tweet:new.html.twig', ['form' => $form->createView()]);
    }
}
