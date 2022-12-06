

<?php
 
if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__);
}
 
define('BX_BUFFER_USED', true);
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('NO_AGENT_STATISTIC', true);
define('STOP_STATISTICS', true);
define('SITE_ID', 's1');
 
/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
 
/** @global \CUser $USER */
global $USER;
 
if (!(is_object($USER) && $USER instanceof \CUser)) {
    $USER = new \CUser();
}
 
$prepareScriptName = ltrim(
    str_replace(
        $_SERVER['DOCUMENT_ROOT'],
        '',
        __FILE__
    ),
    DIRECTORY_SEPARATOR
);
 
$logger = \Monolog\Registry::getInstance('app');
 
$logger->addInfo('Start clear all cache of site', [
    'type' => 'cron',
    'env' => \EnvironmentHelper::getEnvironmentType(),
    'bitrix_user_id' => $USER->GetID(),
    'script_name' => $prepareScriptName,
]);
 
BXClearCache(true);
 
if (class_exists('\Bitrix\Main\Data\ManagedCache')) {
    (new \Bitrix\Main\Data\ManagedCache())->cleanAll();
}
 
if (class_exists('\CStackCacheManager')) {
    (new \CStackCacheManager())->CleanAll();
}
 
if (class_exists('\Bitrix\Main\Data\StaticHtmlCache')) {
    \Bitrix\Main\Data\StaticHtmlCache::getInstance()->deleteAll();
}
 
$logger->addInfo('Done clear all cache of site', [
    'type' => 'cron',
    'env' => \EnvironmentHelper::getEnvironmentType(),
    'bitrix_user_id' => $USER->GetID(),
    'script_name' => $prepareScriptName,
]);
 
exit;

