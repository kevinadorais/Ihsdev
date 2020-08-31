<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectsRepository::class)
 */
class Projects
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity=ProjectImgs::class, mappedBy="projects", orphanRemoval=true, cascade={"persist"})
     */
    private $projectImgs;

    /**
     * @ORM\ManyToMany(targetEntity=Technos::class)
     */
    private $technos;

    /**
     * @ORM\ManyToMany(targetEntity=DevSkills::class)
     */
    private $devSkills;

    public function __construct()
    {
        $this->projectImgs = new ArrayCollection();
        $this->technos = new ArrayCollection();
        $this->devSkills = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection|ProjectImgs[]
     */
    public function getProjectImgs(): Collection
    {
        return $this->projectImgs;
    }

    public function addProjectImg(ProjectImgs $projectImg): self
    {
        if (!$this->projectImgs->contains($projectImg)) {
            $this->projectImgs[] = $projectImg;
            $projectImg->setProjects($this);
        }

        return $this;
    }

    public function removeProjectImg(ProjectImgs $projectImg): self
    {
        if ($this->projectImgs->contains($projectImg)) {
            $this->projectImgs->removeElement($projectImg);
            // set the owning side to null (unless already changed)
            if ($projectImg->getProjects() === $this) {
                $projectImg->setProjects(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Technos[]
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function addTechno(Technos $techno): self
    {
        if (!$this->technos->contains($techno)) {
            $this->technos[] = $techno;
        }

        return $this;
    }

    public function removeTechno(Technos $techno): self
    {
        if ($this->technos->contains($techno)) {
            $this->technos->removeElement($techno);
        }

        return $this;
    }

    /**
     * @return Collection|DevSkills[]
     */
    public function getDevSkills(): Collection
    {
        return $this->devSkills;
    }

    public function addDevSkill(DevSkills $devSkill): self
    {
        if (!$this->devSkills->contains($devSkill)) {
            $this->devSkills[] = $devSkill;
        }

        return $this;
    }

    public function removeDevSkill(DevSkills $devSkill): self
    {
        if ($this->devSkills->contains($devSkill)) {
            $this->devSkills->removeElement($devSkill);
        }

        return $this;
    }
}
