<?php
namespace SY\Avatar\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface {
    private $objectmanager;
    public function __construct(
            \Magento\Framework\ObjectManagerInterface $objectmanager
        ){
        $this->objectmanager = $objectmanager;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        // Move avatars from old dir to new
        if(version_compare($context->getVersion(), '0.1.9') < 0) {
            $fileSystem = $this->objectmanager->create('\Magento\Framework\Filesystem');
            $io = $this->objectmanager->create('Magento\Framework\Filesystem\Io\File');
            $rootConstant = \Magento\Framework\App\Filesystem\DirectoryList::ROOT;
            $rootDir = $fileSystem->getDirectoryRead($rootConstant)->getAbsolutePath();
            if(!is_dir($rootDir.'media/')){
                $io->mkdir($rootDir.'media/');
            }
            if(!is_dir($rootDir.'media/avatar/')){
                $io->mkdir($rootDir.'media/avatar/');
            }
            $oldDir = $rootDir.'app/code/SY/Avatar/view/frontend/web/media/';
            $newDir = $rootDir.'media/avatar/';
            if(is_dir($oldDir)){
                foreach (scandir($oldDir) as $entry) {
                    if(is_dir($oldDir.$entry)){
                        $io->mv($oldDir.$entry, $newDir.$entry);
                    }
                }
            }
        }
    }
}