<?php

namespace Telma\DashboardBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Head
 *
 * @ORM\Table(name="head")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\HeadRepository")
 */
class Head
{
    
    public function __construct()
    {
        $this->entetes = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="entetes", type="string", length=255)
     */
    private $entetes;

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
     * Set entetes
     *
     * @param string $entetes
     * @return Head
     */
    public function setEntetes($entetes)
    {
        $this->entetes = $entetes;

        return $this;
    }

    /**
     * Get entetes
     *
     * @return string 
     */
    public function getEntetes()
    {
        return $this->entetes;
    }
    
    public function removeEntete(Entete $entete)
    {
        $this->entetes->removeElement($entete);

        return $this->entetes;
    }

    public function addEntete(Entete $entete)
    {
        $this->entetes->add($entete);
    }
}
