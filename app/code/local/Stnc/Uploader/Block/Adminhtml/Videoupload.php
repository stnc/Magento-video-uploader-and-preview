<?php
class Stnc_Uploader_Block_Adminhtml_Videoupload extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_videoupload';
    $this->_blockGroup = 'uploader';
    $this->_headerText = Mage::helper('uploader')->__('Video Manager');
    $this->_addButtonLabel = Mage::helper('uploader')->__('Add Item');
    parent::__construct();
  }
}