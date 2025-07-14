<?
IncludeModuleLangFile(__FILE__);
Class startwww_slider extends CModule
{
	const MODULE_ID = 'startwww.slider';
	const IBLOCK_TYPE_ID = 'startwwwSliderExample';
	var $MODULE_ID = 'startwww.slider'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("startwww.slider_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("startwww.slider_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("startwww.slider_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("startwww.slider_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
	
	
		RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CStartwwwSlider', 'OnBuildGlobalMenu');
		if($arParams['setupExample'] == 'Y' && CModule::IncludeModule('iblock')) {
		
			// find iblock type
			if(!$arIblockType = CIBlockType::GetList(array('ID'), array('ID' => self::IBLOCK_TYPE_ID))->Fetch()) {
				// IBlock type
				$arFields = array(
					'ID' => self::IBLOCK_TYPE_ID,
					'SECTIONS' => 'N',
					'IN_RSS' => 'N',
					'SORT' => 100,
					'LANG' => array(
						'ru' => array(
							'NAME' => 'Startwww Slider Example',
							'ELEMENT_NAME' => 'slide'
						),
						'en'=> array(
							'NAME' => 'Startwww Slider Example',
							'ELEMENT_NAME' => 'slide'
						)
					)
				);
				$obBlocktype = new CIBlockType;
				if(!$res = $obBlocktype->Add($arFields)) {
					return false;
				}
			}
			if(!$arIblock = CIBlock::GetList(array('ID'), array('CODE' => self::IBLOCK_TYPE_ID, 'IBLOCK_TYPE_ID' => self::IBLOCK_TYPE_ID))->Fetch()) {
				// IBlock
				$sites = array();
				$rsSites = CSite::GetList($by = 'sort', $order = 'asc', array('ACTIVE' => 'Y'));
				while($arSite = $rsSites->Fetch()) {
					$sites[] = $arSite['ID'];
				}
			
				$ib = new CIBlock;
				$arFields = array(
					'ACTIVE' => 'Y',
					'NAME' => GetMessage("startwww.slider_IBLOCK_NAME"),
					'CODE' => self::IBLOCK_TYPE_ID,
					'LIST_PAGE_URL' => '',
					'DETAIL_PAGE_URL' => '',
					'IBLOCK_TYPE_ID' => self::IBLOCK_TYPE_ID,
					'SITE_ID' => $sites,
					'SORT' => 100,
					'INDEX_ELEMENT' => 'N',
					'VERSION' => 2,
					'PICTURE' => '',
					'DESCRIPTION' => '',
					'DESCRIPTION_TYPE' => 'html',
					'WORKFLOW' => 'N',
					'GROUP_ID' => array(
						'2' => 'R'
					)
				);
				if(!$iblockId = $ib->Add($arFields)) {
					return false;
				}
				// Property
				if(!$property = CIBlockProperty::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => $iblockId, 'CODE' => 'URL'))->Fetch()) {		
					$ibp = new CIBlockProperty;
					$arFields = array(
						'NAME' => GetMessage("startwww.slider_PROPERTY_NAME"),
						'ACTIVE' => 'Y',
						'SORT' => '100',
						'CODE' => 'URL',
						'PROPERTY_TYPE' => 'S',
						'IBLOCK_ID' => $iblockId
					);
					$propID = $ibp->Add($arFields);
				}
				// Element
				if(!$arIblockElement = CIBlockElement::GetList(array('ID'), array('IBLOCK_ID' => $iblockId), false, array('nTopCount' => 1))->Fetch()) {
					$el = new CIBlockElement;
					$arLoadProductArray = array(
						'IBLOCK_SECTION_ID' => false,
						'IBLOCK_ID'      => $iblockId,
						'PROPERTY_VALUES' => array(
							'URL' => 'https://www.google.ru/'
						),
						'NAME'           => 'Slide',
						'ACTIVE'         => 'Y',
						'PREVIEW_PICTURE' => CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/images/startwww-example-image.jpg')
					);

					$productId = $el->Add($arLoadProductArray);
				}
			}
			
		}
	
		
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CStartwwwSlider', 'OnBuildGlobalMenu');
		if($arParams['deleteExample'] == 'Y' && CModule::IncludeModule('iblock')) {
			CIBlockType::Delete(self::IBLOCK_TYPE_ID);
		}
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item,
					'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.self::MODULE_ID.'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function UnInstallFiles()
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function DoInstall()
	{
		global $DB, $DOCUMENT_ROOT, $APPLICATION, $step, $errors;

		$FORM_RIGHT = $APPLICATION->GetGroupRight(self::MODULE_ID);
		if ($FORM_RIGHT >= 'W') {
			
			$step = IntVal($step);
			if($step < 2) {
			
				$APPLICATION->IncludeAdminFile(
					GetMessage("startwww.slider_INSTALL_TITLE"),
					$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/'.self::MODULE_ID.'/install/step1.php'
				);
				
			} elseif($step == 2) {
				$this->InstallFiles();
				$this->InstallDB(array("setupExample" => $_REQUEST["setup_example"]));
				RegisterModule(self::MODULE_ID);
				$APPLICATION->IncludeAdminFile(
					GetMessage("startwww.slider_INSTALL_TITLE"), 
					$_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/step2.php');
				
			}
		
		}
		
	}

	function DoUninstall()
	{		
		global $DB, $APPLICATION, $step, $errors;

		$FORM_RIGHT = $APPLICATION->GetGroupRight(self::MODULE_ID);
		if ($FORM_RIGHT >= "W")
		{
			$step = IntVal($step);
			if($step < 2) {
			
				$APPLICATION->IncludeAdminFile(
					GetMessage("startwww.slider_UNISTALL_TITLE"), 
					$_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/unstep1.php'
				);
				
			} elseif($step == 2) {
			
				$errors = false;
				UnRegisterModule(self::MODULE_ID);
				$this->UnInstallFiles();
				$this->UnInstallDB(array("deleteExample" => $_REQUEST["deleteExample"]));
				$APPLICATION->IncludeAdminFile(
					GetMessage("startwww.slider_UNISTALL_TITLE"),
					$_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/unstep2.php'
				);
			}
		}
	}
}
?>
