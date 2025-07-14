<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('START_NAME'),
	'DESCRIPTION' => GetMessage('START_DESCRIPTION'),
	'ICON' => '/images/icon.gif',
	'SORT' => 90,
	'CACHE_PATH' => 'Y',
	'PATH' => array(
		'ID' => 'startwww',
		'NAME' => GetMessage('START_PATH_NAME')
	),
);

?>
