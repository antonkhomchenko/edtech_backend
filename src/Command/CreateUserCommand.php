<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Создаёт тестового пользователя с захардкоженными данными',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = 'anton@test.com';

        // Проверим, нет ли уже такого
        if ($this->userRepository->findOneByEmail($email)) {
            $output->writeln("<error>Пользователь с email {$email} уже существует</error>");
            return Command::FAILURE;
        }

        $user = new User();
        $user
            ->setEmail($email)
            ->setFirstName('Anton')
            ->setLastName('Khomchenko')
            ->setTitle('Founder')
            ->setDescription('Test user created via console command')
            ->setRoles(['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, '123456');
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('<info>Пользователь успешно создан!</info>');
        $output->writeln("Email: {$email}");
        $output->writeln("Password: 123456");

        return Command::SUCCESS;
    }
}
