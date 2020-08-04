<?php

namespace App\Entity;

use App\Repository\AboutTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AboutTextRepository::class)
 */
class AboutText
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $textPosition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTextPosition(): ?int
    {
        return $this->textPosition;
    }

    public function setTextPosition(int $textPosition): self
    {
        $this->textPosition = $textPosition;

        return $this;
    }
}
