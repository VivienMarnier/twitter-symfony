<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/03/2017
 * Time: 14:15.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Tweet;
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
}
