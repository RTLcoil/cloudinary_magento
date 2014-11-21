<?php

use CloudinaryExtension\Cloud;
use CloudinaryExtension\CloudinaryImageProvider;
use CloudinaryExtension\Credentials;
use CloudinaryExtension\ImageManager;
use CloudinaryExtension\Security\Key;
use CloudinaryExtension\Security\Secret;
use CloudinaryExtension\Image;

class Cloudinary_Cloudinary_Model_Image extends Mage_Core_Model_Abstract
{

    private $configuration;

    public function upload(array $imageDetails)
    {
        $imageProvider = new CloudinaryImageProvider($this->_getCredentials(), $this->_getCloudName());
        $cloudinary = new ImageManager($imageProvider);
        $cloudinary->uploadImage(
            $this->_imageFullPathFromImageDetails($imageDetails)
        );
    }

    private function _imageFullPathFromImageDetails($imageDetails)
    {
        return  $this->_getImageDetailFromKey($imageDetails, 'path') . $this->_getImageDetailFromKey($imageDetails, 'file');
    }

    private function _getCredentials()
    {
        $key = Key::fromString($this->_getConfigurationHelper()->getApiKey());
        $secret = Secret::fromString($this->_getConfigurationHelper()->getApiSecret());

        return new Credentials($key, $secret);
    }

    private function _getImageDetailFromKey(array $imageDetails, $key)
    {
        if(!array_key_exists($key, $imageDetails)) {
            throw new BadFilePathException("Invalid image data structure. Missing " . $key);
        }
        return $imageDetails[$key];
    }

    private function _getCloudName()
    {
        return Cloud::fromName($this->_getConfigurationHelper()->getCloudName());
    }

    private function _getConfigurationHelper()
    {
        if($this->configuration === null) {
            $this->configuration = Mage::helper('cloudinary_cloudinary/configuration');
        }
        return $this->configuration;
    }
}