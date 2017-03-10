<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 10:32.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Tweet;

/**
 * TweetManager.
 * Service gérant plusieurs actions concernant la gestion des Tweets.
 */
class TweetManager
{
    private $doctrineManager;
    private $tweetNbLast;

    public function __construct($doctrineManager, $tweetNbLast)
    {
        $this->doctrineManager = $doctrineManager;
        $this->tweetNbLast = $tweetNbLast;
    }

    public function create()
    {
        return new Tweet();
    }

    public function save(Tweet $tweet)
    {
        $this->doctrineManager->persist($tweet);
        $this->doctrineManager->flush();
    }

    public function getTweet($id)
    {
        return $this->getRepository()->getTweet($id);
    }

    public function getLast()
    {
        return $this->getRepository()->getLastTweets($this->tweetNbLast);
    }

    private function getRepository()
    {
        return $this->doctrineManager->getRepository(Tweet::class);
    }
}
