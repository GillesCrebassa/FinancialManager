<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FinancialController extends Controller
{


    /**
     * @Route("/importcsv", name="importcsv")
     */
    public function importCSVAction(Request $request)
    {

        $environment = new Environment();
        $form= $this->createForm(new EnvironmentType(), $environment);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // the validation passed, do something with the $author object
                $em = $this->getDoctrine()->getManager();
                $em->persist($environment);
                $em->flush();

                $this->addFlash(
                        'success',
                        'Your new environment were saved!'
                );
                return $this->redirectToRoute('environment_summary');
            }
            else {
                $this->addFlash(
                        'warning',
                        'some fields are not correct!'
                );
            }
        }
        return $this->render('financial/importcsv.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
