<!DOCTYPE HTML>
<html ng-app="sequence" ng-controller="CtrlRoot" ng-class="rootClasses" lang="<?php echo LANGUAGE; ?>" class="<?php echo $isEditMode ? 'cms-edit-mode' : ''; ?>">
<?php $this->inc('elements/head.php'); ?>

<body<?php if($pagePermissionObj->canWrite()){ echo ' can-admin'; } ?>>

<?php if( ! $pagePermissionObj->canWrite() ): ?>
    <script type="text/ng-template" id="<?php echo URL::route(array('disclaimer', 'sequence')); ?>">
    <?php Loader::packageElement('partials/disclaimer', 'sequence'); ?>
</script>
<?php endif; ?>

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/header.php'); ?>

    <main slideable>
        <section id="section-0">
            <div masthead data-transition-speed="0.5"<?php if(!$isEditMode && (count($mastheadImages) > 1)){echo ' data-loop-timing="12"';} ?>>
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
                    <a class="arrows icn-angle-left"></a>
                    <a class="arrows icn-angle-right"></a>
                    <div class="markers">
                        <?php for($i = 0; $i < count($mastheadImages); $i++): ?>
                            <a class="<?php echo $i === 0 ? 'active' : ''; ?>"><i class="icn-circle"></i></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php $i = 1; while($i <= (int)$areaCount): ?>
            <section id="<?php echo "section-{$i}"; ?>">
                <?php
                $a = new Area("Main {$i}"); /** @var $a \Concrete\Core\Area\Area */
                $a->enableGridContainer();
                $a->display($c);
                ?>
                <div class="section-footer"><?php $a = new Area("Sub {$i}"); $a->display($c); ?></div>
            </section>
            <?php $i++; endwhile; ?>

        <section id="<?php echo "section-{$i}"; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $a = new Area('Contact Top'); $a->display($c); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-md-offset-1">
                        <?php $a = new Area('Contact Left'); $a->display($c); ?>
                    </div>
                    <div class="col-sm-9 col-md-7">
                        <form name="contactForm" ng-controller="CtrlContactForm" ng-submit="submitHandler($event)" role="form" action="<?php echo URL::route(array('contact_form', 'sequence')); ?>">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label class="sr-only">Name</label>
                                    <input required ng-model="form_data.name" type="text" class="form-control" placeholder="Name" />
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="sr-only">Email</label>
                                    <input required ng-model="form_data.email" type="email" class="form-control" placeholder="Email" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <textarea ng-model="form_data.message" class="form-control" placeholder="Message" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <button ng-disabled="isDisabled()" type="submit" class="btn btn-default">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php $a = new Area('Contact Bottom'); $a->enableGridContainer(); $a->display($c); ?>
                    </div>
                </div>
            </div>
        </section>

        <footer>TitleCard Capital&trade;. Copyright &copy; <?php echo date('Y'); ?> | <a modalize="<?php echo URL::route(array('/terms_of_use', 'sequence')); ?>">Terms Of Use</a></footer>
    </main>
    <aside scroll-top class="icn-angle-up"></aside>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>