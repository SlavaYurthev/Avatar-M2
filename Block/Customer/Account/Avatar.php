<?php
/**
 * Profile Avatar
 * 
 * @author Slava Yurthev
 */
namespace SY\Avatar\Block\Customer\Account;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session;
use \Magento\Customer\Model\Customer;
class Avatar extends Template {
	protected $session;
	public function __construct(
			Context $context,
			Session $session,
			Customer $customer,
			array $data = []
		){
		$this->session = $session;
		$this->customer = $customer;
		parent::__construct($context, $data);
	}
	public function getCustomer($id = false){
		if($id){
			$this->customer->load($id);
		}
		elseif($this->session && $this->session->getData('customer_id')){
			$this->customer->load($this->session->getData('customer_id'));
		}
		return $this->customer;
	}
	public function getSession(){
		var_dump(dirname(dirname(dirname(__DIR__))));
		return $this->session;
	}
	public function getAvatar(){
		$img = 'default.jpg';
		if($this->getCustomer()->getData('avatar')){
			$module_dir = dirname(dirname(dirname(__DIR__)));
			$avatars_dir = '/view/frontend/web/media/';
			if(file_exists($module_dir.$avatars_dir.$this->getCustomer()->getData('avatar'))){
				$img = $this->getCustomer()->getData('avatar');
			}
		}
		return $this->getViewFileUrl('SY_Avatar/media/'.$img);
	}
}