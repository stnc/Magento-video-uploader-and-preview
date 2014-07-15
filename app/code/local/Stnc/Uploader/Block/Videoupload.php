<?php
class Stnc_Uploader_Block_Videoupload extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getUploader()     
     { 
        if (!$this->hasData('uploader')) {
            $this->setData('uploader', Mage::registry('uploader'));
        }
        return $this->getData('uploader');
        
    }
}