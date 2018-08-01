<?php

namespace App\Entity;

use App\Entity\Partner;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscriptions")
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @ORM\Column(name="id_subscription", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="in_date", type="datetime")
     */
    private $inDate;

    /**
     * @ORM\Column(name="out_date", type="datetime")
     */
    private $outDate;
	
	/**
     * @ORM\Column(name="info", type="string", length=255)
     */
    private $info;

    /**
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partner", inversedBy="subscriptions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_partner", referencedColumnName="id_partner", nullable=false)
     * })
     */
    private $partner;

    
    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInDate(): ?\DateTimeInterface
    {
        return $this->inDate;
    }

    public function setInDate(\DateTimeInterface $inDate): self
    {
        $this->inDate = $inDate;

        return $this;
    }

    public function getOutDate(): ?\DateTimeInterface
    {
        return $this->outDate;
    }

    public function setOutDate(\DateTimeInterface $outDate): self
    {
        $this->outDate = $outDate;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    


    
}
