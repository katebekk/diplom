<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    const TEACHER = "Teacher";
    const LEARNER = "Learner";


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userType;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="user")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity=DrawingCheckResult::class, mappedBy="user")
     */
    private $drawingCheckResults;

    /**
     * @ORM\ManyToMany(targetEntity=Course::class)
     */
    private $coursePassed;

    /**
     * @ORM\OneToMany(targetEntity=Passing::class, mappedBy="user", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $passings;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->drawingCheckResults = new ArrayCollection();
        $this->coursePassed = new ArrayCollection();
        $this->passings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        if($this->userType == "Teacher"){
            $roles[] = 'ROLE_TEACHER';
        }elseif ($this->userType == "Learner"){
            $roles[] = 'ROLE_LEARNER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserType(): ?string
    {
        return $this->userType;
    }

    public function setUserType(string $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setUser($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getUser() === $this) {
                $course->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DrawingCheckResult[]
     */
    public function getDrawingCheckResults(): Collection
    {
        return $this->drawingCheckResults;
    }

    public function addDrawingCheckResult(DrawingCheckResult $drawingCheckResult): self
    {
        if (!$this->drawingCheckResults->contains($drawingCheckResult)) {
            $this->drawingCheckResults[] = $drawingCheckResult;
            $drawingCheckResult->setUser($this);
        }

        return $this;
    }

    public function removeDrawingCheckResult(DrawingCheckResult $drawingCheckResult): self
    {
        if ($this->drawingCheckResults->removeElement($drawingCheckResult)) {
            // set the owning side to null (unless already changed)
            if ($drawingCheckResult->getUser() === $this) {
                $drawingCheckResult->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCoursePassed(): Collection
    {
        return $this->coursePassed;
    }

    public function addCoursePassed(Course $coursePassed): self
    {
        if (!$this->coursePassed->contains($coursePassed)) {
            $this->coursePassed[] = $coursePassed;
        }

        return $this;
    }

    public function removeCoursePassed(Course $coursePassed): self
    {
        $this->coursePassed->removeElement($coursePassed);

        return $this;
    }

    public function isEnroll(Course $course): bool
    {
        if (!$this->coursePassed->contains($course)) {
            return false;
        }

        return true;
    }

    public function isPassing(Course $course): bool
    {
        $passings = $this->passings;
        $passed = false;
        foreach ($passings as &$passing) {
            if ($passing->getCourse() == $course and $passing->getIsComplited() == false) {
                $passed = true;
            }
        }

        return $passed;
    }

    /**
     * @return Collection|Passing[]
     */
    public function getPassings(): Collection
    {
        return $this->passings;
    }

    public function addPassing(Passing $passing): self
    {
        if (!$this->passings->contains($passing)) {
            $this->passings[] = $passing;
            $passing->setUser($this);
        }

        return $this;
    }

    public function removePassing(Passing $passing): self
    {
        if ($this->passings->removeElement($passing)) {
            // set the owning side to null (unless already changed)
            if ($passing->getUser() === $this) {
                $passing->setUser(null);
            }
        }

        return $this;
    }
}
