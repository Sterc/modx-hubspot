<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/hubspot.class.php';

class HubspotPlugins extends Hubspot
{
    /**
     * @access public.
     */
    public function onMODXInit()
    {
        $this->onHandleSettings();
    }

    /**
     * @access public.
     */
    public function onHandleRequest()
    {
        $this->onHandleSettings();
    }

    /**
     * @access public.
     */
    public function pdoToolsOnFenomInit()
    {
        $this->onHandleSettings();
    }

    /**
     * @access private.
     */
    private function onHandleSettings()
    {
        $settings = $this->getSettings($this->modx->context->get('key'));

        if ($settings) {
            $this->modx->setPlaceholders($settings, '+');

            foreach ($settings as $key => $value) {
                $this->modx->setOption($key, $value);
            }
        }
    }
}
