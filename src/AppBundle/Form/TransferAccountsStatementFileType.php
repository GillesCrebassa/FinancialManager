<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType ;


class TransferAccountsStatementFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accountsStatementFileId', TextType::class)
            ->add('sequenceNumber', TextType::class)
            ->add('executionDate', TextType::class)
            ->add('valueDate', TextType::class)
            ->add('amount', TextType::class)
            ->add('currency', TextType::class)
            ->add('counterpartment', TextType::class)
            ->add('details', TextType::class)
        ;
    }
    
    public function getName()
    {
        return 'accountsStatementFile';
    }    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AccountsStatementFile',
        ));
    }    
}

?>
