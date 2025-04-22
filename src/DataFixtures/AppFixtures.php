<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\User;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {}
    public function load(ObjectManager $manager): void
    {
        $categories = [];
        $users = [];

        // Instancier Faker
        $faker = Faker\Factory::create("fr_FR");
        // Boucle pour ajouter 50 catégories
        for ($i=0; $i<50 ; $i++){
            $category = new Category;
            // setter le label avec un métier aléatoire
            $category->setLabel($faker->unique()->jobTitle());
            // mettre en cache la categorie
            $manager->persist($category);
            $categories[] = $category;
        }
        // Boucle pour rajouter 50 users
        for ($i=0; $i<50; $i++) {
            $user = new User;
            // setter nom, prenom, email, password et roles aléatoire
            $user->setFirstname($faker->firstName('male'|'female'))
                ->setLastname($faker->lastName())
                ->setEmail($faker->unique()->email())
                ->setPassword($this->hasher->hashPassword($user, $faker->word(2)))
                ->setRoles(["ROLE_USER"]);
            // mettre en cache les users
            $manager->persist($user);
            $users[] = $user;
        }
        // Boucle pour ajouter 200 articles
        for ($i=0; $i<200 ; $i++){
            $article = new Article;
            // setter le titre, content, date aléatoirement
            $article->setTitle($faker->sentence(3))
                    ->setContent($faker->paragraph())
                    ->setCreatedAt(new \DateTimeImmutable($faker->date('Y-m-d')))
                    ->setUser($users[$faker->numberBetween(0,49)])
                    ->addCategory($categories[$faker->numberBetween(0,19)])
                    ->addCategory($categories[$faker->numberBetween(20,35)])
                    ->addCategory($categories[$faker->numberBetween(36,49)]);
            // mettre en cache les articles
            $manager->persist($article);
        }
        
        // synchroniser avec la bdd
        $manager->flush();
    }
}
