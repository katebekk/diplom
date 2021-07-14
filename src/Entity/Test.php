<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Course::class, inversedBy="test")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="test", cascade={"persist", "remove"})
     */
    private $Question;

    public function __construct()
    {
        $this->Question = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestion(): Collection
    {
        return $this->Question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->Question->contains($question)) {
            $this->Question[] = $question;
            $question->setTest($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->Question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getTest() === $this) {
                $question->setTest(null);
            }
        }

        return $this;
    }
}
