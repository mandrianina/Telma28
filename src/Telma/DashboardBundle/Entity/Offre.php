<?php

namespace Telma\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Offre
 *
 * @ORM\Table(name="telma_offre")
 * @ORM\Entity(repositoryClass="Telma\DashboardBundle\Repository\OffreRepository")
 * @GRID\Source(columns="id, classe, nomOffre, type, config, typeDebit")
 */
class Offre
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
     * @ORM\Column(name="classe", type="string", length=255, nullable = true)
     */
    private $classe;

    /**
     * @var string
     * 
     * @ORM\Column(name="nomOffre", type="string", length=255)
     */
    private $nomOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="string", length=255, nullable=true)
     */
    private $config;

    /**
     * @var string
     *
     * @ORM\Column(name="typeDebit", type="string", length=255, nullable=true)
     *@Assert\Length(min=10)
     */
    private $typeDebit;

    /**
     * @var float
     *
     * @ORM\Column(name="debitMax", type="float", nullable=true)
     */
    private $debitMax;

    /**
     * @var float
     *
     * @ORM\Column(name="debitMin", type="float", nullable=true)
     */
    private $debitMin;

    /**
     * @var float
     *
     * @ORM\Column(name="configCalculee", type="float", nullable=true)
     */
    private $configCalculee;


    /**
     * @var float
     *
     * @ORM\Column(name="debitMinObtenu", type="float", nullable=true)
     */
    private $debitMinObtenu;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", nullable=false)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", nullable=false)
     */
    private $region;

    /**
     * @var float
     *
     * @ORM\Column(name="debitMaxGlobal", type="float", nullable=true)
     */
    private $debitMaxGlobal;

    /**
     * @var int
     *
     * @ORM\Column(name="maxHost", type="integer", nullable=true)
     */
    private $maxHost;
    
    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="taux", type="string",length = 255, nullable=true)
     */
    private $taux;

    /**
     * @var boolean
     *
     * @ORM\Column(name="typeConnexion", type="boolean", nullable=True)
     */
    private $typeConnexion;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isSelected", type="boolean", nullable=True)
     */
    private $isSelected;

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
     * Set nomOffre
     *
     * @param string $nomOffre
     *
     * @return Offre
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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Offre
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set debitMax
     *
     * @param integer $debitMax
     *
     * @return Offre
     */
    public function setDebitMax($debitMax)
    {
        $this->debitMax = $debitMax;

        return $this;
    }

    /**
     * Get debitMax
     *
     * @return int
     */
    public function getDebitMax()
    {
        return $this->debitMax;
    }

    /**
     * Set debitMin
     *
     * @param integer $debitMin
     *
     * @return Offre
     */
    public function setDebitMin($debitMin)
    {
        $this->debitMin = $debitMin;

        return $this;
    }

    /**
     * Get debitMin
     *
     * @return int
     */
    public function getDebitMin()
    {
        return $this->debitMin;
    }

    /**
     * Set debitAct
     *
     * @param integer $debitAct
     *
     * @return Offre
     */
    public function setDebitAct($debitAct)
    {
        $this->debitAct = $debitAct;

        return $this;
    }

    /**
     * Get debitAct
     *
     * @return int
     */
    public function getDebitAct()
    {
        return $this->debitAct;
    }

    /**
     * Set debitMoyen
     *
     * @param integer $debitMoyen
     *
     * @return Offre
     */
    public function setDebitMoyen($debitMoyen)
    {
        $this->debitMoyen = $debitMoyen;

        return $this;
    }

    /**
     * Get debitMoyen
     *
     * @return integer
     */
    public function getDebitMoyen()
    {
        return $this->debitMoyen;
    }

    /**
     * Set debitMaxGlobal
     *
     * @param integer $debitMaxGlobal
     *
     * @return Offre
     */
    public function setDebitMaxGlobal($debitMaxGlobal)
    {
        $this->debitMaxGlobal = $debitMaxGlobal;

        return $this;
    }

    /**
     * Get debitMaxGlobal
     *
     * @return integer
     */
    public function getDebitMaxGlobal()
    {
        return $this->debitMaxGlobal;
    }

    /**
     * Set maxHost
     *
     * @param integer $maxHost
     *
     * @return Offre
     */
    public function setMaxHost($maxHost)
    {
        $this->maxHost = $maxHost;

        return $this;
    }

    /**
     * Get maxHost
     *
     * @return integer
     */
    public function getMaxHost()
    {
        return $this->maxHost;
    }

    /**
     * Set taux
     *
     * @param string $taux
     *
     * @return Offre
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * Get taux
     *
     * @return string
     */
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * Set classe
     *
     * @param string $classe
     *
     * @return Offre
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set config
     *
     * @param string $config
     *
     * @return Offre
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set typeDebit
     *
     * @param string $typeDebit
     *
     * @return Offre
     */
    public function setTypeDebit($typeDebit)
    {
        $this->typeDebit = $typeDebit;

        return $this;
    }

    /**
     * Get typeDebit
     *
     * @return string
     */
    public function getTypeDebit()
    {
        return $this->typeDebit;
    }

    /**
     * Set debitMinObtenu
     *
     * @param integer $debitMinObtenu
     *
     * @return Offre
     */
    public function setDebitMinObtenu($debitMinObtenu)
    {
        $this->debitMinObtenu = $debitMinObtenu;

        return $this;
    }

    /**
     * Get debitMinObtenu
     *
     * @return integer
     */
    public function getDebitMinObtenu()
    {
        return $this->debitMinObtenu;
    }

    /**
     * Set configCalculee
     *
     * @param integer $configCalculee
     *
     * @return Offre
     */
    public function setConfigCalculee($configCalculee)
    {
        $this->configCalculee = $configCalculee;

        return $this;
    }

    /**
     * Get configCalculee
     *
     * @return integer
     */
    public function getConfigCalculee()
    {
        return $this->configCalculee;
    }

    public function getAll()
    {
        $tab[] = $this->classe;
        $tab[] = $this->nomOffre;

        return $tab;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Offre
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Offre
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

    /**
     * Set typeConnexion
     *
     * @param boolean $typeConnexion
     *
     * @return Offre
     */
    public function setTypeConnexion($typeConnexion)
    {
        $this->typeConnexion = $typeConnexion;

        return $this;
    }

    /**
     * Get typeConnexion
     *
     * @return boolean
     */
    public function getTypeConnexion()
    {
        return $this->typeConnexion;
    }

    /**
     * Set regle
     *
     * @param \Telma\DashboardBundle\Entity\Regle $regle
     *
     * @return Offre
     */
    public function setRegle(\Telma\DashboardBundle\Entity\Regle $regle = null)
    {
        $this->regle = $regle;

        return $this;
    }

    /**
     * Get regle
     *
     * @return \Telma\DashboardBundle\Entity\Regle
     */
    public function getRegle()
    {
        return $this->regle;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Offre
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
     * Set isSelected
     *
     * @param boolean $isSelected
     * @return Offre
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Get isSelected
     *
     * @return boolean 
     */
    public function getIsSelected()
    {
        return $this->isSelected;
    }
}
