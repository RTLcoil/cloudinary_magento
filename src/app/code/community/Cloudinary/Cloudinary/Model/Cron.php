<?php

use CloudinaryExtension\ImageManagerFactory;

class Cloudinary_Cloudinary_Model_Cron extends Mage_Core_Model_Abstract
{
    private $_imageManager;

    public function __construct()
    {
        Mage::helper('cloudinary_cloudinary/autoloader')->register();

        $this->_imageManager = ImageManagerFactory::fromConfiguration(
            Mage::helper('cloudinary_cloudinary/configuration')
        );
    }

    public function migrateImages()
    {
        $images = Mage::getResourceModel('cloudinary_cloudinary/synchronisation_collection')
            ->findAllUnsynchronisedImages();

        $this->_imageManager->migrate($images);

        return $this ;
    }
} 
