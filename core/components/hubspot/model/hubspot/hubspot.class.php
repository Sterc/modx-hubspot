<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

class Hubspot
{
    /**
     * @access public.
     * @var modX.
     */
    public $modx;

    /**
     * @access public.
     * @var Array.
     */
    public $config = [];

    /**
     * @access public.
     * @param modX $modx.
     * @param Array $config.
     */
    public function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath   = $this->modx->getOption('hubspot.core_path', $config, $this->modx->getOption('core_path') . 'components/hubspot/');
        $assetsUrl  = $this->modx->getOption('hubspot.assets_url', $config, $this->modx->getOption('assets_url') . 'components/hubspot/');
        $assetsPath = $this->modx->getOption('hubspot.assets_path', $config, $this->modx->getOption('assets_path') . 'components/hubspot/');

        $this->config = array_merge([
            'namespace'             => 'hubspot',
            'lexicons'              => ['hubspot:default'],
            'base_path'             => $corePath,
            'core_path'             => $corePath,
            'model_path'            => $corePath . 'model/',
            'processors_path'       => $corePath . 'processors/',
            'elements_path'         => $corePath . 'elements/',
            'chunks_path'           => $corePath . 'elements/chunks/',
            'plugins_path'          => $corePath . 'elements/plugins/',
            'snippets_path'         => $corePath . 'elements/snippets/',
            'templates_path'        => $corePath . 'templates/',
            'assets_path'           => $assetsPath,
            'js_url'                => $assetsUrl . 'js/',
            'css_url'               => $assetsUrl . 'css/',
            'assets_url'            => $assetsUrl,
            'connector_url'         => $assetsUrl . 'connector.php',
            'version'               => '1.0.0',
            'branding_url'          => $this->modx->getOption('hubspot.branding_url', null, ''),
            'branding_help_url'     => $this->modx->getOption('hubspot.branding_url_help', null, ''),
            'context_aware'         => (bool) $this->isContextAware()
        ], $config);

        $this->modx->addPackage('hubspot', $this->config['model_path']);

        if (is_array($this->config['lexicons'])) {
            foreach ($this->config['lexicons'] as $lexicon) {
                $this->modx->lexicon->load($lexicon);
            }
        } else {
            $this->modx->lexicon->load($this->config['lexicons']);
        }
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getHelpUrl()
    {
        if (!empty($this->config['branding_help_url'])) {
            return $this->config['branding_help_url'] . '?v=' . $this->config['version'];
        }

        return false;
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getBrandingUrl()
    {
        if (!empty($this->config['branding_url'])) {
            return $this->config['branding_url'];
        }

        return false;
    }

    /**
     * @access public.
     * @param String $key.
     * @param Array $options.
     * @param Mixed $default.
     * @return Mixed.
     */
    public function getOption($key, array $options = [], $default = null)
    {
        if (isset($options[$key])) {
            return $options[$key];
        }

        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return $this->modx->getOption($this->config['namespace'] . '.' . $key, $options, $default);
    }

    /**
     * @access private.
     * @return Boolean.
     */
    private function isContextAware()
    {
        return $this->modx->getCount('modContext', [
            'key:!=' => 'mgr'
        ]) >= 1;
    }

    /**
     * @access public.
     * @param String $context.
     * @return Array.
     */
    public function getSettings($context = 'web')
    {
        $settings   = [];

        foreach (['tracking_code'] as $key) {
            $setting = $this->modx->getObject('modContextSetting', [
                'key'           => 'hubspot.' . $key,
                'context_key'   => $context
            ]);

            if ($setting) {
                $settings[$key] = $setting->get('value');
            } else {
                $settings[$key] = '';
            }
        }

        return $settings;
    }
}
