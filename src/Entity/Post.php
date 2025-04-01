<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\DTOInterface;
use App\DTO\PostDTO;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
#[ORM\Table(name: 'posts')]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 180)]
    private string $title;


    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private string $content;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'], inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getDTO(): DTOInterface
    {
        return  new PostDTO();
    }
}
