<?php

namespace App\Entity;

use App\Repository\DrawingCheckResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DrawingCheckResultRepository::class)
 */
class DrawingCheckResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="drawingCheckResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=LessonStage::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $lessonStage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultImage;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $resultMessage;

    /**
     * @ORM\ManyToOne(targetEntity=Passing::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $passing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getResultImage(): ?string
    {
        return $this->resultImage;
    }

    public function setResultImage(string $resultImage): self
    {
        $this->resultImage = $resultImage;

        return $this;
    }

    public function getResultMessage(): ?string
    {
        return $this->resultMessage;
    }

    public function setResultMessage(string $resultMessage): self
    {
        $this->resultMessage = $resultMessage;

        return $this;
    }

    public function getPassing(): ?Passing
    {
        return $this->passing;
    }

    public function setPassing(?Passing $passing): self
    {
        $this->passing = $passing;

        return $this;
    }
}
