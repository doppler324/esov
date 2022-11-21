<?
//globals
global $APPLICATION;

//append paysystems text edit icon (because after ajax request id resets)
if($APPLICATION->GetShowIncludeAreas()){
    $APPLICATION->IncludeString("", array(array(
		"URL" => "/bitrix/admin/fileman_file_edit.php?path=%2Fsect_detail_paysystems.php",
		"SRC" => SITE_TEMPLATE_PATH."/images/paysystems_edit.png",
		"ALT" => GetMessage("AJAX_PAYSYSTEMS_EDIT_TITLE")
	)));
}

//$APPLICATION->AddChainItem("Характеристики ".$arResult["NAME"], "");
 $APPLICATION->SetPageProperty("title", "Отзывы ".$arResult["NAME"]." - Кнайфы.рф");
$APPLICATION->SetPageProperty("keywords", $arResult["NAME"].",Кнайфы.рф,отзывы");
$APPLICATION->SetPageProperty("description", "Отзывы " . $arResult["NAME"] . " и рейтинг -  Кнайфы.рф"); 
?>