<?php

namespace App\Entity;

use App\Repository\EmailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmailsRepository::class)
 */
class Emails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $too;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="emails")
     */
    private $usr_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToo(): ?string
    {
        return $this->too;
    }

    public function setToo(?string $too): self
    {
        $this->too = $too;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUsrId(): ?User
    {
        return $this->usr_id;
    }

    public function setUsrId(?User $usr_id): self
    {
        $this->usr_id = $usr_id;

        return $this;
    }
}
