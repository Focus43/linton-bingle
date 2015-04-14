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
                                <div class="hidden-xs" data-viz-d>
                                    <?php $index++; $a = new Area("Masthead {$index}"); $a->display($c); ?>
                                </div>
                                <div class="visible-xs" data-viz-m>
                                    <?php $a = new Area("Masthead Mobile {$index}"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

                <?php if(count($mastheadImages) > 1): ?>
                    <?php if ( $isEditMode ) { ?>
                    <a class="arrows icon-arrow-left"></a>
                    <a class="arrows icon-arrow-right"></a>
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
                <div class="about col-xs-12 col-sm-4">
                    <a class="shade">
                        <h3>ABOUT</h3>
                        <div class="extra">
                            <?php $a = new Area("About Short"); $a->display($c); ?>
                            Together, Betsy and Carol are a real estate team unlike any other in the Valley.  Their professional marketing style and customer service to their clients is unrivaled and for those qualities they earned the 2013 Award for Professional Excellence.
                        </div>
                        <div class="more">READ MORE</div>
                    </a>
                </div>
                <div class="resources col-xs-12 col-sm-4">
                    <a class="shade">
                        <h3>RESOURCES</h3>
                        <div class="extra"><?php $a = new Area("Resources Short"); $a->display($c); ?>A trusted team with a wealth of information fo Buyers and Sellers</div>
                        <div class="more">LEARN MORE</div>
                    </a>
                </div>
                <div class="blog col-xs-12 col-sm-4">
                    <a class="shade">
                        <h3>BLOG / MEDIA</h3>
                        <div class="extra"><?php $a = new Area("Blog Short"); $a->display($c); ?>Stay up to date with our latest posts,  property brochures and videos.</div>
                        <div class="more">READ MORE</div>
                    </a>
                </div>
            </div>
        </section>


        <section class="featured">
            <div id="featuredCarousel">Loading...</div>

            <script id="featuredInitial" type="x-tmpl-mustache">
                <div class="property first">
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
                                    {{#photos1}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos1}}
                                </div>
                                <div class="right">
                                    {{#photos2}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos2}}
                                </div>
                            </div>
                            <div class="description">
                                <h4>{{name}}</h4>
                                <p>{{shortDescription}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="completeList" class="clearfix"></div>
                <div class="bottom">
                    <div class="indicators"></div>
                </div>
                <div class="featured-round">FEATURED PROPERTY</div>
            </script>

            <script id="featuredList" type="x-tmpl-mustache">
                {{#properties}}
                <div class="property clearfix">
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
                                    {{#photos1}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos1}}
                                </div>
                                <div class="right">
                                    {{#photos2}}
                                        <div class="sub-image" style="background-image:url('{{.}}')"></div>
                                    {{/photos2}}
                                </div>
                            </div>
                            <div class="description">
                                <h4>{{name}}</h4>
                                <p>{{shortDescription}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{/properties}}
            </script>


        </section>

        <?php $this->inc('elements/search_form.php'); ?>

        <?php $this->inc('elements/footer.php'); ?>
        <?php $this->inc('elements/header.php'); ?>
    </main>

</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>