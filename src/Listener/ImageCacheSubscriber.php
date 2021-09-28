<?php

namespace App\Listener;

use App\Entity\Articles;
use Doctrine\ORM\Mapping\PreFlush;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class ImageCacheSubscriber implements EventSubscriber{

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper )
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if (!$entity instanceof Articles){
            return;
        }    
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
        if (!$entity instanceof Articles){
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
  
    /**
     * Get the value of cacheManager
     */ 
    public function getCacheManager()
    {
        return $this->cacheManager;
    }

    /**
     * Set the value of cacheManager
     *
     * @return  self
     */ 
    public function setCacheManager($cacheManager)
    {
        $this->cacheManager = $cacheManager;

        return $this;
    }

    /**
     * Get the value of uploaderHelper
     */ 
    public function getUploaderHelper()
    {
        return $this->uploaderHelper;
    }

    /**
     * Set the value of uploaderHelper
     *
     * @return  self
     */ 
    public function setUploaderHelper($uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;

        return $this;
    }
}