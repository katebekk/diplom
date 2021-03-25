<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $goals;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=LessonStage::class, mappedBy="lesson")
     */
    private $lessonStages;

    public function __construct()
    {
        $this->lessonStages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGoals(): ?string
    {
        return $this->goals;
    }

    public function setGoals(string $goals): self
    {
        $this->goals = $goals;

        return $this;
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
     * @return Collection|LessonStage[]
     */
    public function getLessonStages(): Collection
    {
        return $this->lessonStages;
    }

    public function addLessonStage(LessonStage $lessonStage): self
    {
        if (!$this->lessonStages->contains($lessonStage)) {
            $this->lessonStages[] = $lessonStage;
            $lessonStage->setLesson($this);
        }

        return $this;
    }

    public function removeLessonStage(LessonStage $lessonStage): self
    {
        if ($this->lessonStages->removeElement($lessonStage)) {
            // set the owning side to null (unless already changed)
            if ($lessonStage->getLesson() === $this) {
                $lessonStage->setLesson(null);
            }
        }

        return $this;
    }
}
