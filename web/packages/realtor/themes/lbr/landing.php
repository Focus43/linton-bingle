<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-landing">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
            <div class="masthead">
                    <div class="node" >
                        <div class="inner clearfix">
                            <div class="node-image"><?php $a = new Area("Choose Background Image"); $a->display($c); ?></div>
                            <div class="node-content">
                                <div>
                                    <h3><?php $a = new Area("Header"); $a->display($c); ?></h3>
<!--                                    <div class="hidden-xs">--><?php //$a = new Area("Copy"); $a->display($c); ?><!--</div>-->
                                    <div><?php $a = new Area("Copy"); $a->display($c); ?></div>
                                    <?php $a = new Area("Button"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
        <section class="current-level-nav skinny-wrap">
            <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_desc';
            $blockTypeNav->controller->displayPages             = 'second_level';
            $blockTypeNav->controller->displaySubPages          = 'enough';
            $blockTypeNav->controller->displaySubPageLevels     = 'enough';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->render('templates/landing_page_main_nav');
            ?>
        </section>
        <section class="subnav wide-wrap">
<!--            <h3>--><?php //echo $c->getCollectionName(); ?><!--</h3>-->
            <div class="pagination clearfix"></div>
            <div class="pagelist"><span class="icon-spinner spinner spinner--steps"></span></div>
            <div class="pagination clearfix"></div>
        </section>
        <script id="pagination" type="x-tmpl-mustache">
            <ul {{^increments}}class="hidden"{{/increments}}>
                <li>PAGES</li>
            {{#increments}}
                <li class="pagenum" data-next-page="{{.}}">{{.}}</li>
            {{/increments}}
            {{^increments}}{{/increments}}
            </ul>
        </script>
        <script id="pageList" type="x-tmpl-mustache">
            <ul>
            {{#pages}}
                <li>
                    <a href="{{path}}">
                        <div class="pg-icon" style="background-image: url({{iconPath}})"></div>
                        <h4>{{name}}</h4>
                        <p>{{description}}</p>
                    </a>
                </li>
            {{/pages}}
            {{^pages}}
                <div>Sorry, we're still working on this part. Come back soon!</div>
            {{/pages}}
            </ul>
        </script>

        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
<?php $this->inc('elements/googleanalytics.php'); ?>
</body>
</html>