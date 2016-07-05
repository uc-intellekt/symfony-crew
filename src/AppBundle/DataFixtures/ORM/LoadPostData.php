<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $symfonyTag = new Tag('Symfony');
        $phpTag = new Tag('PHP');
        $jsTag = new Tag('JS');
        $mysqlTag = new Tag('MySQL');
        $manager->persist($symfonyTag);
        $manager->persist($phpTag);
        $manager->persist($jsTag);
        $manager->persist($mysqlTag);
        $tags = [
            $symfonyTag,
            $phpTag,
            $jsTag,
            $mysqlTag,
        ];

        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
//            $post->setSlug(sprintf('post-%d', $i));
            $post->setHeading(sprintf('Post Heading %d', $i));
            $post->setContent(<<<HEREDOC
Lorem ipsum dolor sit amet, consectetur adipisicing elit.
A ad at deserunt eligendi libero maiores mollitia neque nisi
nobis odio quas sit voluptate, voluptatum. Aliquam exercitationem
fugit hic recusandae voluptatibus?
HEREDOC
            );
            /** @var int[] $randomIndexes */
            $randomIndexes = array_rand($tags, rand(2, count($tags)));
            foreach ($randomIndexes as $index) {
                $post->getTags()->add($tags[$index]);
            }
            $manager->persist($post);
        }

        $manager->flush();
    }
}
