//app/design/frontend/<YOUR TEMPLATE>/default/template/catalog/product/view.phtml 

after to <?php echo $this->getChildHtml('media') ?> 
add 
<?php
echo $this->getLayout()
    ->createBlock('core/template')
    ->setTemplate('stnc/videouploader.phtml')
    ->setData('sku', $_product->getSku())
    ->toHtml();
 ?>
 