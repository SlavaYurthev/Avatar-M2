<?php
/**
 * Avatar
 * 
 * @author Slava Yurthev
 */
namespace SY\Avatar\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Store\Model\ScopeInterface;
class Data extends AbstractHelper {
	public static function getCustomerAvatarById($id){
		$block = \Magento\Framework\App\ObjectManager::getInstance()->create('SY\Avatar\Block\Customer\Account\Avatar');
		$block->getCustomer($id);
		return $block->getAvatar();
	}
}