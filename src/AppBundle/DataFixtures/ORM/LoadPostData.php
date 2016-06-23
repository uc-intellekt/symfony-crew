<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->setSlug(sprintf('post-%d', $i));
            $post->setHeading(sprintf('Post %d', $i));
            $post->setContent(<<<HEREDOC
Lorem ipsum dolor sit amet, consectetur adipisicing elit.
A ad at deserunt eligendi libero maiores mollitia neque nisi
nobis odio quas sit voluptate, voluptatum. Aliquam exercitationem
fugit hic recusandae voluptatibus?
HEREDOC
            );
            $manager->persist($post);
        }

        $manager->flush();
    }
}
