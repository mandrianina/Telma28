<?php

namespace Telma\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="data")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\DataRepository")
 */
class Data
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="stm16", type="integer")
     */
    private $stm16;

    /**
     * @var int
     *
     * @ORM\Column(name="stm4", type="integer")
     */
    private $stm4;

    /**
     * @var string
     *
     * @ORM\Column(name="offresFixes", type="string", length=4294967295)
     */
    private $offresFixes;

    /**
     * @var float
     *
     * @ORM\Column(name="accuracy", type="float")
     */
    private $accuracy;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set stm16
     *
     * @param integer $stm16
     *
     * @return Data
     */
    public function setStm16($stm16)
    {
        $this->stm16 = $stm16;

        return $this;
    }

    /**
     * Get stm16
     *
     * @return int
     */
    public function getStm16()
    {
        return $this->stm16;
    }

    /**
     * Set stm4
     *
     * @param integer $stm4
     *
     * @return Data
     */
    public function setStm4($stm4)
    {
        $this->stm4 = $stm4;

        return $this;
    }

    /**
     * Get stm4
     *
     * @return int
     */
    public function getStm4()
    {
        return $this->stm4;
    }

    /**
     * Set offresFixes
     *
     * @param string $offresFixes
     *
     * @return Data
     */
    public function setOffresFixes($offresFixes)
    {
        $this->offresFixes = $offresFixes;

        return $this;
    }

    /**
     * Get offresFixes
     *
     * @return string
     */
    public function getOffresFixes()
    {
        return $this->offresFixes;
    }

    /**
     * Set accuracy
     *
     * @param float $accuracy
     *
     * @return Data
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    /**
     * Get accuracy
     *
     * @return float
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

}

