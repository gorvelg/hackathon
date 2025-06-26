<?php

namespace App\Api;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Post;
use App\Entity\Report;
use Symfony\Bundle\SecurityBundle\Security;

class PostProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private Security           $security,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof Post && null === $data->getAuthor()) {
            $user = $this->security->getUser();
            $data->setAuthor($user);
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
