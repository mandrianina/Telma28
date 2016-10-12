<?php 

namespace Telma\DashboardBundle\Controller;

use Telma\DashboardBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Telma\DashboardBundle\Form\OffreType;
use Telma\DashboardBundle\Form\HeadType;
use Telma\DashboardBundle\Form\EnteteType;
use Telma\DashboardBundle\Entity\Head;
use Telma\DashboardBundle\Entity\Entete;
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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* 
*/

/*index sera en charge d'afficher un select ou l'on choisira la reference et la region voulue
/*view sera en charge d'afficher la reference selectionnee dans l'index, de sauvegarder
/*import sera en charge d'importer un fichier de le lire et de le sauvegarder puis de l'envoyer a view
*/
class MainController extends Controller
{
	//Fonction pour lire les fichier csv
	protected function lire_csv($nom_fichier, $separateur =";"){
    	$row = 0;
    	$donnee = array();    
    	$f = fopen ($nom_fichier,"r") or die ("Can't open the file");
    	$taille = filesize($nom_fichier)+1;
    	while ($donnee = fgetcsv($f, $taille, $separateur)) {
        	$result[$row] = $donnee;
        	$row++;
   		}
    	fclose ($f);
    	return $result;
	}
        
        //Ajax 
        public function getRegionAction($reference){
            $em = $this->getDoctrine()->getManager();
            $offres = $em->getRepository('TelmaDashboardBundle:Offre')->findByReference($reference);
            $regions = array();
            
            foreach($offres as $offre)
            {
                $regions[] = $offre->getRegion();
            }
            $regions = array_unique($regions);
            
            $response = new JsonResponse();

            return $response->setData(array('regions' => $regions));

        }


	public function indexAction(Request $request)
	{	
		$page = 'index';
		$em = $this->getDoctrine()->getManager();
		$refs = array('Choisir');

		$dataArray = $em->getRepository('TelmaDashboardBundle:Data')->findAll();
		$data = $dataArray[0];
		$form = $this->createForm(DataType::class, $data);

		if($request->isMethod('POST'))
		{
			$form->handleRequest($request);

			if($form->isValid())
			{
				$em->persist($data);
				$em->flush();
			}

		}

		if ($offres = $em->getRepository('TelmaDashboardBundle:Offre')->findAll())
		{
		foreach ($offres as $var) {
			$tempRefs[] = $var->getReference();
		}
	}
		else
		{
			$tempRefs = array();
		}
		$refs = array_unique($tempRefs);
		
		 return $this->render('TelmaDashboardBundle:Dashboard:index.html.twig', array(
		 			'page' => $page,
		 			'arrayReferences' => $refs,
		 			'form' => $form->createView()
		 	));
	}
        
        public function vieweditAction(Request $request)
        {
            $page = "view";
            $reference = $request->get('reference');
            $region = $request->get('region');    

            $em = $this->getDoctrine()->getManager();
            $edit = new Edit();

            $offres = $em->getRepository('TelmaDashboardBundle:Offre')
					->findBy(
						array('reference' => $reference,
						 	  'region' => $region),
                                                array('position' => 'ASC')
						);
            $originalOffres = new ArrayCollection();
            
            foreach($offres as $offre)
            {
                $edit->getOffres()->add($offre);
                $originalOffres->add($offre);
                     
            }
            
            $form = $this->createForm(EditType::class, $edit);
            
            if($request->isMethod('POST'))
            {
                $form->handleRequest($request);
                if($form->isValid())
                {
                    foreach ($originalOffres as $offre)
                    {
                        if(false === $edit->getOffres()->contains($offre))
                        {
                            $em->remove($offre);
                        }
                    }
                    $newsOffres = $edit->getOffres();
                    
                    foreach($newsOffres as $offre)
                    {
                        if($offre->getId() === null)
                        {
                            $offre->setReference($reference);
                            $offre->setRegion($region);
                        }
                        $em->persist($offre);
                    }
                    $em->flush();           
                    
                return $this->redirectToRoute('telma_dashboard_viewedit', array('reference' => $reference, 'region' => $region));   
                }
                
            }
            return $this->render('TelmaDashboardBundle:Dashboard:viewedit.html.twig', 
                    array('form' => $form->createView(),
                          'page' => $page,
                          'reference' => $reference,
		 	  'region' => $region
                    ));
        }
		
	public function importAction(Request $request){
		$page = 'import';
		$em = $this->getDoctrine()->getManager();
		$dataArray = $em->getRepository('TelmaDashboardBundle:Data')->findAll();
		$data = $dataArray[0];
		$offresFixesBrut = $data->getOffresFixes();

		$product = new Product();
		$product->setOffresFixes($offresFixesBrut);

		$form = $this->createForm(ProductType::class, $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$file = $product->getFichier();

			$fileName = md5(uniqid()).'.'.$file->guessExtension();

			$file->move(
				$this->getParameter('file_directory'),
				$fileName
				);

			$product->setFichier($fileName);

			$location = $this->getParameter('file_location') . $fileName;

			$em = $this->getDoctrine()->getManager();
			$em->persist($product);

			$text = $this->lire_csv(__DIR__."/../../../../".$location);
			$reference = $this->get('slugify')->slugify($product->getReferenceProduit());
			$region = $product->getRegionProduit();

			$LignesoffresFixes = preg_split ('/$\R?^/m', $product->getOffresFixes());
			$offresFixes = array();
			foreach ($LignesoffresFixes as $ligneOffre) {
				$offresFixes[] = explode(":", $ligneOffre);
			}
                        $incr = 0;
                        $var = sizeof($text[0]);


			if ($reference === 'TOUS')
			{
				foreach ($text as $ligne) {
				$offre = new Offre();
				$offre->setClasse($ligne[0]);
				$offre->setNomOffre($ligne[1]);
				$offre->setType($ligne[2]);
				$offre->setDebitMax((float)$ligne[3]);
				$offre->setDebitMaxGlobal((float)$ligne[4]);
				$offre->setMaxHost((int)$ligne[6]);
				$offre->setConfig($ligne[7]);
				$offre->setTypeDebit($ligne[8]);
				$offre->setDebitMin((float)$ligne[9]);
				$offre->setTaux($ligne[10]);
				$offre->setReference($reference);
				$offre->setRegion($region);
                                $offre->setPosition($incr);
				$em->persist($offre);
                                $incr++;
                            }
			}
			else
                            {
			foreach ($text as $ligne) {
				$offre = new Offre();
				$offre->setClasse($ligne[0]);
				$offre->setNomOffre($ligne[1]);
				$offre->setType($ligne[2]);
				$offre->setDebitMax((float)$ligne[3]);
				$offre->setDebitMaxGlobal((float)$ligne[4]);
				$offre->setMaxHost((int)$ligne[6]);
				$offre->setConfig($ligne[7]);
				$offre->setTypeDebit($ligne[8]);
				$offre->setDebitMin((float)$ligne[9]);
				$offre->setTaux($ligne[10]);
				$offre->setDebitMinObtenu((float)$ligne[11]);
				$offre->setReference($reference);
				$offre->setRegion($region);
                                $offre->setPosition($incr);
				$em->persist($offre);
                                $incr++;
                                }
                            }				
			foreach ($offresFixes as $ligneAajouter) {
				$offre = new Offre();
				$offre->setNomOffre($ligneAajouter[0]);
				$offre->setDebitMaxGlobal($ligneAajouter[1]);
				$offre->setTypeConnexion(true);
				$offre->setReference($reference);
				$offre->setRegion($region);
                                $offre->setPosition($incr);
				$em->persist($offre);
                                $incr++;
                            }
			$em->flush();

			return $this->redirectToRoute('telma_dashboard_viewedit', array('reference'=> $reference, 'region' => $region));

		}

		return $this->render('TelmaDashboardBundle:Dashboard:import.html.twig', array('form' => $form->createView(),
					'page' => $page
			));

	}
        
        public function editEnteteAction(Request $request)
        {
            $page = "entete";
            $em = $this->getDoctrine()->getManager();
            $head = new Head();
            $entetes = $em->getRepository('TelmaDashboardBundle:Entete')->findBy([], ['position' => 'ASC']);
            $entetesOriginal = new ArrayCollection();
            if (!$entetes)
            {
                throw new NotFoundHttpException("Pas d'entete dans la base, veuillez charger la configuration par défaut");
            }
            
            foreach($entetes as $entete)
            {
                $head->getEntetes()->add($entete);
                $entetesOriginal->add($entete);
            }
            $form = $this->createForm(HeadType::class, $head);
            
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                foreach($entetesOriginal as $org){
                    if ( false === $head->getEntetes()->contains($org))
                    {
                        $em->remove($org);
                    }
                }
                
                $em->persist($head);
                $em->flush();
                $session = $request->getSession();
                $session->set('head', $head);
                
                return $this->redirectToRoute('telma_dashboard_enteteEdit');
            }
            return $this->render('TelmaDashboardBundle:Dashboard:entete.html.twig', 
                                                                                    array('form' => $form->createView(),
                                                                                          'page' => $page));
            
            
            
        }

	public function reportsAction(Request $request)
	{
		//If POST render chart and form
		//If not POST render form
		$page = "reports";

		$em = $this->getDoctrine()->getManager();
		$offres = $em->getRepository('TelmaDashboardBundle:Offre')->findAll();
		foreach ($offres as $var) {
			$tempRefs[] = $var->getReference();
		}
		$refs = array_unique($tempRefs);

		$arrayColumn = array(
			'DebitMaxGlobal',
			'MaxHost',
			'Taux',
			'ConfigCalculee'
			);


		if ($request->isMethod('GET'))
		{
			$reference = $request->get('reference');
			$region = $request->get('region');
			$choix = $request->get('column');

			$offres = $em->getRepository('TelmaDashboardBundle:Offre')->findBy(array('reference' => $reference,
																				 'region' => $region));
			$datas = array();
			$temp_datas = array();
			foreach ($offres as $offre) {
				if ($choix === 'DebitMaxGlobal')
				{
					$temp_datas[$offre->getNomOffre()] = $offre->getDebitMaxGlobal();
				}
				elseif ($choix === 'MaxHost') {
					$temp_datas[$offre->getNomOffre()] = $offre->getMaxHost();
				}
				elseif ($choix === 'Taux') {
					$temp_datas[$offre->getNomOffre()] = $offre->getTaux();
				}
				elseif( $choix === 'ConfigCalculee') {
					$temp_datas[$offre->getNomOffre()] = $offre->getConfigCalculee();
				}
				else
				{
					$datas = array(
								'Hello' => 20.5,
								'Good'  => 29.5,
								'Worked'=> 10,
								'Boss'  => 25,
								'Thanks'=> 15
								);
				}
			}

			$total = 0;
			foreach ($temp_datas as $key => $num) {
				$total +=(float)$num;
			}

			if($total === 0)
			{
				$total = 100;
			}

			foreach ($temp_datas as $key => $value) {
				$datas[$key] = (($value * 100)/$total);
			}



			return $this->render('TelmaDashboardBundle:Dashboard:ColumnDrilldown.html.twig',
                                                                                                          array('page' => $page,
														'datas' => $datas,
														'arrayReferences' => $refs,
														'arrayColumn' => $arrayColumn,
														'columnChoisi' => $choix,
														'referenceChoisi' => $reference,
														'regionChoisi' => $region));
		}

		 // Le noms des offres avec leurs pourcentages

		return $this->render('TelmaDashboardBundle:Dashboard:ColumnDrilldown.html.twig',
                                                                                                array('page' => $page,
                                                                                                      'datas' => $datas,
												      'arrayReferences' => $refs,
												      'arrayColumn' => $arrayColumn));
	}	
	
}
