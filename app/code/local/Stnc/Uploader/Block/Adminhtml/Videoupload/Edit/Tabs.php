<?php

class Stnc_Uploader_Block_Adminhtml_Videoupload_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('uploader_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('uploader')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('uploader')->__('Item Information'),
          'title'     => Mage::helper('uploader')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('uploader/adminhtml_videoupload_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}