<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

class HubspotSettingsSaveProcessor extends modObjectProcessor
{
    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['hubspot:default'];

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('hubspot', 'Hubspot', $this->modx->getOption('hubspot.core_path', null, $this->modx->getOption('core_path') . 'components/hubspot/') . 'model/hubspot/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function process()
    {
        foreach (['tracking_code'] as $key) {
            $setting = $this->getSetting($key);

            if ($setting) {
                $setting->fromArray([
                    'key'           => 'hubspot.' . $key,
                    'context_key'   => $this->getProperty('context_key'),
                    'xtype'         => 'textfield',
                    'namespace'     => 'hubspot',
                    'area'          => 'hubspot',
                    'value'         => $this->getProperty($key)
                ], false, true);

                $setting->save();
            }
        }

        return $this->success('JAJAJAJAJA');
    }

    /**
     * @access public.
     * @param String $key.
     * @return Object|Null.
     */
    protected function getSetting($key)
    {
        $setting = $this->modx->getObject('modContextSetting', [
            'key'           => 'hubspot.' . $key,
            'context_key'   => $this->getProperty('context_key')
        ]);

        if (!$setting) {
            $setting = $this->modx->newObject('modContextSetting');
        }

        return $setting;
    }
}

return 'HubspotSettingsSaveProcessor';
