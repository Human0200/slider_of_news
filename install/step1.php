<form action="<?echo $APPLICATION->GetCurPage()?>" name="form1">
<?=bitrix_sessid_post()?>
<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
<input type="hidden" name="install" value="Y">
<input type="hidden" name="step" value="2">

	<table cellpadding="3" cellspacing="0" border="0" width="0%">
		<tr>
			<td>
				<p><input id="startwwwInstallExaple" type="checkbox" name="setup_example" value="Y" checked><label for="startwwwInstallExaple"><?=GetMessage("startwww.slider_SETUP_EXAMPLE_ANSWER")?></label></p>
			</td>
		</tr>
	</table>		

	<input type="submit" name="inst" value="<?= GetMessage("MOD_INSTALL")?>">