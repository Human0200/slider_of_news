<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if(empty($arResult['PICTURES'])) {
	return;
}

if($arParams['SHOW_FRAME'] == 'Y') {
	$APPLICATION->SetAdditionalCSS($templateFolder . '/frame_style.css');
}

if($arParams['SORT_BY'] == 'RANDOM') {
	shuffle($arResult['PICTURES']);
}

?>
<div id="start-slider-block">
	<div id="start-slider">
		<ul>
		<?
		foreach($arResult['PICTURES'] as $element):
			$this->AddEditAction($element['ID'], $element['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($element['ID'], $element['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<li id="<?=$this->GetEditAreaId($element['ID']);?>">
			<?if(!empty($element['URL'])):?>
				<a href="<?=$element['URL']?>">
			<?endif;?>
					<img src="<?=$element['PICTURE']?>" title="<?=$element['NAME']?>" alt="<?=$element['NAME']?>" />
			<?if(!empty($element['URL'])):?>
				</a>
			<?endif;?>
			</li>
		<?
		endforeach;
		?>
		</ul>
	</div>
<?if($arParams['NAV_TYPE'] != 'NONE'):?>
	<div id="start-slide-pager" class="bx-pager<?=$arParams['NAV_TYPE'] == 'CIRCLES' ? ' bx-default-pager' : ' bx-number-pager'?>">
	<?foreach($arResult['PICTURES'] as $key => $element):?>
		<div class="bx-pager-item">
			<a href="" data-slide-index="<?=$key?>" class="bx-pager-link active"><?=($key + 1)?></a>
		</div>
	<?endforeach;?>
	</div>
<?endif;?>
</div>