<?php

namespace App\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="id_subscription", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
	
	/**
     * @var \Partner
     *
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_partner", referencedColumnName="id_partner", nullable=false)
     * })
     */
    private $partner;

    /**
     * @var string
     *
     * @ORM\Column(name="in_date", type="datetime")
     */
    private $inDate;

    /**
     * @var string
     *
     * @ORM\Column(name="out_date", type="datetime")
     */
    private $outDate;
	
	/**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=255)
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inDate
     *
     * @param \DateTime $inDate
     *
     * @return Subscription
     */
    public function setInDate($inDate)
    {
        $this->inDate = $inDate;

        return $this;
    }

    /**
     * Get inDate
     *
     * @return \DateTime
     */
    public function getInDate()
    {
        return $this->inDate;
    }

    /**
     * Set outDate
     *
     * @param \DateTime $outDate
     *
     * @return Subscription
     */
    public function setOutDate($outDate)
    {
        $this->outDate = $outDate;

        return $this;
    }

    /**
     * Get outDate
     *
     * @return \DateTime
     */
    public function getOutDate()
    {
        return $this->outDate;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Subscription
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Subscription
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set partner
     *
     * @param \App\Entity\Partner $partner
     *
     * @return Subscription
     */
    public function setPartner(\App\Entity\Partner $partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * Get partner
     *
     * @return \App\Entity\Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }
}
