<?php

// Function to identify the framework
function identifyFramework($sourceCode) {
    // List of frameworks with unique identifiers in the source code
    $frameworks = array(
        "WordPress" => array('<meta name="generator" content="WordPress', 'get_header', 'wp_enqueue_script', 'wp_footer', '/wp-content/', '/wp-includes/'),
        "Contao" => array('Contao Open Source Content Management System', '/system/modules/', '/tl_files/'),
        "Drupal" => array('<meta name="Generator" content="Drupal"', 'class="views-row"', 'class="block"', 'class="node"', 'Drupal.behaviors', '/sites/default/', '/modules/', '/themes/', '<!-- BEGIN output from modules in block -->', 'drupal-settings-json'),
        "TYPO3" => array('<meta name="generator" content="TYPO3"', '/typo3conf/', '/typo3temp/', '/typo3/', 'typo3/sysext/', 'class="typo3"', 't3lib/'),
        "Joomla" => array('<meta name="generator" content="Joomla!"', '/components/', '/modules/', '/templates/', '/media/', 'JHtml::(\'behavior.framework\')', 'class="joomla"', 'JFactory', 'JURI', 'JRoute', 'JModel'),
        "Shopware" => array('<meta name="generator" content="Shopware"', '/shopware.php', '/themes/Frontend/', '/engine/Shopware/', 'Shopware', 'class="shopware"', 'sViewport', 'sAction'),
        "Magento" => array('<meta name="generator" content="Magento"', '/skin/frontend/', '/js/mage/', '/media/', 'Mage.Cookies', 'Mage.Captcha', 'class="catalog-product-view"', 'class="block-layered-nav"', 'mage-cache-storage', 'mage-cache-storage-section-invalidation'),
        "Neos" => array('<meta name="generator" content="Neos"', '/_Resources/', '/_Resources/Static/', '/_Resources/Persistent/', 'Neos.Neos', 'class="neos"', 'data-neos'),
        "Contentful" => array('<meta name="generator" content="Contentful"', 'contentful', 'class="contentful"', 'cdn.contentful.com', 'images.ctfassets.net', 'data-contentful'),
        "Ionos" => array('<meta name="generator" content="1&1 IONOS"', '/sites/default/files/', 'ionos', 'class="ionos"', 'data-ionos'),
        "Wix" => array('<meta name="generator" content="Wix.com Website Builder"', 'wixCode', 'wixapps', 'class="wix"', '/_api/wix/', '/_partials/wix/', 'data-wix'),
        "Weebly" => array('<meta name="generator" content="Weebly"', 'WEEBLY_STATIC', 'WEEBLY_VERSION', 'class="weebly"', '/files/theme/', '/cdn2.editmysite.com/', 'data-weebly'),
        "Shopify" => array('<meta name="generator" content="Shopify"', 'Shopify', 'class="shopify"', '/cdn.shopify.com/', '/shopifycloud/', 'data-shopify'),
        "Jimdo" => array('<meta name="generator" content="Jimdo"', 'Jimdo', 'class="jimdo"', '/cdn.jimdo.com/', '/jimdo.com/', 'data-jimdo')
    );

    // Check the source code for each framework's identifiers
    foreach ($frameworks as $frameworkName => $frameworkData) {
        foreach ($frameworkData as $checkString) {
            if (strpos($sourceCode, $checkString) !== false) {
                return $frameworkName;
            }
        }
    }

    return "-"; // If no framework is found
}