<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/* use Bitrix\Main\Loader;
Loader::includeModule("iblock");
Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

define("REGION_IBLOCK_ID", 2);

CModule::IncludeModule("highloadblock"); 
$hlblock = HL\HighloadBlockTable::getById( REGION_IBLOCK_ID )->fetch();
$entity = HL\HighloadBlockTable::compileEntity( $hlblock );
$entity_data_class = $entity->getDataClass();
$rsData = $entity_data_class::getList(array(
   'select' => array('UF_CITY', 'UF_SUBDOMAIN'),
   'order' => array('UF_CITY' => 'ASC')
));
while($arRes = $rsData->Fetch()){
	
	$arResult['HL_CITY'][$arRes['UF_CITY']] = array($arRes['UF_CITY'], $arRes['UF_SUBDOMAIN']);
	
}  */