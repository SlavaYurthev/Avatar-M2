<?php
namespace SY\Avatar\Block\Customer\Account;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session;
use \Magento\Customer\Model\Customer;
class Avatar extends Template {
	protected $session;
	const IMG_DIR = 'pub/media/SY/avatar/';
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
		return $this->session;
	}
	public function getAvatar(){
		$img = 'default.jpg';
		if($this->getCustomer()->getData('avatar')){
			if(file_exists(self::IMG_DIR.$this->getCustomer()->getData('avatar'))){
				$img = $this->getCustomer()->getData('avatar');
			}
		}
		return self::IMG_DIR.$img;
	}
}