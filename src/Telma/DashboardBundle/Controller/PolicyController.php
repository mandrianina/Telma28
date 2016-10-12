<?php 

namespace Telma\DashboardBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Telma\DashboardBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Telma\DashboardBundle\Form\OffreType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Telma\DashboardBundle\Entity\Regle;
use Telma\DashboardBundle\Form\RegleType;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
* 
*/

/*index sera en charge d'afficher un select ou l'on choisira la reference et la region voulue
/*view sera en charge d'afficher la reference selectionnee dans l'index, de sauvegarder
/*import sera en charge d'importer un fichier de le lire et de le sauvegarder puis de l'envoyer a view
*/
class PolicyController extends Controller
{
	public function policyAction(Request $request)
	{
		$page = "policy";
		$em = $this->getDoctrine()->getManager();

                if(!$request->get('reference') && !$request->get('region'))
                {
                    return $this->redirectToRoute('telma_dashboard_homepage');
                }
                $reference = $request->get('reference');
		$region = $request->get('region');	

		$offers = $em->getRepository('TelmaDashboardBundle:Offre')
					->findBy(
						array('reference' => $reference,
						      'region' => $region)
						);

                $rulesRepo = $em->getRepository('TelmaDashboardBundle:Regle');
		$matriceShapers = "##Shapers definitions####################################################\n";
		foreach ($offers as $offre) {
			$var = $offre->getNomOffre();
                        if($rule = $rulesRepo->findOneByNomOffre($this->get('slugify')->slugify($var)))
                        {
                            $alias = $rule->getAlias();
                            $contenu = $rule->getContenu();
                            if($alias != null || $alias != "")
                            {
                                $var = $alias;
                            }
                        }
                        else
                        {
                            $alias = null;
                            $contenu = null;
                        }
                        if($var[0] != '"')
                        {
                                 $var = '"'.$var.'_down"';
                                    $var = $var." ".round($offre->getConfigCalculee())."Mbps distribution dynamic depth 5 slots";
                                    $matriceShapers = $matriceShapers . "shaper ".$var . "\n\n" ;
                        }
                         else
                            {
                                    $var = $var." ".round($offre->getConfigCalculee())."Mbps distribution dynamic depth 5 slots";
                                    $matriceShapers = $matriceShapers ."shaper ".$var . "\n\n" ;
                            }
                        if($contenu != null || $contenu != "")
                        {
                            $matriceShapers = $matriceShapers .$contenu ."\n\n" ;
                            $contenu = null ;
                        }
                }       
		return $this->render('TelmaDashboardBundle:Dashboard:policy.html.twig', array('page' => $page, 'matrice' => $matriceShapers));
	}

	public function addrulesAction(Request $request)
	{

		$em = $this->getDoctrine()->getManager();
		$page = "rules";

                $offres = $em->getRepository('TelmaDashboardBundle:Offre')->findAll();
                $arrayNomOffres = array();
                foreach ($offres as $offre)
                {
                    $arrayNomOffres[] = $this->get('slugify')->slugify($offre->getNomOffre());
                }
                $arrayNomOffres = array_unique($arrayNomOffres);

		if($request->isMethod('POST'))
		{
			$rule = $em->getRepository('TelmaDashboardBundle:Regle')->findOneByNomOffre($this->get('slugify')->slugify($request->request->get('nom')));
                        if(!$rule)
                        {
                            $rule = new Regle();
                            $rule->setNomOffre($this->get('slugify')->slugify($request->request->get('nom')));
                        }
                        $rule->setContenu($request->request->get('contenu'));
                        $rule->setAlias($request->request->get('alias'));
                        $em->persist($rule);
                        $em->flush();

			return $this->redirectToRoute('telma_dashboard_addrules');
		}

		return $this->render('TelmaDashboardBundle:Dashboard:regle.html.twig',
                                                                                array('page' => $page,
                                                                                      'arrayNomOffres' => $arrayNomOffres));

	}

	//AJAXXXXXXX
        public function getContenuAction(Request $request)
        {
            $nom = $request->request->get('nom');
            $em = $this->getDoctrine()->getManager();
            $regle = $em->getRepository('TelmaDashboardBundle:Regle')->findOneByNomOffre($this->get('slugify')->slugify($nom));

            $contenu = $regle === null ? null : $regle->getContenu();
            $alias = $regle === null ? null : $regle->getAlias();
            $response = new JsonResponse();

            return $response->setData(array('contenu' => $contenu,
                                            'alias' => $alias));

        }
        
         public function getDataAction()
        {
            $em = $this->getDoctrine()->getManager();
            $offres= $em->getRepository('TelmaDashboardBundle:Offre')->findAll();
            $tab = array();
            $offreValues = array();
            $response = new JsonResponse();

            return $response->setData(array('offres' => $tab));

        }

}