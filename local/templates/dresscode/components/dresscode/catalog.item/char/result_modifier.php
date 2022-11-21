<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
?>

<?$obj = CIBlockElement::GetByID($arResult["PROPERTIES"]["ATT_BRAND"]["VALUE"]);?>
<?if($objres = $obj->GetNext())?>
<?$arResult['BRAND'] = $objres["NAME"];?>
