<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferenceRepository::class)
 */
class Reference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $drawingImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rule;

    /**
     * @ORM\ManyToOne(targetEntity=LessonStage::class, inversedBy="referenceImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lessonStage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrawingImage(): ?string
    {
        return $this->drawingImage;
    }

    public function setDrawingImage(string $drawingImage): self
    {
        $this->drawingImage = $drawingImage;

        return $this;
    }

    public function getRule(): ?string
    {
        return $this->rule;
    }

    public function setRule(?string $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    public function getLessonStage(): ?LessonStage
    {
        return $this->lessonStage;
    }

    public function setLessonStage(?LessonStage $lessonStage): self
    {
        $this->lessonStage = $lessonStage;

        return $this;
    }
}
