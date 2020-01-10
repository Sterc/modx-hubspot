<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

require_once dirname(__DIR__) . '/index.class.php';

class HubspotHomeManagerController extends HubspotManagerController
{
    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->hubspot->config['js_url'] . 'mgr/widgets/home.panel.js');

        $this->addLastJavascript($this->modx->hubspot->config['js_url'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                Hubspot.config.record = ' . $this->modx->toJSON($this->getSettings()) . ';
            });
        </script>');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('hubspot');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getTemplateFile()
    {
        return $this->modx->hubspot->config['templates_path'] . 'home.tpl';
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getSettings()
    {
        $context = $this->modx->getOption('default_context', null, 'web');

        if (isset($_GET['context'])) {
            $context = $_GET['context'];
        }

        return $this->modx->hubspot->getSettings($context);
    }
}
