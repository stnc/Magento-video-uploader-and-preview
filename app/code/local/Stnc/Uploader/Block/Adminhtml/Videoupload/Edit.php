<?php

class Stnc_Uploader_Block_Adminhtml_Videoupload_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'videoupload_id';
        $this->_blockGroup = 'uploader';
        $this->_controller = 'adminhtml_videoupload';
        
        $this->_updateButton('save', 'label', Mage::helper('uploader')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('uploader')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
  

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('videoupload_data') && Mage::registry('videoupload_data')->getId() ) {
            return Mage::helper('uploader')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('videoupload_data')->getTitle()));
        } else {
            return Mage::helper('uploader')->__('Add Item');
        }
    }
}