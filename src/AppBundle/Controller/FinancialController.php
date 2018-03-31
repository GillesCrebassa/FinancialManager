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
                
                
                // TODO add status error
                $em = $this->getDoctrine()->getManager();
                $em->persist($accountsStatementFile);
                $em->flush();
                
                $returnXls = $this->extractXlsToDb($accountsStatementFile->getId(),$this->getParameter('accountsStatementFile_directory'). "/" . $fileName);
                if ($returnXls == true)
                {
                    unlink($this->getParameter('accountsStatementFile_directory').'/'.$fileName);
                    $this->addFlash(
                            'success',
                            'Your new file '.$fileOriginal.' were imported!'
                    );
                    return $this->redirectToRoute('validatetransferfile', array('fileId'=>$accountsStatementFile->getId()));
                
                }
                else
                {
                    //TODO No color for error ?
                    // special page for all errors ?
/*                    $this->addFlash(
                        'error',
                        'An issue has detected during the import!</br>'.$error
 
                );
*/                    
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
        // TODO Check if transfer already exists
        //print_r($file[0]->getOriginalFilename());
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
                $em = $this->getDoctrine()->getManager();
        // TODO ROLLBACK/COMMIT
                $csvManager = $this->get('phpoffice.spreadsheet');
                $csvReader = $csvManager->createReader('Csv');
                $spreadsheet = $csvReader->load($filename);
//        print_r($id);
//        print_r($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                //print_r($sheetData);
                $rowNumber = sizeof($sheetData);
                
                for ($i=1;$i<$rowNumber;$i++)
                {
                    $rowData=$sheetData[$i];
                    $columnNumber=sizeof($rowData);
                    print($columnNumber);
                    if ($columnNumber != 8)
                    {
                        // TODO ERROR with line
                        $this->addFlash(
                            'error',
                            'An issue has detected during the import in the line '.$i.'!'
                                . 'The number of culomn is not 8'
                        );
                        $em->clear(); 
                        return false;
                    }
                    // TODO check this account + SequenceNumber not existing and already insert in File and Transfer
                    $transferAccountsStatementFile = new \AppBundle\Entity\TransferAccountsStatementFile();
                    
                    $transferAccountsStatementFile->setAccountsStatementFileId($id);

                    $transferAccountsStatementFile->setSequenceNumber($rowData[0]);
                    $transferAccountsStatementFile->setExecutionDate($rowData[1]);
                    $transferAccountsStatementFile->setValueDate($rowData[2]);
                    $transferAccountsStatementFile->setAmount($rowData[3]);
                    $transferAccountsStatementFile->setCurrency($rowData[4]);
                    $transferAccountsStatementFile->setCounterpartment($rowData[5]);
                    $transferAccountsStatementFile->setDetails($rowData[6]);
//                    $transferAccountsStatementFile->setAccountNumber($rowData[7]);
                    $em->persist($transferAccountsStatementFile);

             // Open file   
                
                    
                }
                $em->flush();
                $em->clear();
                return true;
// TODO loop
    }
    
}
