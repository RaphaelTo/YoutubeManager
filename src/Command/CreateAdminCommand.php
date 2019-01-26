<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';
    private $entityManager;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('email', InputArgument::REQUIRED, 'email description')
            ->addArgument('password', InputArgument::REQUIRED, 'password description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $io->note(sprintf('Create a User for email: %s', $email));

        $user = new User();
        $user->setEmail($email);
        $passwordEncoder = $this->encoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoder);
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Tu as crée ton admin', $email);
    }
}
