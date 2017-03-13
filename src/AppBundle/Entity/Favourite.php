<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 16:21
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Favourite
*  @ORM\Table(name="favourite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavouriteRepository")
 * @package AppBundle\Entity
 */
class Favourite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;
    /**
     * @var Tweet $tweet
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tweet")
     */
    private $tweet;
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Favourite
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set tweet
     *
     * @param \AppBundle\Entity\Tweet $tweet
     *
     * @return Favourite
     */
    public function setTweet(\AppBundle\Entity\Tweet $tweet = null)
    {
        $this->tweet = $tweet;
        return $this;
    }
    /**
     * Get tweet
     *
     * @return \AppBundle\Entity\Tweet
     */
    public function getTweet()
    {
        return $this->tweet;
    }
}