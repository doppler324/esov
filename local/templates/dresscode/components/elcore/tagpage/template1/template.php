<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$this->SetViewTarget("menuRollClass");?> menuRolled<?$this->EndViewTarget();
	$this->SetViewTarget("hiddenZoneClass");?>hiddenZone<?$this->EndViewTarget();
	$this->SetViewTarget("smartFilter");
	
	
	if(CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog")){

	//global vars
	global $APPLICATION;

?>
	
	
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		".default",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["FILTER"]['IBLOCK_SECTION_ID'][0],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => $arParams["FILTER_PRICE_CODE"],
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SAVE_IN_SESSION" => "N",
			"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION",
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" =>  $arParams["CURRENCY_ID"],
			"SEF_MODE" => "Y",
			"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
			"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
			"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
			"COMPONENT_TEMPLATE" => ".default",
			"SECTION_CODE" => "",
			"SECTION_CODE_PATH" => ""
		),
		false
	);?>
<?
}
$this->EndViewTarget();?>




<h1><?if($sotbitSeoMetaH1):?>
		<?=$sotbitSeoMetaH1 . (Regions::is_region() ? " в " . Regions::get_name_case_region(5) : "")?>
	<?elseif(!empty($arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"])):?>
		<?=$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] . (Regions::is_region() ? " в " . Regions::get_name_case_region(5) : "")?>
	<?else:?>
		<?=$APPLICATION->ShowTitle(false)?><?endif;?></h1>