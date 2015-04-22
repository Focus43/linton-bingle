<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="pg-home">
<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <main slideable>
        <section class="hero">
            <div class="masthead" data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="12"';} ?>>
                <?php if(!empty($mastheadImages)): foreach($mastheadImages AS $index => $fileObj): ?>
                    <div class="node" style="background-image:url('<?php echo $fileObj->getRelativePath(); ?>');">
                        <div class="inner">
                            <div class="node-content">
                                <div>
                                    <h2><?php $index++; $a = new Area("Masthead Header {$index}"); $a->display($c); ?></h2>
                                    <?php $a = new Area("Masthead {$index}"); $a->display($c); ?>
                                </div>
<!--                                <div class="visible-xs" data-viz-m>-->
<!--                                    --><?php //$a = new Area("Masthead Mobile {$index}"); $a->display($c); ?>
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

                <?php if(count($mastheadImages) > 1): ?>
                    <?php if ( $isEditMode ) { ?>
                    <a class="edit-arrows arrows icon-keyboard-arrow-left"></a>
                    <a class="edit-arrows arrows icon-keyboard-arrow-right"></a>
                    <?php } ?>
                    <div class="markers">
                        <?php for($i = 0; $i < count($mastheadImages); $i++): ?>
                            <a class="<?php echo $i === 0 ? 'active' : ''; ?>"><i class="icn-circle"></i></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="nav-blocks">
            <div class="row">
                <div class="about col-xs-12 col-sm-4" data-url="/about/about-linton-bingle">
                    <div class="shade">
                        <h3>ABOUT</h3>
                        <div class="extra">
                            <div><?php $a = new Area("About Short"); $a->display($c); ?></div>
<!--                            <p>Together, Betsy and Carol are a real estate team unlike any other in the Valley.  Their professional marketing style and customer service to their clients is unrivaled and for those qualities they earned the 2013 Award for Professional Excellence.</p>-->
                        </div>
                        <div class="more">READ MORE</div>
                    </div>
                </div>
                <div class="resources col-xs-12 col-sm-4" data-url="/resources">
                    <div class="shade">
                        <h3>RESOURCES</h3>
                        <div class="extra">
                            <div><?php $a = new Area("Resources Short"); $a->display($c); ?></div>
<!--                            <p>A trusted team with a wealth of information fo Buyers and Sellers</p>-->
                        </div>
                        <div class="more">LEARN MORE</div>
                    </div>
                </div>
                <div class="blog col-xs-12 col-sm-4" data-url="/blog">
                    <div class="shade">
                        <h3>BLOG / MEDIA</h3>
                        <div class="extra">
                            <?php $a = new Area("Blog Short"); $a->display($c); ?>
<!--                            <p>Stay up to date with our latest posts,  property brochures and videos.</p>-->
                        </div>
                        <div class="more">READ MORE</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured">
            <div id="featuredCarousel">
                <div style="text-align: center;padding: 20px;"><span class="icon-spinner spinner"></span></div>
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
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="indicators">
                        <div class="go-back"><i class="icon-arrow-left"></i></div>
                        <div class="go-forward"><i class="icon-arrow-right"></i></div>
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
</body>
</html>