<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/03/2017
 * Time: 14:15.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Favourite;
use AppBundle\Entity\Tweet;
use AppBundle\Form\TweetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class TweetController extends Controller
{
    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(':tweet:list.html.twig', ['tweets' => $this->getTweetManager()->getLast()]);
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
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getTweetManager()->save($form->getData());
            $this->getEmailMessenger()->sendTweetCreated($form->getData());
            $this->addFlash('success', 'Votre Tweet a été crée !');

            return $this->redirectToRoute('app_tweet_view', ['id' => $form->getData()->getId()]);
        }

        return $this->render(':tweet:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tweet/favourite/", name="app_tweet_favourite")
     */
    public function favouriteAction(Request $request)
    {
        return $this->render(':tweet:favourite.html.twig', ['favourites' => $this->getFavouriteManager()->getFavouritesTweetByUser($this->getUser())]);
    }
    /**
     * @Route("/tweet/newFavourite/", name="app_tweet_add_favourite")
     */
    public function addFavouriteAction(Request $request)
    {

    }
    /**
     * @Route("/tweet/deleteFavourite/{id}", name="app_tweet_delete_favourite")
     * @ParamConverter("post", class="Appbundle:")
     */
    public function deleteFavouriteAction(Favourite $favourite)
    {
        //Access denied for another user trying to delete the favourite
        if($favourite->getId() != $this->getUser()->getId())
        {
            $this->createAccessDeniedException();
        }
        $this->getFavouriteManager()->deleteFavourite($favourite);
        return $this->redirectToRoute('app_tweet_favourite');

    }
    private function getTweetManager()
    {
        return $this->get('app.tweet_manager');
    }

    private function getEmailMessenger()
    {
        return $this->get('app.email_messenger');
    }
    private function getFavouriteManager()
    {
        return $this->get('app.favourite_manager');
    }
}
