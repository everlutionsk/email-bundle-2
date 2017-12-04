<?php

namespace Everlution\EmailBundle\Command;

use Everlution\EmailBundle\Outbound\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResendCommand extends ContainerAwareCommand
{
    private const NAME_LIMIT = 'limit';
    private const SHORTCUT_LIMIT = 'l';
    private const DEFAULT_LIMIT = 100;

    private const NAME_RESEND_ATTEMPTS = 'attempts';
    private const SHORTCUT_RESEND_ATTEMPTS = 'a';
    private const DEFAULT_MAX_RESEND_ATTEMPTS = 3;

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('everlution:email:resend')
            ->setDescription('Resend rejected emails.')
            ->addOption(
                self::NAME_LIMIT,
                self::SHORTCUT_LIMIT,
                InputOption::VALUE_OPTIONAL,
                'Maximum emails processed in one bulk.',
                self::DEFAULT_LIMIT
            )
            ->addOption(
                self::NAME_RESEND_ATTEMPTS,
                self::SHORTCUT_RESEND_ATTEMPTS,
                InputOption::VALUE_OPTIONAL,
                'Maximum resend attempts per email.',
                self::DEFAULT_MAX_RESEND_ATTEMPTS
            );
    }

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \LogicException
     * @throws \Everlution\EmailBundle\Outbound\MailSystem\MailSystemException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mailer = $this
            ->getContainer()
            ->get('everlution.email.outbound.synchronous_mailer');

        $items = $this
            ->getContainer()
            ->get('everlution.email.outbound.message_status_repository')
            ->findAllRejected(
                $input->getOption(self::NAME_LIMIT),
                $input->getOption(self::NAME_RESEND_ATTEMPTS)
            );

        foreach ($items as $item) {
            $mailer->resendMessage($item);
        }
    }
}
