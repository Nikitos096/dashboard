<?php

declare(strict_types=1);

namespace App\Command\Auth\SignUp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Model\User\UseCase\SignUp;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConfirmCommand extends Command
{
    private SignUp\Confirm\Handler $handler;
    private ValidatorInterface $validator;

    public function __construct(SignUp\Confirm\Handler $handler, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->handler = $handler;
        $this->validator = $validator;
    }

    protected function configure()
    {
        $this->setName('auth:signup:confirm');
        $this->addArgument('token', InputArgument::REQUIRED, 'Enter Confirm Token');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new SignUp\Confirm\Command($input->getArgument('token'));

        $violations = $this->validator->validate($command);
        if ($violations->count() > 0) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $output->writeln($violation->getPropertyPath().': '.$violation->getMessage());
            }
            return 500;
        }

        $this->handler->handle($command);
        return 0;
    }
}