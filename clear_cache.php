<?
$_SERVER['DOCUMENT_ROOT'] = $DOCUMENT_ROOT = $argv[1];
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
@set_time_limit(0);

BXClearCache(true);
$GLOBALS["CACHE_MANAGER"]->CleanAll();
$GLOBALS["stackCacheManager"]->CleanAll();
$taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
$taggedCache->deleteAllTags();
$page = \Bitrix\Main\Composite\Page::getInstance();
$page->deleteAll();
?>
