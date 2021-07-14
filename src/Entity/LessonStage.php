<?php

namespace App\Entity;

use App\Repository\LessonStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonStageRepository::class)
 */
class LessonStage
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
     * @ORM\Column(type="string", length=800)
     */
    private $guidance;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="lessonStages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $exampleImageStage;

    /**
     * @ORM\OneToMany(targetEntity=Reference::class, mappedBy="lessonStage", orphanRemoval=true)
     */
    private $referenceImages;

    public function __construct()
    {
        $this->referenceImages = new ArrayCollection();
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

    public function getGuidance(): ?string
    {
        return $this->guidance;
    }

    public function setGuidance(string $guidance): self
    {
        $this->guidance = $guidance;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getExampleImageStage(): ?string
    {
        return $this->exampleImageStage;
    }

    public function setExampleImageStage(?string $exampleImageStage): self
    {
        $this->exampleImageStage = $exampleImageStage;

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
    }

    /**
     * @return Collection|Reference[]
     */
    public function getReferenceImages(): Collection
    {
        return $this->referenceImages;
    }

    public function addReferenceImage(Reference $referenceImage): self
    {
        if (!$this->referenceImages->contains($referenceImage)) {
            $this->referenceImages[] = $referenceImage;
            $referenceImage->setLessonStage($this);
        }

        return $this;
    }

    public function removeReferenceImage(Reference $referenceImage): self
    {
        if ($this->referenceImages->removeElement($referenceImage)) {
            // set the owning side to null (unless already changed)
            if ($referenceImage->getLessonStage() === $this) {
                $referenceImage->setLessonStage(null);
            }
        }

        return $this;
    }

}
