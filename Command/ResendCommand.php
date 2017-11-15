<?php

namespace Everlution\EmailBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResendCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('everlution_email:resend_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iterator = $this->getContainer()->get('everlution.email.outbound.message_status_repository')->findAllUndeliveredMessages();

        $mail = $this->getContainer()->get('everlution.email.outbound.synchronous_mailer');

        foreach ($iterator as $item) {
            $mail->resendMessage($item);
            exit;
        }
    }
}
