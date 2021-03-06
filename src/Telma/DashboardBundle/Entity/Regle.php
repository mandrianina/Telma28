<?php

namespace Telma\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regle
 *
 * @ORM\Table(name="regle")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\RegleRepository")
 */
class Regle
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
     * @ORM\Column(name="nomOffre", type="string", length=255, nullable=false)
     */
    private $nomOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=65535, nullable=true)
     */
    private $contenu;
 
    /**
     * @var string
     * 
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    private $alias;

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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Regle
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set offre
     *
     * @param \Telma\DashboardBundle\Entity\Offre $offre
     *
     * @return Regle
     */
    public function setOffre(\Telma\DashboardBundle\Entity\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \Telma\DashboardBundle\Entity\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Regle
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set nomOffre
     *
     * @param string $nomOffre
     * @return Regle
     */
    public function setNomOffre($nomOffre)
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    /**
     * Get nomOffre
     *
     * @return string 
     */
    public function getNomOffre()
    {
        return $this->nomOffre;
    }
}
