<?php

namespace Everlution\EmailBundle\Command;

use Everlution\EmailBundle\Outbound\Mailer\SynchronousMailer;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessageStatus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResendCommand extends Command
{
    private const NAME_LIMIT = 'limit';
    private const SHORTCUT_LIMIT = 'l';
    private const DEFAULT_LIMIT = 100;

    private const NAME_RESEND_ATTEMPTS = 'attempts';
    private const SHORTCUT_RESEND_ATTEMPTS = 'a';
    private const DEFAULT_MAX_RESEND_ATTEMPTS = 3;

    private SynchronousMailer $mailer;
    private StorableOutboundMessageStatus $repository;

    public function __construct(SynchronousMailer $mailer, StorableOutboundMessageStatus $repository)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
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
     *
     * @throws \Everlution\EmailBundle\Outbound\MailSystem\MailSystemException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $items = $this->repository->findAllRejected(
            $input->getOption(self::NAME_LIMIT),
            $input->getOption(self::NAME_RESEND_ATTEMPTS)
        );

        foreach ($items as $item) {
            $this->mailer->resendMessage($item);
        }
    }
}
