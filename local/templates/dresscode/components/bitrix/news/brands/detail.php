<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?global $APPLICATION;?>

<?
if(!empty($arResult["VARIABLES"]["ELEMENT_CODE"])){
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_TEXT", "DETAIL_PICTURE", "SECTION_PAGE_URL");
	$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "=CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	if($ob = $res->GetNextElement()){
		$arResult["ITEM"] = $ob->GetFields();
		$ELEMENT_ID = $arResult["ITEM"]["ID"];
		$ELEMENT_NAME = $arResult["ITEM"]["NAME"];
	}
}
?>



<?if(!empty($ELEMENT_ID)):?>
	<?$BASE_PRICE = CCatalogGroup::GetBaseGroup();?>
	<?$arSortFields = array(
		"SHOWS" => array(
			"ORDER"=> "DESC",
			"CODE" => "SHOWS",
			"NAME" => GetMessage("CATALOG_SORT_FIELD_SHOWS")
		),
		"NAME" => array( // параметр в url
			"ORDER"=> "ASC", //в возрастающем порядке
			"CODE" => "NAME", // Код поля для сортировки
			"NAME" => GetMessage("CATALOG_SORT_FIELD_NAME") // имя для вывода в публичной части, редактировать в (/lang/ru/section.php)
		),
		"PRICE_ASC"=> array(
			"ORDER"=> "ASC",
			"CODE" => "PROPERTY_MINIMUM_PRICE",  // изменен для сортировки по ТП
			"NAME" => GetMessage("CATALOG_SORT_FIELD_PRICE_ASC")
		),
		"PRICE_DESC" => array(
			"ORDER"=> "DESC",
			"CODE" => "PROPERTY_MAXIMUM_PRICE", // изменен для сортировки по ТП
			"NAME" => GetMessage("CATALOG_SORT_FIELD_PRICE_DESC")
		)
	);?>

	<?
		//get template settings
		$arTemplateSettings = DwSettings::getInstance()->getCurrentSettings();
		if(empty($arTemplateSettings["TEMPLATE_USE_AUTO_SAVE_PRICE"]) || $arTemplateSettings["TEMPLATE_USE_AUTO_SAVE_PRICE"] == "N"){
			$arSortFields["PRICE_ASC"] = array(
				"ORDER"=> "ASC",
				"CODE" => "CATALOG_PRICE_".$BASE_PRICE["ID"],
				"NAME" => GetMessage("CATALOG_SORT_FIELD_PRICE_ASC")
			);
			$arSortFields["PRICE_DESC"] = array(
				"ORDER"=> "DESC",
				"CODE" => "CATALOG_PRICE_".$BASE_PRICE["ID"],
				"NAME" => GetMessage("CATALOG_SORT_FIELD_PRICE_DESC")
			);
		}
	?>

	<?if(!empty($_REQUEST["SORT_FIELD"]) && !empty($arSortFields[$_REQUEST["SORT_FIELD"]])){

		setcookie("CATALOG_SORT_FIELD", $_REQUEST["SORT_FIELD"], time() + 60 * 60 * 24 * 30 * 12 * 2, "/");

		$arParams["ELEMENT_SORT_FIELD"] = $arSortFields[$_REQUEST["SORT_FIELD"]]["CODE"];
		$arParams["ELEMENT_SORT_ORDER"] = $arSortFields[$_REQUEST["SORT_FIELD"]]["ORDER"];

		$arSortFields[$_REQUEST["SORT_FIELD"]]["SELECTED"] = "Y";

	}elseif(!empty($_COOKIE["CATALOG_SORT_FIELD"]) && !empty($arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]])){ // COOKIE

		$arParams["ELEMENT_SORT_FIELD"] = $arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["CODE"];
		$arParams["ELEMENT_SORT_ORDER"] = $arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["ORDER"];

		$arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["SELECTED"] = "Y";
	}
	?>

	<?$arSortProductNumber = array(
		30 => array("NAME" => 30),
		60 => array("NAME" => 60),
		90 => array("NAME" => 90)
	);?>

	<?if(!empty($_REQUEST["SORT_TO"]) && $arSortProductNumber[$_REQUEST["SORT_TO"]]){
		setcookie("CATALOG_SORT_TO", $_REQUEST["SORT_TO"], time() + 60 * 60 * 24 * 30 * 12 * 2, "/");
		$arSortProductNumber[$_REQUEST["SORT_TO"]]["SELECTED"] = "Y";
		$arParams["PAGE_ELEMENT_COUNT"] = $_REQUEST["SORT_TO"];
	}elseif (!empty($_COOKIE["CATALOG_SORT_TO"]) && $arSortProductNumber[$_COOKIE["CATALOG_SORT_TO"]]){
		$arSortProductNumber[$_COOKIE["CATALOG_SORT_TO"]]["SELECTED"] = "Y";
		$arParams["PAGE_ELEMENT_COUNT"] = $_COOKIE["CATALOG_SORT_TO"];
	}?>

	<?$arTemplates = array(
		"SQUARES" => array(
			"CLASS" => "squares"
		),
		"LINE" => array(
			"CLASS" => "line"
		),
		"TABLE" => array(
			"CLASS" => "table"
		)
	);?>

	<?if(!empty($_REQUEST["VIEW"]) && $arTemplates[$_REQUEST["VIEW"]]){
		setcookie("CATALOG_VIEW", $_REQUEST["VIEW"], time() + 60 * 60 * 24 * 30 * 12 * 2);
		$arTemplates[$_REQUEST["VIEW"]]["SELECTED"] = "Y";
		$arParams["CATALOG_TEMPLATE"] = $_REQUEST["VIEW"];
	}elseif (!empty($_COOKIE["CATALOG_VIEW"]) && $arTemplates[$_COOKIE["CATALOG_VIEW"]]){
		$arTemplates[$_COOKIE["CATALOG_VIEW"]]["SELECTED"] = "Y";
		$arParams["CATALOG_TEMPLATE"] = $_COOKIE["CATALOG_VIEW"];
	}else{
		$arTemplates[key($arTemplates)]["SELECTED"] = "Y";
	}
	?>


	<?//$BIG_PICTURE = CFile::ResizeImageGet($arResult["ITEM"]["DETAIL_PICTURE"], array("width" => 150, "height" => 250), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

	<?/* if(!empty($BIG_PICTURE["src"])):?>
		<div class="brandsBigPicture"><img src="<?=$BIG_PICTURE["src"]?>" alt="<?=$arResult["ITEM"]["NAME"]?>"></div>
	<?endif; */?>


	<?

		//filter for component
		global $arrFilter;
		$arrFilter["PROPERTY_ATT_BRAND"] = $ELEMENT_ID;
		$arrFilter["IBLOCK_ID"] = $arParams["PRODUCT_IBLOCK_ID"];
		$arrFilter["ACTIVE"] = "Y";

		//filter for calc
		$arFilter = array(
			"IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"],
			"PROPERTY_ATT_BRAND" => $ELEMENT_ID,
			"ACTIVE" => "Y"
		);

		if($arParams["HIDE_NOT_AVAILABLE"] == "Y"){
			$arFilter["CATALOG_AVAILABLE"] = "Y";
		}

		$countElements = CIBlockElement::GetList(array(), $arrFilter, array(), false);

	?>
		<?if($countElements > 1){

			$arSections = array();
			$arResult["MENU_SECTIONS"] = array();
			$arFilter["SECTION_ID"] = array();

			$res = CIBlockElement::GetList(array("NAME" => "ASC"), $arFilter, false, false, array("ID"));
			while($nextElement = $res->GetNext()){
				$resGroup = CIBlockElement::GetElementGroups($nextElement["ID"], false);
				while($arGroup = $resGroup->Fetch()){
					if($arGroup["ACTIVE"] == "Y"){
						$IBLOCK_SECTION_ID = $arGroup["ID"];
						$arSections[$IBLOCK_SECTION_ID] = $IBLOCK_SECTION_ID;
						$arSectionCount[$IBLOCK_SECTION_ID] = !empty($arSectionCount[$IBLOCK_SECTION_ID]) ? $arSectionCount[$IBLOCK_SECTION_ID] + 1 : 1;
					}
				}

				$arResult["ITEMS"][] = $nextElement;
			}

			if(!empty($arSections)){
				$arFilter = array("ID" => $arSections);
				$rsSections = CIBlockSection::GetList(array("NAME" => "ASC"), $arFilter);
				while ($arSection = $rsSections->Fetch()){
					$searchParam = "SECTION_ID=".$arSection["ID"];
					$searchID = intval($_GET["SECTION_ID"]);
					if($arSection["ID"] == $searchID){
						$arSection["SELECTED"] = "Y";
						$arResult['CURRENT_SECTION_CATALOG'] = $arSection['NAME'];
						$arResult['CURRENT_SECTION_CATALOG_CODE'] = $arSection['CODE'];
					}else{
						$arSection["SELECTED"] = "N";
					}					
					$arSection["FILTER_LINK"] = $APPLICATION->GetCurPage(false) . "?" . $searchParam;//$APPLICATION->GetCurPageParam($searchParam , array("SECTION_ID"));
					$arSection["ELEMENTS_COUNT"] = $arSectionCount[$arSection["ID"]];
					array_push($arResult["MENU_SECTIONS"], $arSection);
				}
			}

		}?>
		<?if($countElements > 1):?>
			<?$this->SetViewTarget("menuRollClass");?> menuRolled<?$this->EndViewTarget();?>
			<?$this->SetViewTarget("hiddenZoneClass");?> hiddenZone<?$this->EndViewTarget();?>
		<?endif;?>

		<?
			$this->SetViewTarget("smartFilter");
	    ?>

		<?
			$OPTION_CURRENCY  = CCurrency::GetBaseCurrency();
		?>

		<?if(!empty($arResult["MENU_SECTIONS"]) && count($arResult["MENU_SECTIONS"]) > 1):?>
			<div id="nextSection">
				<span class="title"><?=GetMessage("SELECT_CATEGORY");?></span>
				<ul>
					<?foreach ($arResult["MENU_SECTIONS"] as $ic => $arSection):?>
						<li><a href="<?=$arSection["FILTER_LINK"]?>"<?if($arSection["SELECTED"] == "Y"):?> class="selected"<?endif;?>><?=$arSection["NAME"]?> <?=$ELEMENT_NAME?> (<?=$arSection["ELEMENTS_COUNT"]?>)</a></li>
					<?endforeach;?>
				</ul>
			</div>
		<?endif;?>

		<?if($countElements > 1):?>
			<?$APPLICATION->IncludeComponent(
	"dresscode:cast.smart.filter", 
	".default", 
	array(
		"IBLOCK_TYPE" => $arParams["PRODUCT_IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"FILTER_NAME" => $arParams["PRODUCT_FILTER_NAME"],
		"HIDE_NOT_AVAILABLE" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"INSTANT_RELOAD" => "N",
		"PRICE_CODE" => array(
		),
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "-",
		"SECTION_DESCRIPTION" => "-",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => $arParams["PRODUCT_CURRENCY_ID"],
		"FILTER_ADD_PROPERTY_NAME" => "ATT_BRAND",
		"FILTER_ADD_PROPERTY_VALUE" => $ELEMENT_ID,
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_MODE" => "N",
		"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"PAGER_PARAMS_NAME" => "arrPager",
		"CURRENT_SECTION_CATALOG" => $arResult["CURRENT_SECTION_CATALOG"]
	),
	false
);?>
		<?endif;?>
		<?
			$this->EndViewTarget();
		?>

	<?if($countElements):?>
		<div id="catalog">
			<h1 class="brandsHeading"><?$APPLICATION->ShowViewContent('h1');?></h1>
			
			<?$arTags = $APPLICATION->IncludeComponent(
				"dresscode:catalog.tags",
				"",
				array(
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"IBLOCK_TYPE" => $arParams["PRODUCT_IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"],
					"SEF_FOLDER" => "/catalog/",
					"SEF_URL_TEMPLATES" => "#SECTION_CODE#/",
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"SECTION_CODE" => $arResult['CURRENT_SECTION_CATALOG_CODE'],
					"SECTION_CODE_PATH" => $arResult["VARIABLES"]["SECTION_CODE_PATH"],
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"USE_IBLOCK_MAIN_SECTION" => $arParams["CATALOG_TAGS_USE_IBLOCK_MAIN_SECTION"],
					"USE_IBLOCK_MAIN_SECTION_TREE" => $arParams["CATALOG_TAGS_USE_IBLOCK_MAIN_SECTION_TREE"],
					"CURRENT_TAG" => $arResult["VARIABLES"]["TAG"],
					"MESSAGE_404" => $arParams["MESSAGE_404"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"SHOW_404" => $arParams["SHOW_404"],
					"FILE_404" => $arParams["FILE_404"],
					"MAX_TAGS" => $arParams["CATALOG_MAX_TAGS"],
					"SECTION_DEPTH_LEVEL" => $arCurSection["DEPTH_LEVEL"],
					"TAGS_MAX_DEPTH_LEVEL" => $arParams["CATALOG_TAGS_MAX_DEPTH_LEVEL"],
					"MAX_VISIBLE_TAGS_DESKTOP" => $arParams["CATALOG_MAX_VISIBLE_TAGS_DESKTOP"],
					"MAX_VISIBLE_TAGS_MOBILE" => $arParams["CATALOG_MAX_VISIBLE_TAGS_MOBILE"],
					"HIDE_TAGS_ON_MOBILE" => $arParams["CATALOG_HIDE_TAGS_ON_MOBILE"],
					"SORT_FIELD" => $arParams["CATALOG_TAGS_SORT_FIELD"],
					"SORT_TYPE" => $arParams["CATALOG_TAGS_SORT_TYPE"],
				),
				false,
				array("HIDE_ICONS" => "Y", "ACTIVE_COMPONENT" => "Y")
			);?>
			
			<div id="catalogLine">
				<?if($countElements > 1):?>
					<div class="column oFilter">
						<a href="#" class="oSmartFilter btn-simple btn-micro"><span class="ico"></span><?=GetMessage("CATALOG_FILTER")?></a>
					</div>
				<?endif;?>
		        <?if(!empty($arSortFields)):?>
		            <div class="column">
		                <div class="label">
		                    <?=GetMessage("CATALOG_SORT_LABEL");?>
		                </div>
		                <div class="dropDownList sortFields panel-change" id="selectSortParams">
		                    <?
		                        //check selected item
		                        foreach($arSortFields as $arSortField){
		                            if($arSortField["SELECTED"] == "Y"){
		                                $arSortSelected = $arSortField;
		                            }
		                        }
		                        //check found selected item
		                        if(empty($arSortSelected)){
		                            $selectItemIndex = array_key_first($arSortFields);
		                            $arSortSelected = $arSortFields[$selectItemIndex];
		                            $arSortFields[$selectItemIndex]["SELECTED"] = "Y";
		                        }
		                    ?>
		                    <?if(!empty($arSortSelected)):?>
		                        <div class="dropDownSelected"><?=$arSortSelected["NAME"]?></div>
		                    <?endif;?>
		                    <div class="dropDownItems">
		                        <?foreach($arSortFields as $arSortFieldCode => $arSortField):?>
		                            <div class="dropDownItem<?if($arSortField["SELECTED"] == "Y"):?> selected<?endif;?>" data-value="<?=$APPLICATION->GetCurPageParam("SORT_FIELD=".$arSortFieldCode, array("SORT_FIELD"));?>"><?=$arSortField["NAME"]?></div>
		                        <?endforeach;?>
		                    </div>
		                </div>
		            </div>
		        <?endif;?>
		        <?if(!empty($arSortProductNumber)):?>
		            <div class="column">
		                <div class="label">
		                    <?=GetMessage("CATALOG_SORT_TO_LABEL");?>
		                </div>
		                 <div class="dropDownList countElements panel-change" id="selectCountElements">
		                     <?
		                        //check selected item
		                        foreach($arSortProductNumber as $arSortNumberElement){
		                            if($arSortNumberElement["SELECTED"] == "Y"){
		                                $arNumberSelected = $arSortNumberElement;
		                            }
		                        }
		                        //check found selected item
		                        if(empty($arNumberSelected)){
		                            $selectItemIndex = array_key_first($arSortProductNumber);
		                            $arNumberSelected = $arSortProductNumber[$selectItemIndex];
		                            $arSortProductNumber[$selectItemIndex]["SELECTED"] = "Y";
		                        }
		                    ?>
		                    <?if(!empty($arNumberSelected)):?>
		                        <div class="dropDownSelected"><?=$arNumberSelected["NAME"]?></div>
		                    <?endif;?>
		                    <div class="dropDownItems">
		                        <?foreach($arSortProductNumber as $arSortNumberElementId => $arSortNumberElement):?>
		                            <div class="dropDownItem<?if($arSortNumberElement["SELECTED"] == "Y"):?> selected<?endif;?>" data-value="<?=$APPLICATION->GetCurPageParam("SORT_TO=".$arSortNumberElementId, array("SORT_TO"));?>"><?=$arSortNumberElement["NAME"]?></div>
		                        <?endforeach;?>
		                    </div>
		                </div>
		            </div>
		         <?endif;?>
				<?if(!empty($arTemplates)):?>
					<div class="column">
						<div class="label">
							<?=GetMessage("CATALOG_VIEW_LABEL");?>
						</div>
						<div class="viewList">
							<?foreach ($arTemplates as $arTemplatesCode => $arNextTemplate):?>
								<div class="element"><a<?if($arNextTemplate["SELECTED"] != "Y"):?> href="<?=$APPLICATION->GetCurPageParam("VIEW=".$arTemplatesCode, array("VIEW"));?>"<?endif;?> class="<?=$arNextTemplate["CLASS"]?><?if($arNextTemplate["SELECTED"] == "Y"):?> selected<?endif;?>"></a></div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
			</div>
			<?
				reset($arTemplates);

				global $arrFilter;
				unset($arrFilter["FACET_OPTIONS"]);

				$arrFilter["FACET_OPTIONS"] = array();
				$_REQUEST["SECTION_ID"] = !empty($_REQUEST["SECTION_ID"]) ? $_REQUEST["SECTION_ID"] : 0;

			?>
			<?$APPLICATION->IncludeComponent(
				"dresscode:catalog.section",
				 !empty($arParams["CATALOG_TEMPLATE"]) ? strtolower($arParams["CATALOG_TEMPLATE"]) : strtolower(key($arTemplates)),
				array(
					"IBLOCK_TYPE" => $arParams["PRODUCT_IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"INCLUDE_SUBSECTIONS" => "N",
					"FILTER_NAME" => $arParams["PRODUCT_FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRODUCT_PRICE_CODE"],
					"PROPERTY_CODE" => $arParams["PRODUCT_PROPERTY_CODE"],
					"PAGER_TEMPLATE" => "round",
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"CONVERT_CURRENCY" => $arParams["PRODUCT_CONVERT_CURRENCY"],
					"CURRENCY_ID" => $arParams["PRODUCT_CURRENCY_ID"],
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"HIDE_MEASURES" => $arParams["HIDE_MEASURES"],
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"HIDE_DESCRIPTION_TEXT" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"ENABLED_SKU_FILTER" => "Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"SET_BROWSER_TITLE" => "N",
					"SET_TITLE" => "N",
					"CACHE_FILTER" => "N",
					"CACHE_TYPE" => "Y",
					"AJAX_MODE" => "N"
				),
				$component
			);?>
		</div>
			<?if(!empty($arResult["ITEM"]["DETAIL_TEXT"])):?>
		<div class="sectionTopDescription"><?$APPLICATION->ShowViewContent('DETAIL_TEXT');?></div>
	<?endif;?>

	<a href="<?=$arResult["FOLDER"]?>" class="backToList"><?=GetMessage("BACK_TO_LIST_PAGE")?></a>
	<?else:?>
		<style>
			.backToList{
				display: inline-block;
				margin-bottom: 24px;
				float: none;
			}
		</style>
	<?endif;?>
<?else:?>

	<?
		if (!defined("ERROR_404"))
		   define("ERROR_404", "Y");

		\CHTTP::setStatus("404 Not Found");

		if ($APPLICATION->RestartWorkarea()) {
		   require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		   die();
		}
	?>

<?endif;?>

<?global $FilterResult;?>
<?
if(CModule::IncludeModule("iblock")){
	if(!empty($ELEMENT_ID)){

		$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(
		    $arParams["IBLOCK_ID"],
		    $ELEMENT_ID
		);

		if($arSeoProp = $ipropValues->getValues()){
			
			if(count($FilterResult['CHECKED'])){
				foreach($FilterResult['CHECKED'] as $item){					
					$plusFilter .=" ". $item["FILTER_HINT"] . " " . implode(', ', $item['VALUE']);
				}unset($item);
			}
			// установка title у брендов при фильтрации и без
			if(!empty($arSeoProp["ELEMENT_META_TITLE"])){				
				if($arResult['CURRENT_SECTION_CATALOG']){
					$title = str_replace(
								array("{currnt_section_section}", "{plus_filter}"),
								array($arResult['CURRENT_SECTION_CATALOG'], $plusFilter),
								$arSeoProp["ELEMENT_META_TITLE"]);
				}else{ 
					$title = str_replace(array("{currnt_section_section}", "{plus_filter}"), array("Ножи ", ""), $arSeoProp["ELEMENT_META_TITLE"]);
				}
			
				$APPLICATION->SetTitle($title);
			}
			
			// установка description у брендов при фильтрации и без
			if($arResult['CURRENT_SECTION_CATALOG']){
				$description = str_replace(
					array("{currnt_section_section}", "{plus_filter}"),
					array($arResult['CURRENT_SECTION_CATALOG'], $plusFilter),
					$arSeoProp["ELEMENT_META_DESCRIPTION"]);
			}else{ 
				$description = str_replace(array("{currnt_section_section}", "{plus_filter}"), array("Ножи ", ""), $arSeoProp["ELEMENT_META_DESCRIPTION"]);
			}			
			$APPLICATION->SetPageProperty("description", $description);unset($description);
			
			// установка keywords у брендов при фильтрации и без			
			if($arResult['CURRENT_SECTION_CATALOG']){
				$keywords = str_replace(
								array("{currnt_section_section}", "{plus_filter}"),
								array($arResult['CURRENT_SECTION_CATALOG'], $plusFilter),
								$arSeoProp["ELEMENT_META_KEYWORDS"]);
			}else{  
				$keywords = str_replace(array("{currnt_section_section}", "{plus_filter}"), array("Ножи ", ""), $arSeoProp["ELEMENT_META_KEYWORDS"]);
			}			
			$APPLICATION->SetPageProperty("keywords", $keywords);
			
			// установка хлебных крошек у брендов при фильтрации и без
			if(!empty($arSeoProp["ELEMENT_PAGE_TITLE"])){				
				if($arResult['CURRENT_SECTION_CATALOG']){
					$h1 = str_replace(
						array("{currnt_section_section}", "{plus_filter}"),
						array($arResult['CURRENT_SECTION_CATALOG'], $plusFilter),
						$arSeoProp["ELEMENT_PAGE_TITLE"]);
				}else{
					$h1 = str_replace(array("{currnt_section_section}", "{plus_filter}"), array("Ножи ", ""), $arSeoProp["ELEMENT_PAGE_TITLE"]);
				}
				$APPLICATION->AddChainItem($h1);?>
				<?$this->SetViewTarget("h1");?><?=$h1?><?$this->EndViewTarget();?>
				
			<?}

		}else{
			$APPLICATION->AddChainItem($ELEMENT_NAME);
			$APPLICATION->SetTitle($ELEMENT_NAME);
		}
		
		// замена в описании бренда с фильтрацией и без
		foreach($FilterResult['CHECKED'] as $key => $item){					
			$tempfilter[] = 
							array("ID" => CIBlockElement::SubQuery(
								"PROPERTY_96",
								array("IBLOCK_ID" => 16, "PROPERTY_".$key => $item["VALUES"])								
							));					
		}unset($item); 
		
		$filter = array("IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"], "SECTION_ID" => $_REQUEST["SECTION_ID"], "ACTIVE" => "Y",
			Array
			(
				"LOGIC" => "AND",
				Array
					(
						"LOGIC" => "OR",
						$tempfilter
					),

				Array
					(
						"LOGIC" => "OR",
						Array
							(
								"PROPERTY_ATT_BRAND" => $arrFilter['PROPERTY_ATT_BRAND']
							)

					)

			)	
		); 
		$dbElements = CIBlockElement::GetList(array('PRICE_1'=>'ASC'),
				$filter
				,false
				,false
				,array("IBLOCK_ID","ID", "NAME","PRICE_1")
			);
		while($arrElement = $dbElements->Fetch()){
			$arMinPrice[] = $arrElement['PRICE_1'];
		}
		unset($dbElements, $arrElement);	
		$arResult["ITEM"]["DETAIL_TEXT"] = str_replace(
			array("{currnt_section_section}", "{plus_filter}", "{brand_name}", "{count_item}", "{min_price}"),
			array($arResult['CURRENT_SECTION_CATALOG'], $plusFilter, $ELEMENT_NAME, count($arMinPrice), count($arMinPrice) == 1 ? array_shift($arMinPrice) . " руб." : "от " . array_shift($arMinPrice) . " руб."), $arResult["ITEM"]["DETAIL_TEXT"]);unset($arMinPrice);?>
		<?$this->SetViewTarget("DETAIL_TEXT");?><?=$arResult["ITEM"]["DETAIL_TEXT"]?><?$this->EndViewTarget();?>
		
	<?}
}
?>