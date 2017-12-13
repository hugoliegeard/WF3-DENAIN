<?php
    $params = $this->getViewparams( );
    #$this->debug($params->articles);
?>

<div class="row">
    <!--colleft-->
    <div class="col-md-8 col-sm-12">
        <div class="box-caption">
            <span>spotlight</span>
        </div>
        <!--spotlight-->
        <section class="owl-carousel owl-spotlight">
                <?php foreach($params->spotlight as $article) : ?>
                <div>
                    <article class="spotlight-item">
                        <div class="spotlight-img">
                            <img alt="<?= $article->getTITREARTICLE() ?>"
                                 src="<?= $article->getFULLIMAGEARTICLE(); ?>"
                                 class="img-responsive" />
                            <a href="<?= $this->generateUrl('news', strtolower($article->getCATEGORIEOBJ()->getLIBELLECATEGORIE())); ?>" class="cate-tag">
                                <?= $article->getCATEGORIEOBJ()->getLIBELLECATEGORIE() ?>
                            </a>
                        </div>
                        <div class="spotlight-item-caption">
                            <h2 class="font-heading">
                                <a href="<?= $this->generateUfm('article/$1-$2.html',
                                    [ $article->getIDARTICLE(),
                                        $this->slugify($article->getTITREARTICLE()) ]) ?>">
                                    <?= $article->getTITREARTICLE() ?>
                                </a>
                            </h2>
                            <div class="meta-post">
                                <a href="#">
                                    <?= $article->getAUTEUROBJ()->getNOMCOMPLETAUTEUR() ?>
                                </a>
                                <em></em>
                                <span>
                                <time datetime="<?= $article->getDATECREATIONARTICLE() ?>"></time>
                            </span>
                            </div>
                            <?= $article->getACCROCHEARTICLE() ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </section>

        <!--spotlight-thumbs-->
        <section class="spotlight-thumbs">
            <div class="row">
                <?php foreach($params->articles as $article) : ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="spotlight-item-thumb">
                            <div class="spotlight-item-thumb-img">
                                <a href="<?= $this->generateUfm('article/$1-$2.html',
                                    [ $article->getIDARTICLE(),
                                        $this->slugify($article->getTITREARTICLE()) ]) ?>">
                                    <img alt="<?= $article->getTITREARTICLE() ?>"
                                         src="<?= $article->getFULLIMAGEARTICLE(); ?>" />
                                </a>
                                <a href="<?= $this->generateUrl('news', strtolower($article->getCATEGORIEOBJ()->getLIBELLECATEGORIE())); ?>" class="cate-tag">
                                    <?= $article->getCATEGORIEOBJ()->getLIBELLECATEGORIE() ?>
                                </a>
                            </div>
                            <h3>
                                <a href="<?= $this->generateUfm('article/$1-$2.html',
                                    [ $article->getIDARTICLE(),
                                        $this->slugify($article->getTITREARTICLE()) ]) ?>">
                                    <?= $article->getTITREARTICLE() ?>
                                </a>
                            </h3>
                            <div class="meta-post">
                                <a href="#">
                                    <?= $article->getAUTEUROBJ()->getNOMCOMPLETAUTEUR() ?>
                                </a>
                                <em></em>
                                <span>
                                <time datetime="<?= $article->getDATECREATIONARTICLE() ?>"></time>
                            </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <?php include PATH_SIDEBAR; ?>
