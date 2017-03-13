<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 10:32.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Tweet;
use Doctrine\ORM\EntityManagerInterface;

/**
 * TweetManager.
 * Service gérant plusieurs actions concernant la gestion des Tweets.
 */
class TweetManager
{
    private $doctrineManager;
    private $tweetNbLast;

    /**
     * TweetManager constructor.
     * @param EntityManagerInterface $doctrineManager
     * @param int $tweetNbLast
     */
    public function __construct(EntityManagerInterface $doctrineManager, $tweetNbLast = 10)
    {
        $this->doctrineManager = $doctrineManager;
        $this->tweetNbLast = $tweetNbLast;
    }

    /**
     * @return Tweet
     */
    public function create()
    {
        return new Tweet();
    }

    /**
     * @param Tweet $tweet
     */
    public function save(Tweet $tweet)
    {
        if(null === $tweet->getId())
        {
            $this->doctrineManager->persist($tweet);
        }
        $this->doctrineManager->flush();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTweet($id)
    {
        return $this->getRepository()->getTweet($id);
    }

    /**
     * @return array
     */
    public function getLast()
    {
        return $this->getRepository()->getLastTweets($this->tweetNbLast);
    }

    /**
     * @return \AppBundle\Repository\TweetRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        return $this->doctrineManager->getRepository(Tweet::class);
    }
}
