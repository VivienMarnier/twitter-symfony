<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 11:55.
 */

namespace AppBundle\Messenger;

use AppBundle\Entity\Tweet;

/**
 * EmailMessenger.
 * Service gérant l'envoie d'email à l'administrateur du site lorsqu'un nouveau Tweet est posté sur le site.
 */
class EmailMessenger
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTweetCreated(Tweet $tweet)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('Un nouveau Tweet a été posté')
        ->setFrom('noreply-twitter@gmail.com')
        ->setTo('send.to@mail.net')
        ->setBody(sprintf('Voici le contenu du Tweet : %s', $tweet->getMessage()));
        $this->mailer->send($message);
    }
}
