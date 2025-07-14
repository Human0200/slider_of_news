<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('iblock')) {
    return;
}
$arTypesEx = CIBlockParameters::GetIBlockTypes(array('-' => ' '));

$arIBlocks = array();
$rsIblock = CIBlock::GetList(array('SORT' => 'ASC'), array('SITE_ID' => $_REQUEST['site'], 'TYPE' => ($arCurrentValues['IBLOCK_TYPE'] != '-' ? $arCurrentValues['IBLOCK_TYPE'] : '')));
while($arRes = $rsIblock->Fetch()) {
    $arIBlocks[$arRes['ID']] = $arRes['NAME'];
}

$arNavType = array(
	'NONE' => GetMessage('START_NAV_SLIDER_NONE'), 
	'CIRCLES' => GetMessage('START_NAV_SLIDER_CIRCLES'), 
	'NUMBERS' => GetMessage('START_NAV_SLIDER_NUMBERS')
);

$arSorts = array(
	'ASC' => GetMessage('START_IBLOCK_DESC_ASC'), 
	'DESC' => GetMessage('START_IBLOCK_DESC_DESC')
);
$arSortFields = array(
	'ACTIVE_FROM' => GetMessage('START_IBLOCK_DESC_FACT'),
	'SORT' => GetMessage('START_IBLOCK_DESC_FSORT'),
	'RANDOM' => GetMessage('START_IBLOCK_DESC_RANDOM'),
);

$arMods = array(
	'horizontal' => GetMessage('START_SLIDER_MODE_HORIZONTAL'),
	'vertical' => GetMessage('START_SLIDER_MODE_VERTICAL'),
	'fade' => GetMessage('START_SLIDER_MODE_FADE')
);
	
$arComponentParameters = array(
    'GROUPS' => array(
		'BASE' => array(
			'SORT' => 100
		),
		'ANIMATION_AND_STYLES' => array(
			'NAME' => GetMessage('START_ANIMATION_AND_STYLES'),
			'SORT' => 200
		),
		'CACHE_SETTINGS' => array(
			'SORT' => 300
		)
    ),
    'PARAMETERS' => array(
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('START_IBLOCK_TYPE'),
            'TYPE' => 'LIST',
            'VALUES' => $arTypesEx,
            'DEFAULT' => 'news',
            'REFRESH' => 'Y',
        ),
        'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('START_IBLOCK_CODE'),
            'TYPE' => 'LIST',
            'VALUES' => $arIBlocks,
            'DEFAULT' => '',
            'ADDITIONAL_VALUES' => 'Y',
            'REFRESH' => 'Y',
        ),
		'SORT_BY' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('START_IBLOCK_DESC_SORT_BY'),
			'TYPE' => 'LIST',
			'DEFAULT' => 'SORT',
			'VALUES' => $arSortFields,
		),
		'SORT_TYPE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('START_IBLOCK_DESC_SORT_TYPE'),
			'TYPE' => 'LIST',
			'DEFAULT' => 'ASC',
			'VALUES' => $arSorts,
		),
		'INCLUDE_JQUERY' => array(
			'NAME' => GetMessage('START_INCLUDE_JQUERY'),
			'TYPE' => 'CHECKBOX',
			'PARENT' => 'BASE',
		),
		'WIDTH' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('START_SLIDER_WIDTH'),
			'TYPE' => 'STRING',
			'DEFAULT' => '600',
		),
		'HEIGHT' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('START_SLIDER_HEIGHT'),
			'TYPE' => 'STRING',
			'DEFAULT' => '200',
		),
		'URL_PROP_CODE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('START_URL_PROP_CODE'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'URL',
		),
		'SHOW_FRAME' => array(
			'NAME' => GetMessage('START_SHOW_FRAME'),
			'TYPE' => 'CHECKBOX',
			'PARENT' => 'ANIMATION_AND_STYLES',
			'DEFAULT' => 'Y'
		),
		'NAV_TYPE' => array(
            'PARENT' => 'ANIMATION_AND_STYLES',
            'NAME' => GetMessage('START_NAV_PARAM_NAME'),
            'TYPE' => 'LIST',
            'MULTIPLE' => 'N',
			'DEFAULT' => 'EMPTY',
            'VALUES' => $arNavType,
        ),
		'SHOW_ARROWS' => array(
			'NAME' => GetMessage('START_SHOW_ARROWS'),
			'TYPE' => 'CHECKBOX',
			'PARENT' => 'ANIMATION_AND_STYLES',
			'DEFAULT' => 'Y'
		),
		'MODE' => array(
			'PARENT' => 'ANIMATION_AND_STYLES',
			'NAME' => GetMessage('START_SLIDER_MODE'),
			'TYPE' => 'LIST',
			'DEFAULT' => 'horizontal',
			'VALUES' => $arMods,
		),
		'AUTO_SCROLL' => array(
			'NAME' => GetMessage('START_AUTO_SCROLL'),
			'TYPE' => 'CHECKBOX',
			'PARENT' => 'ANIMATION_AND_STYLES',
			'DEFAULT' => 'N'
		),
		'TIME_TO_CHANGE' => array(
			'PARENT' => 'ANIMATION_AND_STYLES',
			'NAME' => GetMessage('START_TIME_TO_CHANGE'),
			'TYPE' => 'STRING',
			'DEFAULT' => '4',
		),
        'CACHE_TIME' => array('DEFAULT' => 3600000),
    ),
);
?>
