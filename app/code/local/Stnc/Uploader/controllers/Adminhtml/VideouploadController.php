<?php
/**
* MNM video upload 
*
* @version 8.0
* @author SeLman TunÇ <selmantunc@gmail.com>
* @license MNM :) 
* @copyright MNM
* @package uploader
* @subpackage external
*/

class Stnc_Uploader_Adminhtml_VideouploadController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
	
		$this->loadLayout()
			->_setActiveMenu('uploader/videoupload')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Video Manager'), Mage::helper('adminhtml')->__('Video Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('uploader/videoupload')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('videoupload_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('uploader/videoupload');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Video Manager'), Mage::helper('adminhtml')->__('Video Manager'));
 

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('uploader/adminhtml_videoupload_edit'))
				->_addLeft($this->getLayout()->createBlock('uploader/adminhtml_videoupload_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uploader')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
			
					
					// Any extention would work
	           		//$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowedExtensions(array('mp4','flv','avi'));
					$uploader->setAllowRenameFiles(false);
					

					$uploader->setFilesDispersion(false);
						
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'stnc'.DS.'uploader'.DS ;
					
				    $newName =   Mage::helper('uploader')->new_file_name($path.$_FILES['filename']['name']);
					
					$uploader->save($path, $newName );
					
	
				} catch (Exception $e) {
		         echo $e->getMessage();
		        }
	        
		        //this way the name is saved in DB
	  			//$data['filename'] = $_FILES['filename']['name'];
				 			$data['filename'] =  $newName;
				  
			}
	  			
	  			
			$model = Mage::getModel('uploader/videoupload ');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('uploader')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uploader')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		/*
	video file delete ?
	*/
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('uploader/videoupload');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
	/*
	video file delete ?
	*/
        $uploaderIds = $this->getRequest()->getParam('uploader');
        if(!is_array($uploaderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($uploaderIds as $uploaderId) {
                    $uploader = Mage::getModel('uploader/videoupload')->load($uploaderId);
                    $uploader->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($uploaderIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $uploaderIds = $this->getRequest()->getParam('uploader');
        if(!is_array($uploaderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($uploaderIds as $uploaderId) {
                    $uploader = Mage::getSingleton('uploader/videoupload')
                        ->load($uploaderId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($uploaderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	
	    /**
     * export grid item to CSV type
     */
    public function exportCsvAction() {
        $fileName = 'videoupload.csv';
        $content = $this->getLayout()->createBlock('uploader/adminhtml_videoupload_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction() {
        $fileName = 'videoupload.xml';
        $content = $this->getLayout()->createBlock('uploader/adminhtml_videoupload_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
	
	
}