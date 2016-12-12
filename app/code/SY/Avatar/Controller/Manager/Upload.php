<?php
/**
 * Profile Avatar
 * 
 * @author Slava Yurthev
 */
namespace SY\Avatar\Controller\Manager;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \SY\Avatar\Block\Customer\Account\Avatar;
class Upload extends \Magento\Framework\App\Action\Action {
	protected $_resultPageFactory;
	public function __construct(Context $context, PageFactory $resultPageFactory){
		$this->_resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}
	public function execute(){
		$resultPage = $this->_resultPageFactory->create();
		$object_manager = $this->_objectManager;
		$block = $resultPage->getLayout()->createBlock('SY\Avatar\Block\Customer\Account\Avatar');
		$customer = $block->getCustomer();
		if($customerId = $customer->getId()){
			// realy don't know how ;)
			$base_dir = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
			if($customer->getData('avatar')){
				@unlink($base_dir.'/'.$block->getAvatar());
			}
			// Because ORM must be re-indexed
			$resource = $object_manager->create('Magento\Framework\App\ResourceConnection');
			$table = $resource->getTableName('customer_entity');
			$write = $resource->getConnection($resource::DEFAULT_CONNECTION);
			$file_name = $customerId.'_'.basename($_FILES['avatar']['name']);
			if (move_uploaded_file($_FILES['avatar']['tmp_name'], $base_dir.'/'.$block::IMG_DIR.$file_name)) {
				$write->query("UPDATE `{$table}` SET `avatar`='{$file_name}' WHERE `entity_id`='{$customerId}'");
			}
		}
		$this->_redirect('customer/account');
	}
}