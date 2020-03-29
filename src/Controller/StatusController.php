<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class StatusController extends AbstractController
{
    /**
     * @Route("/api/users/status/{id}", name="status", methods={"get"} )
     */
    public function setStatus($id)
    {
        $repo=$this->getDoctrine()->getRepository(User::class);
        $em=$this->getDoctrine()->getManager();
        $user=$repo->find($id);
        if($user->getIsActive() === true){
            $user->setIsActive(false);
            $status="desactivé";
        }else{
            $user->setIsActive(true);
            $status="activé";
        }
        $em->persist($user);
        $em->flush();
        $data=[
            'status'=> '200',
            'message'=> $user->getUsername().' est '. $status,
        ];
        return $this->json($data,200);
    }
}
