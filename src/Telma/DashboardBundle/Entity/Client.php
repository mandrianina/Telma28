<?php

namespace Telma\DashboardBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="telma_client")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\ClientRepository")
 */
class Client
{

    /**
     *@ORM\ManyToOne(targetEntity="Telma\DashboardBundle\Entity\Offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;
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
     * @var string
     *
     * @ORM\Column(name="region" , type="string" , length=255)
     */
    private $region;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
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
     * Set offre
     *
     * @param \Telma\DashboardBundle\Entity\Offre $offre
     *
     * @return Client
     */
    public function setOffre(\Telma\DashboardBundle\Entity\Offre $offre)
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
     * Set region
     *
     * @param string $region
     *
     * @return Client
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }
}
