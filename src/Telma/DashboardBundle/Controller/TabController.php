<?php 

namespace Telma\DashboardBundle\Controller;

use Telma\DashboardBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Telma\DashboardBundle\Form\OffreType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Telma\DashboardBundle\Entity\Edit;
use Telma\DashboardBundle\Form\EditType;
use Telma\DashboardBundle\Entity\Product;
use Telma\DashboardBundle\Form\ProductType;
use Telma\DashboardBundle\Entity\Data;
use Telma\DashboardBundle\Form\DataType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use APY\DataGridBundle\Grid\Source\Vector;
use APY\DataGridBundle\Grid\Source\Entity;
/**
* 
*/

/*index sera en charge d'afficher un select ou l'on choisira la reference et la region voulue
/*view sera en charge d'afficher la reference selectionnee dans l'index, de sauvegarder
/*import sera en charge d'importer un fichier de le lire et de le sauvegarder puis de l'envoyer a view
*/
class TabController extends Controller
{


//Fonction pour calculer n% de total
	protected function pourcentage($total, $pourc){
		$n = $pourc;
		if ($pourc <= 1 && $pourc > 0)
		{
			$resultat = ($n * $total)/100;
			return $resultat;
		}
		return 0;
	}
        
        //Fonction de calcul 
        
        protected function calculTaux($config = 0.0, $maxhost = 1.0, $minbd = 1.0)
        {
            $resultat = 0.0;
            //Config en Ko
            if($maxhost != 0 && $minbd != 0)
            {
               $a = $config * 1024;
            
                //Config / maxhost
                $b = $a / $maxhost;

                //Config / Maxhost / Min par bande
                $resultat = $b / $minbd;
            }
            
            
            return $resultat;
        }
        
        protected function calculMinObtenu($config = 0.0 , $maxhost = 1.0)
        {
            if($maxhost != 0)
            {
                $config = $config * 1024;
                $resultat = $config / $maxhost;
                return $resultat;
            }
            else
                return 0;
        }


public function calculAction(Request $request)
	{

		//Fixed Max Global
		//iRenala 50, Gulfsat 150, Google 750, Akamai 1000, Serveur 50

		$reference = $request->get('reference');
		$region = $request->get('region');
		$autres = (int)$request->get('others');
		$total = $autres;


		//Algorithme simple :)
		$em = $this->getDoctrine()->getManager();


                //Cherchons ensuite les offres non fixes
		$offresAchanger = $em->getRepository('TelmaDashboardBundle:Offre')->findBy(array( 'reference' => $reference,
												  'region' => $region,
												  'typeConnexion' => false,
                                                                                                  'isSelected' => true));
		$tab = array();
		$tabs = array();
		//recuperation de tous les offres a changer
		foreach ($offresAchanger as $offre) {
			$tab['offre'] = $offre;
			//Debit Min par bande et par offre
			$tab['offre']->setDebitMinObtenu(0) ;
			//Debit max par bande et par offre
			$tab['offre']->setDebitMaxGlobal( ((float)$tab['offre']->getDebitMax() * (int)$tab['offre']->getMaxHost())/1024) ;
			//Remise a zéro
			$tab['offre']->setConfigCalculee(0);
			$tab['offre']->setTaux(0);
                        $tab['offre']->setIsSelected(false);
			$tabs[] = $tab;
		}
		
		$accuracyArray = $em->getRepository('TelmaDashboardBundle:Data')->findAll();
		$accuracy = $accuracyArray[0]->getAccuracy();

		//Pour les autres
		//Etape 1 On essaye d'avoir le debit minimum souhaités pour chaque offre
		$etat = true;
		while($etat && $total > 0){//Tant qu'il y a des offres en dessous des valeur min et que total soit valide
			$etat = false;
			foreach ($tabs as $tab) {
				$offreActuelle = $tab['offre'];
                                $minParOffre = ($offreActuelle->getMaxHost() * $offreActuelle->getDebitMin())/1024;
				if ($offreActuelle->getConfigCalculee() < $minParOffre){
					$etat = true;
					$Aenlever = $this->pourcentage($minParOffre, $accuracy);
					$offreActuelle->setConfigCalculee($offreActuelle->getConfigCalculee() +  $Aenlever);
                                        $offreActuelle->setDebitMinObtenu($this->calculMinObtenu($offreActuelle->getConfigCalculee(), $offreActuelle->getMaxHost()));
					$total -= $Aenlever;
					$em->persist($offreActuelle);
					}
			}
		}
		
		$c = $total > 0 ? $total : 0 ; //Reste a distribuer si existe
		if (!$c)
		{
			foreach ($tabs as $tab) {
				$offre = $tab['offre'];
				if($offre->getDebitMaxGlobal() > 0)
				{
                                $offre->setDebitMinObtenu($this->calculMinObtenu($offre->getConfigCalculee(), $offre->getMaxHost()));
				$offre->setTaux($this->calculTaux($offre->getConfigCalculee(), $offre->getMaxHost(), $offre->getDebitMin()));
				}
			}
		}

		//Etape 2 Si il reste encore dans total et il y a encore de place disponible
		$encore = true;
		
		while($total > 0 && $encore)
		{
			$encore = false;
			foreach ($tabs as $array) {
				$tab = $array['offre'];
				if($tab->getConfigCalculee() < $tab->getDebitMaxGlobal())
				{
					$encore = true;
                                        $minParOffre = ($tab->getMaxHost() * $tab->getDebitMin())/1024;
					$difference = $tab->getDebitMaxGlobal() - $minParOffre;
					$pourc = $this->pourcentage($difference, $accuracy);
					$tab->setConfigCalculee(($tab->getConfigCalculee() + $pourc));
                                        $tab->setDebitMinObtenu($this->calculMinObtenu($tab->getConfigCalculee(), $tab->getMaxHost()));
					$total -= $pourc;
					$tab->setTaux($this->calculTaux($tab->getConfigCalculee(), $tab->getMaxHost(), $tab->getDebitMin()));
				}
			}
		}


		$em->flush();

		return $this->redirectToRoute('telma_dashboard_viewedit', array('reference'=> $reference,
										'region' => $region,
										));
	}
        
public function calculSTDAction(Request $request)
	{

		$reference = $request->get('reference');
		$region = $request->get('region');

		$em = $this->getDoctrine()->getManager();

		//Cherchons tous les offres fixes
		$offresFixe = $em->getRepository('TelmaDashboardBundle:Offre')->findBy(
                                                                                 array( 'reference' => $reference,
											'region' => $region,
											'typeConnexion' => true
											));
		//Pour les offres fixes
		foreach ($offresFixe as $offre) {
				$debitAttribue = $offre->getDebitMaxGlobal();
				$offre->setConfigCalculee($debitAttribue); //Recuperation et calcul
                                if($offre->getDebitMaxGlobal() === 0)
                                {
                                    $offre->setTaux(0);
                                }
                                else
                                {
                                    $offre->setTaux($offre->getConfigCalculee() / $offre->getDebitMaxGlobal());
                                }
				$em->persist($offre);
			}

		//Cherchons ensuite les offres non fixes
		$offresAchanger = $em->getRepository('TelmaDashboardBundle:Offre')->findBy(
                                                                                          array('reference' => $reference,
												'region' => $region,
												'typeConnexion' => false));


		//recuperation de tous les offres a changer
		foreach ($offresAchanger as $offre) {
			//Debit Min par bande et par offre
			
			//Debit max par bande et par offre
			$offre->setDebitMaxGlobal( ((float)$offre->getDebitMax() * (int)$offre->getMaxHost())/1024) ;
			//Config et taux
			$offre->setConfigCalculee(($offre->getDebitMin() * $offre->getMaxHost())/1024);
                        $offre->setDebitMinObtenu($this->calculMinObtenu($offre->getConfigCalculee(), $offre->getMaxHost())) ;
                        if($offre->getDebitMaxGlobal() == 0)
                        {
                            $offre->setTaux(0);
                        }
                        else
                        {
                            $offre->setTaux($this->calculTaux($offre->getConfigCalculee(), $offre->getMaxHost(), $offre->getDebitMin()));
                        }
			
                        $em->persist($offre);
		}

		$em->flush();

		return $this->redirectToRoute('telma_dashboard_viewedit', array('reference'=> $reference,
										'region' => $region,
										));
	}
        
        public function apercuAction()
        {
            return $this->render('TelmaDashboardBundle:Dashboard:apercu.html.twig', array('page' => 'apercu'));
        }

        public function myGridAction()
        {
            
            $em = $this->getDoctrine()->getManager();
            
            $reference = 'septembre';
            $region = 'Tulear';
            $offres = $em->getRepository('TelmaDashboardBundle:Offre')->findBy(array('reference' => $reference));
            
            $grid = $this->get('grid');
            
            //$sources = new Entity('TelmaDashboardBundle:Offre');
            //$sources = new Entity('TelmaDashboardBundle:Edit');
            $sources = new Vector($offres);
            $grid->setSource($sources);
            
            
            return $grid->getGridResponse('TelmaDashboardBundle:Dashboard:grid.html.twig', array('page' => 'grid'));
        }
}