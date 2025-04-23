<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $hasher
    )
    {}

    public function saveUser(User $user) {
        try {
            // Test si l'utilisateur existe déjà
            if($this->userRepository->findOneBy([
                "email"=>$user->getEmail(),
                ])) {
                    throw new \Exception("L'utilisateur existe déjà");
                }
            // Role par défaut
            $user->setRoles(["ROLE_USER"]);
            // Hasher le mdp
            $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
            // Ajouter l'utilisateur en BDD
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return true;  
    }
}
