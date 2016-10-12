<?php

namespace Telma\DashboardBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Edit
 *
 * @ORM\Table(name="edit")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\EditRepository")
 * @GRID\Source(columns="id, offres")
 */
class Edit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }


    /**
     * @var string
     * 
     * @ORM\Column(name="offres", type="string", length=255)
     */
    private $offres;


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
     * Set offres
     *
     * @param string $offres
     *
     * @return Edit
     */
    public function setOffres($offres)
    {
        $this->offres = $offres;

        return $this;
    }

    /**
     * Get offres
     *
     * @return string
     */
    public function getOffres()
    {
        return $this->offres;
    }

    public function removeOffre(Offre $offre)
    {
        $this->offres->removeElement($offre);

        return $this->offres;
    }

    public function addOffre(Offre $offre)
    {
        $this->offres->add($offre);
    }

}
