<?php

class Stnc_Uploader_Block_Adminhtml_Videoupload_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('uploader_form', array('legend'=>Mage::helper('uploader')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('uploader')->__('Title'),
       
          'required'  => false,
          'name'      => 'title',
      ));

	  
	     $fieldset->addField('sku', 'text', array(
          'label'     => Mage::helper('uploader')->__('Sku'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'sku',
      ));
	  
      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('uploader')->__('File'),
		
          'required'  => false,
          'name'      => 'filename',
		   'note' => 'mp4,flv,avi uzantılı video yükleyiniz , diğerleri yüklenmeyecekdir',

		/* for video previev 
		     'onchange'	=> 'onchangeposition()',
            'note' => '<a href="javasrcipt:void(0)" id="position-tip-1" style="display: none">Preview </a>
                        <a href="javasrcipt:void(0)" id="position-tip-2" style="display: none">Preview </a>
                        <a href="javasrcipt:void(0)" id="position-tip-3" style="display: block">Preview </a>',
		*/		 
				 
				 
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('uploader')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('uploader')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('uploader')->__('Disabled'),
              ),
          ),
      ));
     
    
     
      if ( Mage::getSingleton('adminhtml/session')->getUploaderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getUploaderData());
          Mage::getSingleton('adminhtml/session')->setUploaderData(null);
      } elseif ( Mage::registry('videoupload_data') ) {
          $form->setValues(Mage::registry('videoupload_data')->getData());
      }
      return parent::_prepareForm();
  }
}