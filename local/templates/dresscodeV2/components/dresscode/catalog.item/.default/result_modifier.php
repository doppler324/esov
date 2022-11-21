<?
use Bitrix\Main\Loader; 
Loader::includeModule("highloadblock"); 
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
?>

<?//echo '<pre>';print_r($arResult);echo '</pre>';?>

<?
// получаем бренд
$obj = CIBlockElement::GetByID($arResult["PROPERTIES"]["ATT_BRAND"]["VALUE"]);?>
<?if($objres = $obj->GetNext())?>
<?$arResult["BRAND"] = $objres["NAME"];?>
<?
// формируем название товара
if(!IS_FILTER){
	/* if(!empty($arParams['TAGS'])){
		$arResult["NAME"] = $arParams["LSI"] . " " .  $arParams["TAGS"]["CURRENT_TAG"]["NAME"] . " " . $arResult["BRAND"] . " " . $arResult['PROPERTIES']["SHORT_NAME"]['VALUE'];
	}elseif($arParams['UF_BEFORE_PRODUCT']){
		$arResult["NAME"] = $arParams["LSI"] . " " . mb_lcfirst($arParams['UF_BEFORE_PRODUCT']) . " " . $arResult["BRAND"] . " " . $arResult['PROPERTIES']["SHORT_NAME"]['VALUE'];
	}elseif(IS_BRAND_PAGE){
		$arResult["NAME"] = ($arParams["LSI"] ? $arParams["LSI"] . " кроссовки" : "Кроссовки") . " " . $arResult["BRAND"] . " " . $arResult['PROPERTIES']["SHORT_NAME"]['VALUE'];
	}else{ */
		$arResult["NAME"] = $arParams["LSI"] . " " . ($arParams["LSI"] ? mb_lcfirst($arParams["UF_BEFORE_PRODUCT"]) : $arParams["UF_BEFORE_PRODUCT"]) . " " . $arResult["NAME"];
	//}
}
// получчаем партнерские ссылки

$hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch(); 

$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
$entity_data_class = $entity->getDataClass(); 

$rsData = $entity_data_class::getList(array(
   "select" => array("*"),
   "order" => array("ID" => "ASC"),
   "filter" => array("UF_SHOP" => $arResult['PROPERTIES']['INTERNET']['~VALUE'])  // Задаем параметры фильтра выборки
));

while($arData = $rsData->Fetch()){
   $arResult["PARTNER_LINK"] = $arData["UF_LINK"];
}