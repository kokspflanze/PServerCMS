<?php

namespace PServerCMS\Service;


class CachingHelper extends InvokableBase
{
    /**
     * @param $cacheKey
     * @param \Closure $closure
     * @param null $lifetime
     * @return mixed
     */
    public function getItem($cacheKey, \Closure $closure, $lifetime = null)
    {
        // we have to check if we enable the caching in config
        if (!$this->isCachingEnable()) {
            return $closure();
        }

        $data = $this->getCachingService()->getItem($cacheKey);
        if (!$data) {
            $data = $closure();
            if ($lifetime > 0) {
                $this->getCachingService()->setOptions(
                    $this->getCachingService()
                        ->getOptions()
                        ->setTtl($lifetime)
                );
            }
            $this->getCachingService()->setItem($cacheKey, $data);
        }

        return $data;
    }

    /**
     * @param $cacheKey
     */
    public function delItem($cacheKey)
    {
        $this->getCachingService()->removeItem($cacheKey);
    }

    /**
     * @return bool
     */
    public function isCachingEnable()
    {
        return (bool)$this->getGeneralOptions()->getCache()['enable'];
    }

} 