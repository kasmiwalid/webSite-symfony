<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager)
    {
        $users = $manager->createQuery('SELECT count(u) FROM App\Entity\User u')->getSingleScalarResult();
        $ads = $manager->createQuery('SELECT count(u) FROM App\Entity\Ad u')->getSingleScalarResult();
        $bookings = $manager->createQuery('SELECT count(u) FROM App\Entity\Booking u')->getSingleScalarResult();
        $comments = $manager->createQuery('SELECT count(u) FROM App\Entity\Comment u')->getSingleScalarResult();

        $bestAds = $manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN a.author u 
            GROUP BY a
            ORDER BY note DESC'
        )->setMaxResults(4)
        ->getResult();

        $worstAds = $manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN a.author u 
            GROUP BY a
            ORDER BY note ASC'
        )->setMaxResults(4)
        ->getResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' =>  compact('users', 'ads' , 'bookings' ,'comments'),
            'bestAds'=>$bestAds,
            'worstAds'=>$worstAds
        ]);
    }
}
