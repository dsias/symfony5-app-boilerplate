<?php

namespace App\DataFixtures;

use App\Domain\Entities\Post\Post;
use App\Domain\Repositories\Interfaces\UsersRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostsFixtures extends Fixture implements DependentFixtureInterface
{
    public const LAST_POST_TITLE = 'Last post';
    public const LAST_POST_TEXT = 'Last post content here...';

    private UsersRepositoryInterface $usersRepo;


    public function __construct(UsersRepositoryInterface $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $post = $this->createPost();
            $manager->persist($post);
        }
        $post = $this->createPost(self::LAST_POST_TITLE, self::LAST_POST_TEXT);
        $manager->persist($post);

        $manager->flush();
    }

    private function createPost($title = 'Random post', $text = 'Post content here...'): Post
    {
        $user = $this->usersRepo->getOneByEmail(UsersFixtures::CONFIRMED_USER_EMAIL);

        return new Post($user, $title, $text);
    }

}
