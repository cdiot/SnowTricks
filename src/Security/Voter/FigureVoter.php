<?php

namespace App\Security\Voter;

use App\Entity\Figure;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class FigureVoter extends Voter
{
    const FIGURE_ADD = 'figure_add';
    const FIGURE_EDIT = 'figure_edit';
    const FIGURE_DELETE = 'figure_delete';

    protected function supports(string $attribute, $figure): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::FIGURE_ADD, self::FIGURE_EDIT, self::FIGURE_DELETE])
            && ($figure instanceof \App\Entity\Figure || $figure === null);
    }

    protected function voteOnAttribute(string $attribute, $figure, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::FIGURE_ADD:
            case self::FIGURE_EDIT:
            case self::FIGURE_DELETE:
                return true;
        }

        return false;
    }
}
