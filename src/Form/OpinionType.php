<?php
/**
 * Created by PhpStorm.
 * User: marj5
 * Date: 16/02/2019
 * Time: 09:33
 */

namespace App\Form;

use App\Entity\Opinion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OpinionType extends AbstractController
{
        /*$builder
        ->add('pseudo', TextType::class, [
        'label' => 'Pseudo'
        ])
        ->add('message', TextType::class, [
        'label' => 'Message'
        ])

        ;*/
}