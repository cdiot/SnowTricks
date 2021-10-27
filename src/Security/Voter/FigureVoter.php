<?php

namespace App\Security\Voter;

use App\Entity\Figure;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class FigureVoter extends Voter
{
    const FIGURE_ADD = 'figure_add';
    const FIGURE_EDIT = 'figure_edit';
    const FIGURE_DELETE = 'figure_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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

        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::FIGURE_ADD:
                return true;
                break;
            case self::FIGURE_EDIT:
                return $this->canEdit($figure, $user);
                break;
            case self::FIGURE_DELETE:
                return $this->canDelete($figure, $user);
                break;
        }

        return false;
    }

    private function canEdit(Figure $figure, User $user)
    {
        return $user === $figure->getUser();
    }

    private function candelete(Figure $figure, User $user)
    {
        return $user === $figure->getUser();
    }
}
