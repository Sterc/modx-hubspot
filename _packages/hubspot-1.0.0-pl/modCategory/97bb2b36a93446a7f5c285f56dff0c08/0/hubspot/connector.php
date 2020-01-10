<?php

/**
 * Hubspot
 *
 * Copyright 2019 by Sterc <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->getService('hubspot', 'Hubspot', $modx->getOption('hubspot.core_path', null, $modx->getOption('core_path') . 'components/hubspot/') . 'model/hubspot/');

if ($modx->hubspot instanceof Hubspot) {
    $modx->request->handleRequest([
        'processors_path'   => $modx->hubspot->config['processors_path'],
        'location'          => ''
    ]);
}
