<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comment_index")
     */
    public function index(CommentRepository $repo, $page)
    {
        //$repo = $this->getDoctrine()->getRepository(Comment::class);

        $comments = $repo->findAll();
        $limit = 6;

        $start = $page * $limit - $limit;

        $total = count($repo->findAll());

        $pages = ceil($total / $limit);




        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
            'comments' => $repo->findBy([], [], $limit, $start),
            'pages' => $pages,
            'page' => $page
        ]);
    }




    /**
     * Permet de modifier un commentaire
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     *
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
      $form = $this->createForm(AdminCommentType::class, $comment);

      $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire numéro {$comment->getId()} a bien été modifié"
            );
        }

       return $this->render('admin/comment/edit.html.twig',[
        'comment' => $comment,
        'form' => $form->createView()
      ]);

    }


    /**
     * Permet de supprimé un commentaire
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {
       $manager->remove($comment);
       $manager->flush();

       $this->addFlash(
        'success',
        "Le commentaire numéro {$comment->getAuthor()->getFullName()} a bien été supprimé"
    );
    return $this->redirectToRoute('admin_comment_index');

    }
}
