<?php
	class star_bxslider extends CModule {
		var $MODULE_ID = "star.bxslider";
		var $MODULE_VERSION;
		var $MODULE_VERSION_DATE;
		var $MODULE_NAME;
		var $MODULE_DESCRIPTION;
		var $MODULE_GROUP_RIGHTS = "N";
		var $PARTNER_NAME;
		var $PARTNER_URI;

		function __construct() {
			IncludeModuleLangFile(__FILE__);
			include(dirname(__FILE__)."/version.php");

			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
			$this->MODULE_NAME = GetMessage("STAR_BXSLIDER_MODULE_NAME");
			$this->MODULE_DESCRIPTION = GetMessage("STAR_BXSLIDER_MODULE_DESC");

			$this->PARTNER_NAME = GetMessage("STAR_BXSLIDER_PARTNER_NAME");
			$this->PARTNER_URI = GetMessage("STAR_BXSLIDER_PARTNER_URI");
		}

		function InstallFiles() {
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
			return true;
		}

		function UnInstallFiles() {
			DeleteDirFilesEx("/bitrix/components/star/bxslider/");
			return true;
		}

		function DoInstall() {
			$this->InstallFiles();
			RegisterModule($this->MODULE_ID);
		}

		function DoUninstall() {
			$this->UnInstallFiles();
			UnRegisterModule($this->MODULE_ID);
		}
	}
?>