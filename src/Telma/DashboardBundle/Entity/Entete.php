<?php

namespace Telma\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entete
 *
 * @ORM\Table(name="entete")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\EnteteRepository")
 */
class Entete
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     * @var string
     *
     * @ORM\Column(name="champ", type="string", length=20)
     */
    private $champ;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isNotUsed", type="boolean")
     */
    private $isNotUsed;


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
     * Set nom
     *
     * @param string $nom
     * @return Entete
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Entete
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set champ
     *
     * @param string $champ
     * @return Entete
     */
    public function setChamp($champ)
    {
        $this->champ = $champ;

        return $this;
    }

    /**
     * Get champ
     *
     * @return string 
     */
    public function getChamp()
    {
        return $this->champ;
    }


    /**
     * Set isNotUsed
     *
     * @param boolean $isNotUsed
     * @return Entete
     */
    public function setIsNotUsed($isNotUsed)
    {
        $this->isNotUsed = $isNotUsed;

        return $this;
    }

    /**
     * Get isNotUsed
     *
     * @return boolean 
     */
    public function getIsNotUsed()
    {
        return $this->isNotUsed;
    }
}
