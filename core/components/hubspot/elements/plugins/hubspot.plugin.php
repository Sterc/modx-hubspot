<?php

/**
 * HubSpot
 *
 * Copyright 2020 by Sterc <oenetjeerd@sterc.nl>
 */

if (in_array($modx->event->name, ['OnMODXInit', 'OnHandleRequest', 'pdoToolsOnFenomInit'], true)) {
    $instance = $modx->getService('hubspotplugins', 'HubspotPlugins', $modx->getOption('hubspot.core_path', null, $modx->getOption('core_path') . 'components/hubspot/') . 'model/hubspot/');

    if ($instance instanceof HubspotPlugins) {
        $method = lcfirst($modx->event->name);

        if (method_exists($instance, $method)) {
            $instance->$method($scriptProperties);
        }
    }
}
