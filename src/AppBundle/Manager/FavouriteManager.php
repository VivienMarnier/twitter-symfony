<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 16:54
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Favourite;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FavouriteManager
{
    private $doctrineManager;

    public function __construct(EntityManagerInterface $doctrineManager)
    {
        $this->doctrineManager = $doctrineManager;
    }

    /**
     * @return Favourite
     */
    public function create()
    {
        return new Favourite();
    }
    public function save(Favourite $favourite)
    {
        if($favourite->getId() === null)
        {
            $this->doctrineManager->persist($favourite);
        }
        $this->doctrineManager->flush();
    }

    /**
     * @param Favourite $favourite
     */
    public function deleteFavourite(Favourite $favourite)
    {
        $this->doctrineManager->remove($favourite);
        $this->doctrineManager->flush();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getFavouritesTweetByUser(User $user)
    {
        return $this->getRepository()->getFavouritesTweetByUser($user);
    }

    /**
     * @param User $user
     * @param Tweet $tweet
     * @return mixed
     */
    public function addFavourite(Favourite $favourite)
    {
        return $this->getRepository()->addFavourite($favourite);
    }

    private function getRepository()
    {
        return $this->doctrineManager->getRepository(Favourite::class);
    }
}