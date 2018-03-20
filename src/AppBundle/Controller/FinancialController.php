<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\AccountsStatementFile;
use AppBundle\Form\AccountsStatementFileType;
use AppBundle\Entity\TransferAccountsStatementFile;


class FinancialController extends Controller
{


    /**
     * @Route("/financialimportcsv", name="importcsv")
     */
    public function importCSVAction(Request $request)
    {
// TODO Should be a dialog box --> Start with specific page
/*        if (!ini_get('file_uploads')) {
                $this->addFlash(
                        'success',
                        'Your new environment were saved!'
                );
                return $this->redirectToRoute('importcsv');
        }*/
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user == 'anon.')
        {
            $this->addFlash(
                        'error',
                        'You are not logged !!'
            );

            return $this->redirectToRoute('fos_user_security_login');
        }

        $accountsStatementFile = new \AppBundle\Entity\AccountsStatementFile();
        $form= $this->createForm(new \AppBundle\Form\AccountsStatementFileType(), $accountsStatementFile);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // the validation passed, do something with the $author object

                $file = $accountsStatementFile->getFileName();
                $fileOriginal = $file->getClientOriginalName();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('accountsStatementFile_directory'),$fileName);
                $accountsStatementFile->setFileName($fileName);
                $accountsStatementFile->setOriginalFileName($fileOriginal);
                $accountsStatementFile->setUserId($user->getId());
                
                
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($accountsStatementFile);
                $em->flush();

                $returnXls = $this->extractXlsToDb($accountsStatementFile->getId(),$this->getParameter('accountsStatementFile_directory'). "/" . $fileName);
                $returnXls = true;
                
                if ($returnXls == true)
                {
                $this->addFlash(
                        'success',
                        'Your new file '.$fileOriginal.' were saved!'
                );
                return $this->redirectToRoute('validatetransferfile', array('fileId'=>$accountsStatementFile->getId()));
                
                }
// EXEM                return $this->redirectToRoute('release_show', array('id' => $release->getId()));
                //return $this->redirectToRoute('importcsv');
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
    
    /**
     * @Route("/financialvalidatetransferfile/{fileId}", name="validatetransferfile")
     
     */
    public function validateTransferFileAction(Request $request,$fileId)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user == 'anon.')
        {
            $this->addFlash(
                        'error',
                        'You are not logged !!'
            );

            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $AccountsStatementFileRepository = $em->getRepository('AppBundle:AccountsStatementFile');
        $file=$AccountsStatementFileRepository->findById($fileId);
        // Only one record
        $userId = $file[0]->getUserId();
        if ($userId != $user->getId())
        {
            $this->addFlash(
                        'error',
                        'You can\'t have acces to this transfer !!'
            );

            return $this->redirectToRoute('home');
            
        }
//        print_r($file);
        print_r($file[0]->getOriginalFilename());
        $TransferAccountsStatementFileRepository = $em->getRepository('AppBundle:TransferAccountsStatementFile');
        $transferList=$TransferAccountsStatementFileRepository->findByFileId($fileId);
        // TODO Check if the accountId is user logged, otherwise, refuse.
        //$this->view->title = "summary";
        //$this->view->transferList = $transferList;
        // TODO check when empty
        return $this->render('financial/validatetransferfile.html.twig', array(
            'transferList' => $transferList,
            'filename' => $file[0]->getOriginalFilename()
        ));

        
        
    }
    /**
     * @Route("/financial", name="financial_list_transfer")
     */
    public function listTransferAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        print_r($user->getId());  
        return print_r($user);  
        
        /*
        $listAccount = new ListAccount();
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
*/
    }
    
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    
    private function extractXlsToDb($id,$filename)
    {
                $csvManager = $this->get('phpoffice.spreadsheet');
                $csvReader = $csvManager->createReader('Csv');
                $csvFields->load($filename);
//        print_r($id);
//        print_r($filename);
                $em = $this->getDoctrine()->getManager();

                $transferAccountsStatementFile = new \AppBundle\Entity\TransferAccountsStatementFile();
// TODO loop
                $transferAccountsStatementFile->setAccountsStatementFileId($id);
                $transferAccountsStatementFile->setAmount(10);
                $transferAccountsStatementFile->setCounterpartment("blala1");
                $transferAccountsStatementFile->setCurrency("EUR");
                $transferAccountsStatementFile->setDetails("virement");
                $transferAccountsStatementFile->setExecutionDate("20172431");
                $transferAccountsStatementFile->setSequenceNumber(12);
                $transferAccountsStatementFile->setValueDate("20170221");
             // Open file   
                
                $em->persist($transferAccountsStatementFile);
                $em->flush();
    }
    
}
