<?php

namespace TechNews\Controller;

use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminController
{
    /**
     * Affichage de la Page Connexion
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addarticleAction(Application $app) {

        # Récupérer la liste des catégories
        $categories = function() use($app) {

            # Récupération des Catégories dans la BDD
            $categories = $app['idiorm.db']->for_table('categorie')
                                           ->find_result_set();

            # On formate l'affichage pour le champ select (ChoiceType)
            $array = [];
            foreach ($categories as $categorie):
                $array[$categorie->LIBELLECATEGORIE] = $categorie->IDCATEGORIE;
            endforeach;

            # On retourne le tableau formaté.
            return $array;

        };

        # Créer un Formulaire permettant l'ajout d'un Article
        $form = $app['form.factory']->createBuilder(FormType::class)

            # Champ TITREARTICLE
            ->add('TITREARTICLE', TextType::class, [
                'required'      => true,
                'label'         => false,
                'constraints'   => array(new NotBlank()),
                'attr'          => [
                    'class'         =>  'form-control',
                    'placeholder'   =>  'Titre de l\'Article...'
                ]
            ])

            # Champ IDCATEGORIE
            ->add('IDCATEGORIE', ChoiceType::class, [
                'choices'   => $categories(),
                'expanded'  => false,
                'multiple'  => false,
                'label'     => false,
                'attr'          => [
                    'class'         =>  'form-control'
                ]
            ])

            # Champ CONTENUARTICLE
            ->add('CONTENUARTICLE', TextareaType::class, [
                'required'      => true,
                'label'         => false,
                'constraints'   => array(new NotBlank()),
                'attr'          => [
                    'class'         =>  'form-control'
                ]
            ])

            # FEATUREDIMAGEARTICLE
            ->add('FEATUREDIMAGEARTICLE', FileType::class, [
                'required'  => false,
                'label'     => false,
                'attr'      => [
                    'class' => 'dropify'
                ]
            ])

            # SPECIALARTICLE & SPOTLIGHTARTICLE
            ->add('SPECIALARTICLE', CheckboxType::class, [
                'required'  => false,
                'label'     => false,
            ])
            ->add('SPOTLIGHTARTICLE', CheckboxType::class, [
                'required'  => false,
                'label'     => false,
            ])

            ->add('submit', SubmitType::class, ['label' => 'Publier'])

            /**
             * Maintenant que tous les champs ont été créés, nous allons
             * pouvoir récupérer le formulaire
             */

            ->getForm();

        # Affichage du Formulaire dans la Vue
        return $app['twig']->render('admin/ajouterarticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}