<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoDangerousHtmlValidator extends ConstraintValidator {


    private array $forbiddenTags = [
        'script', 'iframe', 'object', 'embed', 'style', 'link', 'meta', 'svg', 'form', 'input'
    ];

    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $foundTags = [];

        foreach ($this->forbiddenTags as $tag) {
            if (preg_match(sprintf('/<\s*%s\b/i', preg_quote($tag, '/')), $value)) {
                $foundTags[] = $tag;
            }
        }

        if (!empty($foundTags)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ tags }}', implode(', ', $foundTags))
                ->addViolation();
        }

    }
}
