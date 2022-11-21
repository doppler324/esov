<?
use Bitrix\Main\Loader; 
Loader::includeModule("highloadblock"); 
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
?>
<?
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