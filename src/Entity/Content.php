<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Api\ContentProcessor;
use App\Repository\ContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            processor: ContentProcessor::class
        ),
        new GetCollection(),
        new Get(uriTemplate: '/contents/{slug}', uriVariables: ['slug']),
        new Put(uriTemplate: '/contents/{slug}', uriVariables: ['slug']),
        new Delete(uriTemplate: '/contents/{slug}', uriVariables: ['slug']),
    ],
    normalizationContext: ['groups' => ['content:read']],
    denormalizationContext: ['groups' => ['content:write']]
)]
class Content
{
    public function __construct()
    {
        $this->uid = new Ulid();
    }

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    #[ApiProperty(identifier: true)]
    #[Groups(['content:read', 'content:write'])]
    private ?string $slug = null;

    #[ORM\Column(type: 'ulid', unique: true)]
    #[Groups(['content:read'])]
    private ?Ulid $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['content:read', 'content:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['content:read', 'content:write'])]
    private ?string $body = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'contents')]
    #[ORM\JoinColumn(name: 'author_uid', referencedColumnName: 'uid', nullable: false)]
    #[ApiProperty(writable: false)]
    #[Groups(['content:read'])]
    private ?User $author = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getUid(): ?Ulid
    {
        return $this->uid;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;
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
}
