<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Api\ContentProcessor;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\Post(processor: ContentProcessor::class),
        new GetCollection(),
        new Get(uriTemplate: '/contents/{uid}', uriVariables: ['uid']),
        new Put(uriTemplate: '/contents/{uid}', uriVariables: ['uid']),
        new Patch(
            uriTemplate: '/contents/{uid}',
            uriVariables: ['uid'],
            security: "object.getAuthor() === user"
        ),
        new Delete(uriTemplate: '/contents/{uid}', uriVariables: ['uid']),
    ],
    normalizationContext: ['groups' => ['post:read']],
    denormalizationContext: ['groups' => ['post:write']]
)]
class Post
{
    public function __construct()
    {
        $this->uid = Uuid::v4()->toRfc4122();
    }

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    #[Groups(['post:read'])]
    private ?string $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post:read', 'post:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['post:read', 'post:write'])]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(name: 'author_uid', referencedColumnName: 'uid', nullable: false)]
    #[ApiProperty(writable: false)]
    #[Groups(['post:read'])]
    private ?User $author = null;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }
}
