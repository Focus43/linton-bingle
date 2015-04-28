<style type="text/css">
    #btButton {position:static;z-index:99999;}
    #btButton .select2-container-multi {border:1px solid #ccc;}
    #btButton .select2-container-multi.select2-dropdown-open {border-color:#66afe9;}
</style>

<div id="btButton">
    <h4>Link To</h4>
    <?php echo $pageSelector->selectPage('pageID', $buttonObj->getPageID()); ?>
    <h4>Button Text <small>(Defaults to linked page title if blank)</small></h4>
    <?php echo $form->text('label', $buttonObj->getLabel()); ?>
    <h4>Target <small>(e.g. Open in new window?)</small></h4>
    <?php echo $form->select('target', $controller::$linkTargets, $buttonObj->getTarget()); ?>
    <h4>Style Options</h4>
    <select name="classes[]" class="form-control" multiple="multiple">
        <?php foreach($classOptions AS $stdObj): if(in_array($stdObj->className, $buttonObj->getClasses())): ?>
            <option value="<?php echo $stdObj->className; ?>" selected="selected"><?php echo $stdObj->label; ?></option>
            <?php else: ?>
            <option value="<?php echo $stdObj->className; ?>"><?php echo $stdObj->label; ?></option>
        <?php endif; endforeach; ?>
    </select>
</div>

<script type="text/javascript">
    $(function(){
        $('select[multiple]', '#btButton').select2();
    });
</script>