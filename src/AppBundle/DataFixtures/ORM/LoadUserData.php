<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 14:37
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userData = array(
            array(

                'username' => 'vivous',
                'email' => 'vivous@gmail.com',
                'password' => 'vivous',
            ),
            array(
                'username' => 'patzlito',
                'email' => 'patzlito@gmail.com',
                'password' => 'patzlito',
            ),
        );
        $userManager = $this->container->get('fos_user.user_manager');
        foreach ($userData as $i => $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPlainPassword($userData['password']);
            $user->setEnabled(true);
            $userManager->updatePassword($user);
            $manager->persist($user);
            $this->addReference(sprintf('user-%s', $i), $user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}