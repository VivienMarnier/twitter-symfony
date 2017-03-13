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
    private $mailFrom;
    private $mailAdmin;

    /**
     * EmailMessenger constructor.
     * @param $mailer
     * @param $from
     * @param $mailAdmin
     */
    public function __construct(\Swift_Mailer $mailer,$from,$mailAdmin)
    {
        $this->mailer = $mailer;
        $this->mailFrom = $from;
        $this->mailAdmin = $mailAdmin;
    }

    /**
     * fonction qui crée un objet Swift_Message et envoie le contenu du Tweet $tweet par mail
     * @param Tweet $tweet
     */
    public function sendTweetCreated(Tweet $tweet)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('Un nouveau Tweet a été posté')
        ->setFrom($this->mailFrom)
        ->setTo($this->mailAdmin)
        ->setBody(sprintf('Voici le contenu du Tweet : %s', $tweet->getMessage()));
        $this->send($message);
    }

    /**
     * @param \Swift_Message $message
     */
    public function send(\Swift_Message $message)
    {
        $this->mailer->send($message);
    }
}
