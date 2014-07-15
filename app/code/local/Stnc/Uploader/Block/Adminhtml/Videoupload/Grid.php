<?php

class Stnc_Uploader_Block_Adminhtml_Videoupload_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('videouploadGrid');
      $this->setDefaultSort('videoupload_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
	  
	  
	  
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('uploader/videoupload')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('videoupload_id', array(
          'header'    => Mage::helper('uploader')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'videoupload_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('uploader')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	        $this->addColumn('sku', array(
          'header'    => Mage::helper('uploader')->__('Sku'),
          'align'     =>'left',
          'index'     => 'sku',
      ));

	  


      $this->addColumn('status', array(
          'header'    => Mage::helper('uploader')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('uploader')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('uploader')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('uploader')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('uploader')->__('XML'));
	 
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('videoupload_id');
        $this->getMassactionBlock()->setFormFieldName('uploader');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('uploader')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('uploader')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('uploader/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('uploader')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('uploader')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}