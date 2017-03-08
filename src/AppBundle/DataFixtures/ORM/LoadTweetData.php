<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tweet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTweetData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $messages = [
            'hello world',
            'symfony its cool',
            'Coucou c\'est mon premier vrai tweet !',
            'Bonjour à tous hier le Bayern on encore gagné 5-1 contre Arsenal',
            'Ce soir peut-on croire à la remontada du Barça ? ça va être difficile !',
            'Salut à tous',
            'HOHOHOHOHOHOHHOHOOH',
            'AHAHAHAHAHAHAAHAHAHAH',
            'HIHIHIHIHIHHIIHIHIHIHHI',
            'HUHUHUHUHUHUHUHUHUHUHUHUH',
        ];
        foreach ($messages as $i => $message) {
            $tweet = new Tweet();
            $tweet->setMessage($message);
            $manager->persist($tweet);
            $this->addReference('tweet-'.$i, $tweet);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
