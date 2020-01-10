<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

abstract class HubspotManagerController extends modExtraManagerController
{
    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('hubspot', 'Hubspot', $this->modx->getOption('hubspot.core_path', null, $this->modx->getOption('core_path') . 'components/hubspot/') . 'model/hubspot/');

        $this->addCss($this->modx->hubspot->config['css_url'] . 'mgr/hubspot.css');

        $this->addJavascript($this->modx->hubspot->config['js_url'] . 'mgr/hubspot.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.config.help_url = "' . $this->modx->hubspot->getHelpUrl() . '";
        
                Hubspot.config = ' . $this->modx->toJSON(array_merge($this->modx->hubspot->config, [
                    'branding_url'          => $this->modx->hubspot->getBrandingUrl(),
                    'branding_url_help'     => $this->modx->hubspot->getHelpUrl()
                ])) . ';
            });
        </script>');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getLanguageTopics()
    {
        return $this->modx->hubspot->config['lexicons'];
    }

    /**
     * @access public.
     * @returns Boolean.
     */
    public function checkPermissions()
    {
        return $this->modx->hasPermission('hubspot');
    }
}

class IndexManagerController extends HubspotManagerController
{
    /**
     * @access public.
     * @return String.
     */
    public static function getDefaultController()
    {
        return 'home';
    }
}
