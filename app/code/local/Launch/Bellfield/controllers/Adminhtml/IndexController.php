<?php
/**
*
*/

class Launch_Bellfield_Adminhtml_IndexController extends Mage_Adminhtml_Controller_action
{
    protected function _init()
    {
        return $this;
    }



    protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('catalog/bellfield')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Bellfield Items Manager'), Mage::helper('adminhtml')->__('Bellfield Items Manager'));

		return $this;
	}

	public function indexAction() {
	
	    $this->_init();
	    $this->_initAction()
	    ->_addContent($this->getLayout()->createBlock('bellfield/adminhtml_front'))
	    ->renderLayout();
	}

	public function importAction() {
	
	    $this->_init();
	    $this->_initAction()
	    ->_addContent($this->getLayout()->createBlock('bellfield/adminhtml_import'))
	    ->renderLayout();
	}
	public function uploadAction()
	{
	    if (isset($_FILES) && isset($_FILES['sourcefile'])) {
	        $path = Mage::getBaseDir() . DS . "datasync/products" . DS;
	
	        $uploader = new Varien_File_Uploader('sourcefile');
	        $uploader->setAllowedExtensions(array(
	                'xls',
	                'xlsx'
	        ));
	
	        $uploader->setAllowRenameFiles(false);
	
	        // setAllowRenameFiles(true) -> move your file in a folder the magento way
	        // setAllowRenameFiles(true) -> move your file directly in the $path folder
	        $uploader->setFilesDispersion(false);
	
	        $uploader->save($path, "products.xlsx");
	    }
	    $this->importAction();
	}
	
	
	
	protected function _redirect($path, $arguments = array())
	{
	    parent::_redirect($path, $arguments);
	}

	public function fillOutAction(){
	    $this->_init();
	    $model  = Mage::getModel('bellfield/bellfield');
	    $storeId = $this->_getStoreId();
	    try {
    	    $model->fillOut($storeId);
    	    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bellfield')->__('Bellfield Items were successfully filled out'));
	    } catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bellfield')->__('There was an error during the process'));
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
    	$this->_redirect('*/*/', array('store' => $storeId));
	}

	public function editAction() {
	    $this->_init();
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('bellfield/front')->load($id);

		if ($delete = $this->getRequest()->getParam('delete')){
		    switch ($delete){
		        case 'small_logo':
		        case 'image':
		            $params = $this->getRequest()->getParams();
		            unset($params['delete']);
		            if ($model->getFeatured() && 'image' == $delete){
		                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bellfield')->__('Image must be uploaded'));
                        Mage::getSingleton('adminhtml/session')->setFormData($model->getData());
                        $this->_redirect('*/*/*/', $params);
                        return;
		            }
		            $filename = $model->getData($delete);
		            $path = Mage::getBaseDir('media') . DS . 'bellfield' . DS . ($delete == 'small_logo'?'logo'.DS:'');
		            if (file_exists($path.$filename)){
		                unlink($path.$filename);
		            }
		            $model->setData($delete, '');
		            $model->save();

		            $this->_redirect('*/*/*/', $params);
		            return;
		    }
		}

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('bellfield_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('catalog/bellfield');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Bellfield Items Manager'), Mage::helper('adminhtml')->__('Bellfield Items Manager'));
			//$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bellfield/adminhtml_front_edit'))
				->_addLeft($this->getLayout()->createBlock('bellfield/adminhtml_front_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bellfield')->__('Bellfield Items does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->editAction();
	}

	public function saveAction() {
	    $this->_init();
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('bellfield/front');

			if (!file_exists(Mage::getBaseDir('media') . DS . 'front')) {
			    mkdir (Mage::getBaseDir('media') . DS . 'front');

			}

			if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				try {
					/* Starting upload */
					$uploader = new Varien_File_Uploader('image');
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$path = Mage::getBaseDir('media') . DS . 'front' .  DS;
					//$uploader->save($path, $_FILES['image']['name'] );
					$targetname = $this->sanitize($_FILES['image']['name']);

					if (file_exists($path . $targetname)) {
					   $imagename = md5($targetname.time()) . '.' . substr(strrchr($targetname, '.'), 1);
					} else {
					    $imagename = $targetname;
					}

					$uploader->save($path, $imagename);
					$image = new Varien_Image($path . $imagename);
					$image->backgroundColor(array(255,255,255));
					$image->resize(150);
					$image->keepFrame(true);
					$image->save($path, "small_".$imagename);

					/*$processor = new Varien_Image($path.$newimage);
                    $processor->keepAspectRatio(true);
                    $processor->resize(200);
                    $processor->save();exit;*/

				} catch (Exception $e) {
				    print_r($e);
		        }

		        if (isset($imagename)){
    		        //this way the name is saved in DB
    	  			$data['image'] = $imagename;
		        }
			}


			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			try {
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bellfield')->__('Kitchens Page was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bellfield')->__('Unable to find Bellfield Items to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
	    $this->_init();
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bellfield/front');

				$model->setId($this->getRequest()->getParam('id'))
					->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Bellfield Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $this->_init();
        $bellfieldIds = $this->getRequest()->getParam('bellfield');
        if(!is_array($bellfieldIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Bellfield Item(s)'));
        } else {
            try {
                foreach ($bellfieldIds as $bellfieldId) {
                    $bellfield = Mage::getModel('bellfield/front')->load($bellfieldId);
                    $bellfield->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($bellfieldIds)
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
        $this->_init();
        $bellfieldIds = $this->getRequest()->getParam('bellfield');
        if(!is_array($bellfieldIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Bellfield Item(s)'));
        } else {
            try {
                foreach ($bellfieldIds as $bellfieldId) {
                    $bellfield = Mage::getSingleton('bellfield/front')
                        ->load($bellfieldId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bellfieldIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
    }
}