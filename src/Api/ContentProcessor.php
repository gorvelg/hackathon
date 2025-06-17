<?php

namespace App\Api;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Content;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ContentProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private SluggerInterface $slugger,
        private Security $security,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof Content) {
            if (!$data->getSlug()) {
                $slug = $this->slugger->slug($data->getTitle())->lower()->toString();
                $data->setSlug($slug . '-' . (new \DateTime())->format('Y-m-d-H-i-s'));
            }


            // 👇 Lier l'auteur automatiquement
            if (!$data->getAuthor()) {
                $user = $this->security->getUser();
                if ($user instanceof User) {
                    $data->setAuthor($user);
                }
            }
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
