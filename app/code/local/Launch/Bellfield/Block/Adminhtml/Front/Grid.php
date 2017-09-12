<?php

class Launch_Bellfield_Block_Adminhtml_Front_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('frontGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bellfield/front')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bellfield')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('bellfield')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('section', array(
          'header'    => Mage::helper('bellfield')->__('Section'),
          'align'     =>'left',
          'index'     => 'section',
      ));

      $this->addColumn('image', array(
          'header'    => Mage::helper('bellfield')->__('Image'),
          'align'     =>'left',
          'index'     => 'image',
      ));
      
      $this->addColumn('order', array(
          'header'    => Mage::helper('bellfield')->__('Order'),
           'width'     => '30px',
         'align'     =>'left',
          'index'     => 'order',
      ));

      $this->addColumn('active', array(
          'header'    => Mage::helper('bellfield')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'active',
          'type'      => 'options',
          'options'   => array(
              1 => 'Active',
              0 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bellfield')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bellfield')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        echo '<script type="text/javascript">$jq(document).ready(function(){ $jq("td.a-left").each(function(){var f1 = $jq(this);var t2=f1.html();t2=t2.replace(/&lt;img/g, "<img");t2=t2.replace(/&gt;/g, ">");f1.html(t2);})});</script>';
        
		$this->addExportType('*/*/exportCsv', Mage::helper('launch')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('launch')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('front');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bellfield')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bellfield')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('launch/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('bellfield')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('bellfield')->__('Status'),
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