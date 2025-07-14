<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule('iblock');

if(empty($arParams['IBLOCK_ID'])) {
	$iblockTypeId = 'startwwwSliderExample';
	if(!$arIblock = CIBlock::GetList(array('ID'), array('CODE' => $iblockTypeId, 'IBLOCK_TYPE_ID' => $iblockTypeId))->Fetch()) {
		return;
	}
	
	$arParams['IBLOCK_ID'] = $arIblock['ID'];
}

$arParams['TIME_TO_CHANGE'] = intval($arParams['TIME_TO_CHANGE']);
if(empty($arParams['TIME_TO_CHANGE'])) {
	$arParams['TIME_TO_CHANGE'] = 1;
}
//s -> ms
$arParams['TIME_TO_CHANGE'] = $arParams['TIME_TO_CHANGE'] * 1000; 

//to upper
$arParams['URL_PROP_CODE'] = strtoupper($arParams['URL_PROP_CODE']);

if($arParams['INCLUDE_JQUERY'] === 'Y') {
	CUtil::InitJSCore(array('jquery'));
}
$APPLICATION->AddHeadScript($componentPath . '/js/jquery.bxslider.min.js');

$arResult = array();

$arButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0);
if($APPLICATION->GetShowIncludeAreas()) {
	$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}

if ($this->StartResultCache(false, false)) {
    
	$arSort = array();
	if($arParams['SORT_BY'] != 'RANDOM') {
		$arSort[$arParams['SORT_BY']] = $arParams['SORT_TYPE'];
	}
	
	$arFilter = array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'ACTIVE' => 'Y',
		array(
			'LOGIC' => 'OR',
			array('!PREVIEW_PICTURE' => false),
			array('!DETAIL_PICTURE' => false)
		)
	);
	
	$arSelect = array(
		'ID',
		'NAME',
		'PREVIEW_PICTURE',
		'DETAIL_PICTURE'
	);
	
	if(!empty($arParams['URL_PROP_CODE'])) {
		$arSelect[] = 'PROPERTY_' . $arParams['URL_PROP_CODE'];
	}
	
	$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, array('nTopCount' => 5), $arSelect);
	while($arElement = $rsElement->Fetch()) {
		
		$arButtons = CIBlock::GetPanelButtons(
			$arParams['IBLOCK_ID'],
			$arElement['ID'],
			0,
			array('SECTION_BUTTONS' => false, 'SESSID' => false)
		);
		$adminData['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
		$adminData['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];
		
		$pictureId = !empty($arElement['DETAIL_PICTURE']) ? $arElement['DETAIL_PICTURE'] : $arElement['PREVIEW_PICTURE'];
		
		$file = CFile::ResizeImageGet($pictureId, array('width' => $arParams['WIDTH'], 'height' => $arParams['HEIGHT']), BX_RESIZE_IMAGE_EXACT, false);
		$tmpArElement = array(
			'ID' => $arElement['ID'],
			'NAME' => $arElement['NAME'],
			'PICTURE' => $file['src'],
			'EDIT_LINK' => $adminData['EDIT_LINK'],
			'DELETE_LINK' => $adminData['DELETE_LINK'],
		);
		
		if(!empty($arElement['PROPERTY_' . $arParams['URL_PROP_CODE'] . '_VALUE'])) {
			$tmpArElement['URL'] = $arElement['PROPERTY_' . $arParams['URL_PROP_CODE'] . '_VALUE'];
		}
		$arResult['PICTURES'][] = $tmpArElement;
	}
	
	$this->SetResultCacheKeys(array(
		'PICTURES',
	));
	
    $this->IncludeComponentTemplate(); 
}
?>
<script>
	$(function() {
		$('#start-slider ul').bxSlider({
			mode: '<?=$arParams['MODE']?>',
			slideWidth: <?=intval($arParams['WIDTH'])?>,
			pager: <?=$arParams['NAV_TYPE'] != 'NONE' ? 'true' : 'false'?>,
			responsive: false,
			pagerCustom: <?=$arParams['NAV_TYPE'] != 'NONE' ? '\'#start-slide-pager\'' : 'null'?>,
			controls: <?=$arParams['SHOW_ARROWS'] == 'Y' ? 'true' : 'false'?>,
			auto: <?=$arParams['AUTO_SCROLL'] == 'Y' ? 'true' : 'false'?>,
			pause: <?=$arParams['TIME_TO_CHANGE']?>
			
		});
	<?if($arParams['NAV_TYPE'] != 'NONE'):?>
		var sliderWidth = $('#start-slider-block').outerWidth();
		var navigationWidth = $('#start-slide-pager').outerWidth();
		console.log(sliderWidth, navigationWidth)
		$('#start-slide-pager').css('left', (sliderWidth - navigationWidth)/2);
	<?endif;?>
	});
</script>
