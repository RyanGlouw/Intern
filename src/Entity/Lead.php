<?php

namespace App\Entity;

use App\Repository\LeadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeadRepository::class)
 */
class Lead
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $leadId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $retailcrmId;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeadId(): ?string
    {
        return $this->leadId;
    }

    public function setLeadId(string $leadId): self
    {
        $this->leadId = $leadId;

        return $this;
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

    public function getRetailcrmId(): ?string
    {
        return $this->retailcrmId;
    }

    public function setRetailcrmId(?string $retailcrmId): self
    {
        $this->retailcrmId = $retailcrmId;

        return $this;
    }
}
