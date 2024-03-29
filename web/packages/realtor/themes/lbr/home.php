<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-home">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
            <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="6"';} ?>>
                <?php if(!empty($mastheadImages)): foreach($mastheadImages AS $index => $fileObj): ?>
                    <div class="node" style="background-image:url('<?php echo $fileObj->getRelativePath(); ?>');">
                        <div class="inner">
                            <div class="node-content">
                                <div>
                                    <h1 class="homepageTitle"><?php $index++; $a = new Area("Masthead Header {$index}"); $a->display($c); ?></h1>
                                    <?php $a = new Area("Masthead {$index}"); $a->display($c); ?>
                                </div>
<!--                                <div class="visible-xs" data-viz-m>-->
<!--                                    --><?php //$a = new Area("Masthead Mobile {$index}"); $a->display($c); ?>
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
                <?php if ( !$isEditMode ) { ?> <div class="look-down"><i class="icon-expand-more"></i></div> <?php } ?>
                <?php if(count($mastheadImages) > 1): ?>
                    <?php if ( $isEditMode ) { ?>
                    <a class="edit-arrows arrows icon-keyboard-arrow-left"></a>
                    <a class="edit-arrows arrows icon-keyboard-arrow-right"></a>
                    <?php } ?>
                <?php endif; ?>
            </div>
        </section>
        <section class="nav-blocks">
            <div class="row">
                <div class="about col-xs-12 col-sm-4" data-url="/about/about-lintonbingle">
                    <div class="shade">
                        <h3>ABOUT</h3>
                        <div class="extra">
                            <div><?php $a = new Area("About Short"); $a->display($c); ?></div>
                        </div>
                        <div class="more">READ MORE</div>
                    </div>
                </div>
                <div class="resources col-xs-12 col-sm-4" data-url="/resources/wyoming-tax-benefits">
                    <div class="shade">
                        <h3>RESOURCES</h3>
                        <div class="extra">
                            <div><?php $a = new Area("Resources Short"); $a->display($c); ?></div>
                        </div>
                        <div class="more">LEARN MORE</div>
                    </div>
                </div>
                <div class="blog col-xs-12 col-sm-4" data-url="/blog">
                    <div class="shade">
                        <h3>BLOG / MEDIA</h3>
                        <div class="extra">
                            <?php $a = new Area("Blog Short"); $a->display($c); ?>
                        </div>
                        <div class="more">READ MORE</div>
                    </div>
                </div>
            </div>
            <div class="featured-round" style="display: none;">FEATURED PROPERTY</div>
        </section>

        <section class="featured">
            <div id="featuredCarousel">
                <div style="text-align: center;padding: 20px;"><span class="icon-spinner spinner spinner--steps"></span></div>
            </div>

            <script id="featuredInitial" type="x-tmpl-mustache">
                <div class="property {{id}} first">
                    <div class="top clearfix">
                        <div class="left">
                            <div id="carouselLeft">
                                <div>
                                    <div class="main-image" style="background-image:url('{{mainImage}}')"></div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="carouselRight" class='clearfix'>
                                <div class="left">
                                    <div class="overflow-container">
                                    {{#photos1}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos1}}
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="overflow-container">
                                    {{#photos2}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos2}}
                                    </div>
                                </div>
                            </div>
                            <div class="description">
                                <a href="/properties/id/{{id}}"><h4>{{name}}</h4></a>
                                <p>{{shortDescription}}</p>
                            </div>
                            <div class="link">
                                <a class="btn btn-red" href="/properties/id/{{id}}">VIEW DETAILS</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="indicators">
                        <div class="go-back"><i class="icon-keyboard-arrow-left"></i></div>
                        <div class="go-forward"><i class="icon-keyboard-arrow-right"></i></div>
                    </div>
                </div>
                <div id="completeList" class="clearfix"></div>
            </script>

            <script id="featuredList" type="x-tmpl-mustache">
                {{#properties}}
                <div class="property {{id}} clearfix">
                    <div class="top clearfix">
                        <div class="left">
                            <div id="carouselLeft">
                                <div>
                                    <div class="main-image" style="background-image:url('{{mainImage}}')"></div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="carouselRight" class='clearfix'>
                                <div class="left">
                                    <div class="overflow-container">
                                    {{#photos1}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos1}}
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="overflow-container">
                                    {{#photos2}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos2}}
                                    </div>
                                </div>
                            </div>
                            <div class="description">
                                <a href="/properties/id/{{id}}"><h4>{{name}}</h4></a>
                                <p>{{shortDescription}}</p>
                            </div>
                            <div class="link">
                                <a class="btn btn-red" href="/properties/id/{{id}}">VIEW DETAILS</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{/properties}}

            </script>
            <div class="featured-round">FEATURED PROPERTY</div>

        </section>

        <?php $this->inc('elements/search_form.php'); ?>

        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
<?php $this->inc('elements/googleanalytics.php'); ?>
</body>
</html>
