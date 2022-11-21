<? 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


//include module
\Bitrix\Main\Loader::includeModule("dw.deluxe");

//vars
$catalogIblockId = null;
$arPriceCodes = array();

//get template settings
$arTemplateSettings = DwSettings::getInstance()->getCurrentSettings();
if(!empty($arTemplateSettings)){
	$catalogIblockId = $arTemplateSettings["TEMPLATE_PRODUCT_IBLOCK_ID"];
	$arPriceCodes = explode(", ", $arTemplateSettings["TEMPLATE_PRICE_CODES"]);
}

//globals
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"dresscode:menu.sections", 
	"", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "15",
		"DEPTH_LEVEL" => "3",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"IS_SEF" => "N",
		"ID" => $_REQUEST["ID"],
		"SECTION_URL" => "",
		"CALC_COUNT_ELEMENTS_IN_SECTION" => "N",
		"SEF_BASE_URL" => "/catalog/",
		"SECTION_PAGE_URL" => "#SECTION_CODE#/",
		"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#.html"
	),
	false
); 

foreach($aMenuLinksExt as &$item){
	$res = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $catalogIblockId, "ID" => $item[3]["ID"]), false, array("UF_MENU_URL"));
	$item[1] = $res->Fetch()["UF_MENU_URL"];
}
//echo '<pre>';print_r($aMenuLinksExt);echo '</pre>';
//append menu items
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt); 
?>