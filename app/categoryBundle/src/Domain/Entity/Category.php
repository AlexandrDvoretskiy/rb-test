<?php

namespace CategoryBundle\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Index(name: 'category__title', columns: ['title'])]
class Category implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique:true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $sort;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        string $title,
        int $sort,
    )
    {
        Assert::stringNotEmpty($title);
        Assert::notEmpty($sort);
        Assert::positiveInteger($sort);

        $this->title = $title;
        $this->sort = $sort;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "sort" => $this->sort,
            "createdAt" => $this->createdAt->format("Y-m-d H:i:s"),
            "updatedAt" => $this->updatedAt->format("Y-m-d H:i:s"),
        ];
    }
}