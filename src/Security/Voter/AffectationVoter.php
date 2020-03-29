<?php
namespace App\Security\Voter;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AffectationVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ADD', 'EDIT'])
            && $subject instanceof \App\Entity\Affecter;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        //id partenaire de celui qui affecte
        $userQuiAffecte = $user->getPartenaire()->getId();
        //id compte partenaire a affecte
        $compteId =  $subject->getCompte()->getPartenaire()->getId();
        //id partenaire user qu'on affecte
       // $userAffecter = $subject->getUserAffecter()->getPartenaire()->getId();
        if ($userQuiAffecte == $compteId) {
            return true;
        }

        if (($user->getRole()->getLibelle() == "ADMIN_SYS") || ($user->getRole()->getLibelle() == "ADMIN_SYS ")) {
            return true;
        }


        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ADD':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'EDIT':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        throw new Exception("Vous n'avez pas le droit d'affecter un compte car vous n'etes pas chez le meme partenaire");
    }
}