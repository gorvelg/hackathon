<?php

namespace App\Api;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Content;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContentProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private SluggerInterface   $slugger,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof Content && !$data->getSlug()) {
            $date = new \DateTime();
            $slug = $this->slugger
                    ->slug($data->getTitle())
                    ->lower()
                    ->toString() . '-' . $date->format('Y-m-d-H-i-s');

            $data->setSlug($slug);
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
