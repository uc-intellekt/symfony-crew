<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="show_blog")
     */
    public function showBlogAction()
    {
        $em = $this->getDoctrine()
            ->getManager();
        $posts = $em->getRepository('AppBundle:Post')
            ->findAll();
//        dump($posts);

        return $this->render('blog/show.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{slug}", name="show_blog_post")
     */
    public function showBlogPostAction(Post $post)
    {
        return $this->render('blog/show-post.html.twig', [
            'post' => $post,
        ]);
    }
}
