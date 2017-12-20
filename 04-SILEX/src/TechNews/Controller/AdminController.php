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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use TechNews\Helper;

class AdminController
{

    use Helper;

    /**
     * Affichage de la Page Connexion
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addarticleAction(Application $app, Request $request) {

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

        # Traitement des données POST
        $form->handleRequest($request);

        # Vérification des données du Formulaire
        if($form->isValid()) :

            # Récupération des données
            $article = $form->getData();

            # Récupération de l'image
            $image  = $article['FEATUREDIMAGEARTICLE'];
            $chemin = PATH_PUBLIC . '/images/product/';
            $image->move($chemin, $this->slugify($article['TITREARTICLE']).'.jpg');

            # Récupération de l'Auteur
            $token = $app['security.token_storage']->getToken();
            if (null !== $token) {
                $auteur = $token->getUser();
            } else {
                return $app->redirect('deconnexion.html');
            }

            # Insertion en BDD
            $articleDb = $app['idiorm.db']->for_table('article')->create();
            $categorie = $app['idiorm.db']->for_table('categorie')
                ->find_one($article['IDCATEGORIE']);

            # On associe les colonnes de notre BDD avec les valeurs du formulaire.
            # Colonne mySQL                     # Valeurs du Formulaires
            $articleDb->IDAUTEUR                =   $auteur->getIDAUTEUR();
            $articleDb->IDCATEGORIE             =   $article['IDCATEGORIE'];
            $articleDb->TITREARTICLE            =   $article['TITREARTICLE'];
            $articleDb->CONTENUARTICLE          =   $article['CONTENUARTICLE'];
            $articleDb->SPECIALARTICLE          =   $article['SPECIALARTICLE'];
            $articleDb->SPOTLIGHTARTICLE        =   $article['SPOTLIGHTARTICLE'];
            $articleDb->FEATUREDIMAGEARTICLE    =   $this->slugify($article['TITREARTICLE']).'.jpg';

            # Insertion en BDD
            $articleDb->save();

            # Redirection sur l'Article qui vient d'être créé.
            return $app->redirect( $app['url_generator']->generate(
                'news_article', [
                    'libellecategorie' => strtolower($categorie->LIBELLECATEGORIE),
                    'slugarticle'      => $this->slugify($article['TITREARTICLE']),
                    'idarticle'        => $articleDb->id()
                ]
            ) );

        endif;

        # Affichage du Formulaire dans la Vue
        return $app['twig']->render('admin/ajouterarticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}