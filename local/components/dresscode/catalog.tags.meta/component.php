<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
		die();
	}
	//globals
	global $APPLICATION;
	//chain
	if(!empty($arParams["TAG_NAME"]) || !empty($arParams["META_HEADING"])){
		
		$arParams["TAG_NAME"] = str_replace(
								array("{plus_filter}"),
								array($arParams["TAG_FILTER"]),
								$arParams["TAG_NAME"]);
		
		$APPLICATION->AddChainItem($arParams["TAG_NAME"] ? $arParams["TAG_NAME"] : $arParams["META_HEADING"] . " " . $arParams["TAG_FILTER"], "");
	}

	//set title
	if(!empty($arParams["META_TITLE"])){
		$arParams["META_TITLE"] = str_replace(
								array("{plus_filter}"),
								array($arParams["TAG_FILTER"]),
								$arParams["META_TITLE"]);
		$APPLICATION->SetPageProperty("title", $arParams["META_TITLE"]);
	}
	//heading
	if(!empty($arParams["META_HEADING"])){
		
		$arParams["META_HEADING"] = str_replace(
								array("{plus_filter}"),
								array($arParams["TAG_FILTER"]),
								$arParams["META_HEADING"]);
		
		$APPLICATION->SetTitle($arParams["META_HEADING"] . " " . $arParams["TAG_FILTER"]);
	}

	//keywords
	if(isset($arParams["META_KEYWORDS"])){
		
		$arParams["META_KEYWORDS"] = str_replace(
								array("{plus_filter}"),
								array($arParams["TAG_FILTER"]),
								$arParams["META_KEYWORDS"]);
		
		$APPLICATION->SetPageProperty("keywords", $arParams["META_KEYWORDS"]);
	}

	//description
	if(isset($arParams["META_DESCRIPTION"])){
		$arParams["META_DESCRIPTION"] = str_replace(
								array("{plus_filter}"),
								array($arParams["TAG_FILTER"]),
								$arParams["META_DESCRIPTION"]);
								
		$APPLICATION->SetPageProperty("description", $arParams["META_DESCRIPTION"]);
	}
	
	// описание в метках
	if(isset($arParams["TAG_TEXT"])){
		$arParams["TAG_TEXT"] = str_replace(
								array("{name}", "{region}", ),
								array(mb_lcfirst($arParams["TAG_NAME"]) . " " . $arParams["TAG_FILTER"] , (Regions::is_region() ? " в " . Regions::get_name_case_region(5) : "")),
								$arParams["TAG_TEXT"]);
	}
	echo $arParams["TAG_TEXT"];
?>