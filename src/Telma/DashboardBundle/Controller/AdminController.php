<?php 

namespace Telma\DashboardBundle\Controller;

use Telma\DashboardBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Telma\DashboardBundle\Form\OffreType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Telma\DashboardBundle\Entity\Edit;

use Telma\DashboardBundle\Entity\Data;


use Telma\DashboardBundle\Entity\Entete;
use Telma\DashboardBundle\Entity\Head;
/**
* 
*/

/*index sera en charge d'afficher un select ou l'on choisira la reference et la region voulue
/*view sera en charge d'afficher la reference selectionnee dans l'index, de sauvegarder
/*import sera en charge d'importer un fichier de le lire et de le sauvegarder puis de l'envoyer a view
*/
class AdminController extends Controller
{
	public function resetdbAction(Request $request)
	{
		$requete = "db";
		if($request->isMethod('POST'))
		{
			$em = $this->getDoctrine()->getManager();
			$offres = $em->getRepository('TelmaDashboardBundle:Offre')->findAll();

			foreach ($offres as $offre) {
				$em->remove($offre);
			}
			$em->flush();
			return $this->redirectToRoute('telma_dashboard_homepage');
		}
		

		return $this->render('TelmaDashboardBundle:Dashboard:reset.html.twig',array('page' => $requete));
	}

	public function resetparamAction(Request $request)
	{
		$requete = "param";

		if ($request->isMethod('POST'))
		{

		$em = $this->getDoctrine()->getManager();
		$ancienDatas = $em->getRepository('TelmaDashboardBundle:Data')->findAll();

		foreach ($ancienDatas as $ancienData) {
			$em->remove($ancienData);
			$em->flush();
		}
		$data = new Data();
		$data->setStm16(2200);
		$data->setStm4(550);
		$data->setAccuracy(1);
		$data->setOffresFixes('
"NAS_down":1
"GGC_INTERNET_down":1500 
"AKAMAI_INTERNET_down":750 
"ORANGE_INTERNET_down":150 
"GULFSAT_INTERNET_down":450 
"AIRTEL_down":150 
"SKYPE_down":300
"WEBMAIL_down":900
"P2P_encr_down_6_to_22":1
"P2P_down_6_to_1":1
"external_down":0.512
"HOME_VIP_STAR_down":23
"MONITORING_down":3
"RTC_down":3
"CPERFORMANCE_down":10
"JOUVE_down":28
"STAR_down":6
"CAUDIT5_down_HP":100    
"CAUDIT5_down_HC":250    
"DSI_LAN_down":30   
"DSI_LAN_anonymity_down":0.8  
"TELMA_STAFF_down":5   
"C3G_down":50   
"TELMA_down_HP":700    
"TELMA_icmp_down":0.64    
"TELMA_LTE_down":30    
"C_MOBILE_MICROCRED_down":6   
"MOBILE_POSTPAID_down":100          
"CUSTOMER_SERVEUR_down":5    
"CMADAREN_down":150      
"FTTX_down_HP":434    
"FTTX_down_HC":600       
"HOME_GULFSAT_O3B_down":300    
"HOME_ORANGE_down":150    
"HOME_down_HP":974    
"HOME_down_HC":1000    
"HOME_down_HC2":1000    
"HOME_down_HC3":1000     
"ICMP_down":5     
"REMOTE_CONTROL_down":50     
"CHINA_NET_down": 500    
"GC_D_3_U_1_down":3     
		');
		$em->persist($data);
		$em->flush();

		return $this->redirectToRoute('telma_dashboard_homepage');
	}

	return $this->render('TelmaDashboardBundle:Dashboard:reset.html.twig',array('page' => $requete));
	}
        
        public function loadDefaultAction(){
            $em = $this->getDoctrine()->getManager();
            
            //Partie entete
            $head = new Head();
            $originalEntete = $em->getRepository('TelmaDashboardBundle:Entete')->findAll();
            foreach($originalEntete as $org)
            {
                $em->remove($org);
            }
            $nomEntete = array('classe', 'offre', 'type','Config D/T', 'Type Debit G/NG', 'MAX Global', 'Commentaire', 'Max Debit Int', 'Min Souhaités', 'Min Obtenu', 'Coef', 'Config');
               $champs = array('classe', 'offre', 'type', 'config',    'typeDebit',       'debitMG',    'commentaire', 'debitMax',      'debitMin',     'debitMinObtenu', 'taux', 'configCalculee');
            $i = 0;
            foreach($nomEntete as $nom)
            {
                $entete = new Entete();
                $entete->setNom($nom);
                $entete->setPosition($i);
                $entete->setChamp($champs[$i]);
                $entete->setIsNotUsed(false);
                $em->persist($entete);
                $head->getEntetes()->add($entete);
                $i++;
            }
            $entetes = $head->getEntetes();

            $em->flush();
            return $this->redirectToRoute('telma_dashboard_homepage');
        }
        

}