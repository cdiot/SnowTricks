<?php

namespace App\Manager;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CommentManager
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function addCommentTo(Figure $figure, User $user, Comment $comment)
    {
        $comment->setUser($user);
        $comment->setFigure($figure);

        $this->em->persist($comment);
        $this->em->flush();
    }
}
