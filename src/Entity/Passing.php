<?php

namespace App\Entity;

use App\Repository\PassingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PassingRepository::class)
 */
class Passing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=DrawingCheckResult::class, mappedBy="passing", orphanRemoval=true)
     */
    private $results;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="passings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplited = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $curLesson = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $curStage = 0;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|DrawingCheckResult[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(DrawingCheckResult $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setPassing($this);
        }

        return $this;
    }

    public function removeResult(DrawingCheckResult $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getPassing() === $this) {
                $result->setPassing(null);
            }
        }

        return $this;
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

    public function getIsComplited(): ?bool
    {
        return $this->isComplited;
    }

    public function setIsComplited(bool $isComplited): self
    {
        $this->isComplited = $isComplited;

        return $this;
    }

    public function getCurLesson(): ?int
    {
        return $this->curLesson;
    }

    public function setCurLesson(?int $curLesson): self
    {
        $this->curLesson = $curLesson;

        return $this;
    }

    public function getCurStage(): ?int
    {
        return $this->curStage;
    }

    public function setCurStage(?int $curStage): self
    {
        $this->curStage = $curStage;

        return $this;
    }

    public function isDrawingCheckResult(LessonStage $lessonStage): ?DrawingCheckResult
    {
        $results = $this->results;
        foreach ($results as &$result) {
            if ($result->getLessonStage()->getId() == $lessonStage->getId()) {
                return $result;
            }
        }
        return null;
    }
}
