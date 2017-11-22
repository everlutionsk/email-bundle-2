<?php

namespace Everlution\EmailBundle\Command;

use Everlution\EmailBundle\Outbound\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResendCommand extends ContainerAwareCommand
{
    public const NAME_LIMIT = 'limit';
    public const SHORTCUT_L = 'l';
    public const DEFAULT_LIMIT = 100;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('everlution_email:resend')
            ->setDescription('Resend rejected emails.')
            ->addOption(
                self::NAME_LIMIT,
                self::SHORTCUT_L,
                InputOption::VALUE_OPTIONAL,
                'Maximum emails processed in one bulk.',
                self::DEFAULT_LIMIT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setMailer();

        foreach ($this->getMessagesToResend() as $item) {
            $this->mailer->resendMessage($item);
        }
    }

    /**
     * @return array
     */
    private function getMessagesToResend()
    {
        return $this->getContainer()->get('everlution.email.outbound.message_status_repository')->findAllRejected();
    }

    private function setMailer()
    {
        $this->mailer =  $this->getContainer()->get('everlution.email.outbound.synchronous_mailer');
    }
}
