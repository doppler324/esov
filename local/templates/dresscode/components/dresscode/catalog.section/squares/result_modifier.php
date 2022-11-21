<?
//echo '<pre>';print_r($arResult["ITEMS"]);echo '</pre>';
// дополняем листинг до 60 товаров
if(count($arResult["ITEMS"]) < 60){
	foreach($arResult["ITEMS"] as $item){
		$arID[] = $item["ID"];
	}unset($item);
	$result = CIBlockElement::GetList(array("RAND" => "ASC"), array("!ID" => $arID, "IBLOCK_ID" => $arResult["IBLOCK_ID"], "SECTION_ID" => $arResult["ID"]), false, array("nTopCount" => 60 - count($arResult["ITEMS"])));
	while($arItem = $result->GetNext()){
		$arResult["RELATED_ITEMS"][$arItem["ID"]] = $arItem;
	} 
}

// внедряем LSI в товары
if(!empty($arResult['UF_WORDS'])){
	
	$keys = array_keys($arResult["ITEMS"]);	
	$count = (count($arResult["ITEMS"]) > count($arResult["UF_WORDS"]) ? count($arResult["UF_WORDS"]) : count($arResult["UF_WORDS"]) - count($arResult["ITEMS"])) - 1;

	for($i = 0; $i < $count; $i++){
		$arResult["ITEMS"][$keys[($count == 1 ? $count - 1 : $count) - $i]]["LSI"] = mb_ucfirst($arResult["UF_WORDS"][$i]);
	}unset($keys);	
	
	if(count($arResult["ITEMS"]) < 60){
		
		$related_keys = array_keys($arResult["RELATED_ITEMS"]);
		for($i = $count; $i < count($arResult["UF_WORDS"]); $i++){
			$arResult["RELATED_ITEMS"][$related_keys[count($arResult["RELATED_ITEMS"]) - $i]]["LSI"] = mb_ucfirst($arResult["UF_WORDS"][$i]);
		}unset($related_keys);
		
	}unset($count);	
}
// редирект несуществующих значений фильтра

if(empty($arResult['FILTER']) && strpos($APPLICATION->GetCurPage(false), "/filter/") !== false){
	LocalRedirect($arResult["SECTION_PAGE_URL"], false, "301 Moved permanently");
}