<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class isYoutube extends Constraint
{
    public $message = 'Url Youtube non valide.';

    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }
}
