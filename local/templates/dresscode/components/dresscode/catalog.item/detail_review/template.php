<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	//comp mode
	$this->setFrameMode(false);
	//css
	$this->addExternalCss($templateFolder."/css/review.css");
	$this->addExternalCss($templateFolder."/css/media.css");
	$this->addExternalCss($templateFolder."/css/set.css");
	//js
	$this->addExternalJS($templateFolder."/js/tags.js");
	$this->addExternalJS($templateFolder."/js/plus.js");
	$this->addExternalJS($templateFolder."/js/tabs.js");
	$this->addExternalJS($templateFolder."/js/sku.js");
	//global vars
	global $USER, $relatedFilter, $similarFilter, $servicesFilter;
	//other
	$arParams["COUNT_TOP_PROPERTIES"] = !empty($arParams["COUNT_TOP_PROPERTIES"]) ? $arParams["COUNT_TOP_PROPERTIES"] : 7;
	$arParams["DISABLE_PRINT_WEIGHT"] = !empty($arParams["DISABLE_PRINT_WEIGHT"]) ? $arParams["DISABLE_PRINT_WEIGHT"] : "N";
	$arParams["DISABLE_PRINT_DIMENSIONS"] = !empty($arParams["DISABLE_PRINT_DIMENSIONS"]) ? $arParams["DISABLE_PRINT_DIMENSIONS"] : "N";
	$morePhotoCounter = 0;
	$propertyCounter = 0;
	$uniqID = CAjax::GetComponentID($this->__component->__name, $this->__component->__template->__name, false);
	//edit
	if(!empty($arResult["PARENT_PRODUCT"]["EDIT_LINK"])){
		$this->AddEditAction($arResult["ID"], $arResult["PARENT_PRODUCT"]["EDIT_LINK"], CIBlock::GetArrayByID($arResult["PARENT_PRODUCT"]["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arResult["ID"], $arResult["PARENT_PRODUCT"]["DELETE_LINK"], CIBlock::GetArrayByID($arResult["PARENT_PRODUCT"]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
	}
	if(!empty($arResult["EDIT_LINK"])){
		$this->AddEditAction($arResult["ID"], $arResult["EDIT_LINK"], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arResult["ID"], $arResult["DELETE_LINK"], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
	}
?>

<div id="<?=$this->GetEditAreaId($arResult["ID"]);?>">
	<?$this->SetViewTarget("after_breadcrumb_container");?>
		<h1 class="changeName">Обзор часов <?=$arResult["BRAND"]["NAME"]?> <?=$arResult['PROPERTIES']["SHORT_NAME"]["VALUE"]?></h1>
	<?$this->EndViewTarget();?>
	<div id="catalogElement" class="item<?if(!empty($arResult["SKU_OFFERS"])):?> elementSku<?endif;?>" data-product-iblock-id="<?=$arParams["IBLOCK_ID"]?>" data-from-cache="<?=$arResult["FROM_CACHE"]?>" data-convert-currency="<?=$arParams["CONVERT_CURRENCY"]?>" data-currency-id="<?=$arParams["CURRENCY_ID"]?>" data-hide-not-available="<?=$arParams["HIDE_NOT_AVAILABLE"]?>" data-currency="<?=$arResult["EXTRA_SETTINGS"]["CURRENCY"]?>" data-product-id="<?=!empty($arResult["~ID"]) ? $arResult["~ID"] : $arResult["ID"]?>" data-iblock-id="<?=$arResult["SKU_INFO"]["IBLOCK_ID"]?>" data-prop-id="<?=$arResult["SKU_INFO"]["SKU_PROPERTY_ID"]?>" data-hide-measure="<?=$arParams["HIDE_MEASURES"]?>" data-price-code="<?=implode("||", $arParams["PRODUCT_PRICE_CODE"])?>" data-deactivated="<?=$arParams["SHOW_DEACTIVATED"]?>">
		<div id="elementSmallNavigation">
			<?if(!empty($arResult["TABS"])):?>
				<div class="tabs">
					<?foreach ($arResult["TABS"] as $it => $arTab):?>
						<div class="tab"><a href="<?if(!empty($arTab["LINK"])):?><?=$arTab["LINK"]?><?else:?>#<?endif;?>"><span><?=$arTab["NAME"]?></span></a></div>
					<?endforeach;?>
				</div>
			<?endif;?>
		</div>
		<div id="tableContainer">
			<div id="elementNavigation" class="column">
				<?if(!empty($arResult["TABS"])):?>
					<div class="tabs">
						<?foreach ($arResult["TABS"] as $it => $arTab):?>
							<div class="tab"><a href="<?if(!empty($arTab["LINK"])):?><?=$arTab["LINK"]?><?else:?>#<?endif;?>"><?=$arTab["NAME"]?><img src="<?=$arTab["PICTURE"]?>" alt="<?=$arTab["NAME"]?>"></a></div>
						<?endforeach;?>
					</div>
				<?endif;?>
			</div>
			<div id="elementContainer" class="column">	
				<div class="mainContainer" id="browse">
					<div class="col">
						<?$APPLICATION->IncludeComponent(
							"dresscode:catalog.product.offers",
							"detail",
							array(
								"DISPLAY_PICTURE_COLUMN" => $arParams["OFFERS_TABLE_DISPLAY_PICTURE_COLUMN"],
								"NAV_COUNT_ELEMENTS" => $arParams["OFFERS_TABLE_PAGER_COUNT"],
								"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
								"PRODUCT_PRICE_CODE" => $arParams["PRODUCT_PRICE_CODE"],
								"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
								"PRODUCT_ID" => $arResult["PARENT_PRODUCT"]["ID"],
								"HIDE_MEASURES" => $arParams["HIDE_MEASURES"],
								"CURRENCY_ID" => $arParams["CURRENCY_ID"],
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"PAGER_TEMPLATE" => "round",
								"PAGER_NAV_HEADING" => "",
								"PICTURE_HEIGHT" => "50",
								"PICTURE_WIDTH" => "50",
							),
							false
						);?>					
						<?if(!empty($arResult["VIDEO"])):?>
							<div id="video">
								<div class="wrap">
									<div class="items sz<?=count($arResult["VIDEO"])?>">
										<?foreach ($arResult["VIDEO"] as $ivp => $videoValue):?>
											<div class="item">
												<iframe src="<?=$videoValue?>" allowfullscreen class="videoFrame"></iframe>
											</div>
										<?endforeach;?>
									</div>
								</div>
							</div>
						<?endif;?>	
					</div>				
				</div>				
				<?if(!empty($arResult["ELEMENT_TAGS"]) && !empty($arParams["CATALOG_SHOW_TAGS"]) && $arParams["CATALOG_SHOW_TAGS"] == "Y"):?>
					<?$index = 1;?>
					<div id="detailTags"<?if($arParams["HIDE_TAGS_ON_MOBILE"] == "Y"):?> class="mobileHidden"<?endif;?>>
						<h2 class="heading"><?=GetMessage("CATALOG_ELEMENT_DETAIL_TAGS_HEADING")?></h2>
						<div class="detailTagsItems">
							<?foreach($arResult["ELEMENT_TAGS"] as $tagIndex => $nextTag):?>
								<div class="detailTagsItem<?if($arParams["MAX_VISIBLE_TAGS_DESKTOP"] < $index):?> desktopHidden<?endif;?><?if($arParams["MAX_VISIBLE_TAGS_MOBILE"] < $index):?> mobileHidden<?endif;?>">
									<a href="<?=$nextTag["LINK"]?>" class="detailTagsLink<?if(!empty($nextTag["SELECTED"]) && $nextTag["SELECTED"] == "Y"):?> selected<?endif;?>"><?=$nextTag["NAME"]?><?if(!empty($nextTag["SELECTED"]) && $nextTag["SELECTED"] == "Y"):?><span class="reset">&#10006;</span><?endif;?></a>
								</div>
								<?$index++;?>
							<?endforeach;?>
							<?if(count($arResult["ELEMENT_TAGS"]) > $arParams["MAX_VISIBLE_TAGS_MOBILE"] || count($arResult["ELEMENT_TAGS"]) > $arParams["MAX_VISIBLE_TAGS_DESKTOP"]):?>
								<div class="detailTagsItem moreButton<?if($arParams["MAX_VISIBLE_TAGS_DESKTOP"] > count($arResult["ELEMENT_TAGS"])):?> desktopHidden<?endif;?><?if($arParams["MAX_VISIBLE_TAGS_MOBILE"] > count($arResult["ELEMENT_TAGS"])):?> mobileHidden<?endif;?>"><a href="#" class="detailTagsLink moreButtonLink" data-last-label="<?=GetMessage("CATALOG_ELEMENT_TAGS_MORE_BUTTON_HIDE");?>"><?=GetMessage("CATALOG_ELEMENT_TAGS_MORE_BUTTON")?></a></div>
							<?endif;?>
						</div>
					</div>
				<?endif;?>		        
				<?if($arResult["SHOW_SIMILAR"] == "Y"):?>
		        	<div id="similar">
						<h2 class="heading">Обзоры похожих часов</h2>
						<?$APPLICATION->IncludeComponent(
							"dresscode:catalog.section", 
							"squares_char", 
							array(
								"IBLOCK_TYPE" => "catalog",
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"CONVERT_CURRENCY" => "Y",
								"CURRENCY_ID" => $arResult["EXTRA_SETTINGS"]["CURRENCY"],
								"ADD_SECTIONS_CHAIN" => "N",
								"COMPONENT_TEMPLATE" => "squares",
								"SECTION_ID" => $_REQUEST["SECTION_ID"],
								"SECTION_CODE" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"ELEMENT_SORT_FIELD" => "rand",
								"ELEMENT_SORT_ORDER" => "asc",
								"ELEMENT_SORT_FIELD2" => "rand",
								"ELEMENT_SORT_ORDER2" => "desc",
								"FILTER_NAME" => "similarFilter",
								"INCLUDE_SUBSECTIONS" => "Y",
								"SHOW_ALL_WO_SECTION" => "Y",
								"HIDE_NOT_AVAILABLE" => "Y",
								"PAGE_ELEMENT_COUNT" => "30",
								"LINE_ELEMENT_COUNT" => "3",
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "",
								),
								"OFFERS_LIMIT" => "1",
								"BACKGROUND_IMAGE" => "-",
								"SECTION_URL" => "",
								"DETAIL_URL" => "",
								"SECTION_ID_VARIABLE" => "SECTION_ID",
								"SEF_MODE" => "N",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_ADDITIONAL" => "undefined",
								"CACHE_TYPE" => "Y",
								"CACHE_TIME" => "36000000",
								"CACHE_GROUPS" => "Y",
								"SET_TITLE" => "N",
								"SET_BROWSER_TITLE" => "N",
								"BROWSER_TITLE" => "-",
								"SET_META_KEYWORDS" => "N",
								"META_KEYWORDS" => "-",
								"SET_META_DESCRIPTION" => "N",
								"META_DESCRIPTION" => "-",
								"SET_LAST_MODIFIED" => "N",
								"USE_MAIN_ELEMENT_SECTION" => "N",
								"CACHE_FILTER" => "Y",
								"ACTION_VARIABLE" => "action",
								"PRODUCT_ID_VARIABLE" => "id",
								"PRICE_CODE" => array(
								),
								"USE_PRICE_COUNT" => "N",
								"SHOW_PRICE_COUNT" => "1",
								"PRICE_VAT_INCLUDE" => "Y",
								"BASKET_URL" => "/personal/basket.php",
								"USE_PRODUCT_QUANTITY" => "N",
								"PRODUCT_QUANTITY_VARIABLE" => "undefined",
								"ADD_PROPERTIES_TO_BASKET" => "Y",
								"PRODUCT_PROPS_VARIABLE" => "prop",
								"PARTIAL_PRODUCT_PROPERTIES" => "N",
								"PRODUCT_PROPERTIES" => "",
								"PAGER_TEMPLATE" => "round",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "N",
								"PAGER_TITLE" => GetMessage("CATALOG_ELEMENT_SIMILAR"),
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"SET_STATUS_404" => "N",
								"SHOW_404" => "N",
								"MESSAGE_404" => "",
								"LAZY_LOAD_PICTURES" => "N",
								"HIDE_MEASURES" => "N",
								"DISABLE_INIT_JS_IN_COMPONENT" => "N",
								"TYPE" => "review"
							),
							false
						);?>
					</div>
				<?endif;?>				
			</div>			
		</div>
	</div>
</div>

<div id="elementError">
  <div id="elementErrorContainer">
    <span class="heading"><?=GetMessage("ERROR")?></span>
    <a href="#" id="elementErrorClose"></a>
    <p class="message"></p>
    <a href="#" class="close"><?=GetMessage("CLOSE")?></a>
  </div>
</div>
<div class="cheaper-product-name"><?=$arResult["NAME"]?></div>
<?if(!empty($arParams["DISPLAY_CHEAPER"]) && $arParams["DISPLAY_CHEAPER"] == "Y"):?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"modal",
		array(
			"CACHE_TIME" => "3600000",
			"CACHE_TYPE" => "Y",
			"CHAIN_ITEM_LINK" => "",
			"CHAIN_ITEM_TEXT" => "",
			"EDIT_URL" => "result_edit.php",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"LIST_URL" => "result_list.php",
			"SEF_MODE" => "N",
			"SUCCESS_URL" => "",
			"USE_EXTENDED_ERRORS" => "N",
			"WEB_FORM_ID" => $arParams["CHEAPER_FORM_ID"],
			"COMPONENT_TEMPLATE" => "modal",
			"MODAL_BUTTON_NAME" => "",
			"MODAL_BUTTON_CLASS_NAME" => "cheaper label hidden changeID".(empty($arResult["PRICE"]) || $arResult["CATALOG_AVAILABLE"] != "Y" ? " disabled" : ""),
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
<div itemscope itemtype="http://schema.org/Product" class="microdata">
	<meta itemprop="name" content="<?=$arResult["NAME"]?>" />
	<link itemprop="url" href="<?=$arResult["DETAIL_PAGE_URL"]?>" />
	<link itemprop="image" href="<?=$arResult["IMAGES"][0]["LARGE_IMAGE"]["SRC"]?>" />
	<meta itemprop="brand" content="<?=$arResult["BRAND"]["NAME"]?>" />
	<meta itemprop="model" content="<?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?>" />
	<meta itemprop="productID" content="<?=$arResult["ID"]?>" />
	<meta itemprop="category" content="<?=$arResult["SECTION"]["NAME"]?>" />
	<?if(!empty($arResult["PROPERTIES"]["RATING"]["VALUE"])):?>
		<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
			<meta itemprop="ratingValue" content="<?=$arResult["PROPERTIES"]["RATING"]["VALUE"]?>">
			<meta itemprop="reviewCount" content="<?=intval($arResult["PROPERTIES"]["VOTE_COUNT"]["VALUE"])?>">
		</div>
	<?endif;?>
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<meta itemprop="priceCurrency" content="<?=$arResult["EXTRA_SETTINGS"]["CURRENCY"]?>" />
		<meta itemprop="price" content="<?=$arResult["PRICE"]["DISCOUNT_PRICE"]?>" />
		<link itemprop="url" href="<?=$arResult["DETAIL_PAGE_URL"]?>" />
		<?if($arResult["CATALOG_QUANTITY"] > 0):?>
            <link itemprop="availability" href="http://schema.org/InStock">
        <?else:?>
       		<link itemprop="availability" href="http://schema.org/OutOfStock">
        <?endif;?>
	</div>
	<?if(!empty($arResult["PREVIEW_TEXT"])):?>
		<meta itemprop="description" content='<?=$arResult["PREVIEW_TEXT"]?>' />
	<?endif;?>
	<?if(empty($arResult["PREVIEW_TEXT"]) && !empty($arResult["DETAIL_TEXT"])):?>
		<meta itemprop="description" content='<?=$arResult["DETAIL_TEXT"]?>' />
	<?endif;?>
</div>

<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script src="//yastatic.net/share2/share.js" charset="utf-8"></script>
<script type="text/javascript">

	var CATALOG_LANG = {
		REVIEWS_HIDE: "<?=GetMessage("REVIEWS_HIDE")?>",
		REVIEWS_SHOW: "<?=GetMessage("REVIEWS_SHOW")?>",
		OLD_PRICE_LABEL: "<?=GetMessage("OLD_PRICE_LABEL")?>",
	};

	var elementAjaxPath = "<?=$templateFolder."/ajax.php"?>";
	var catalogVariables = <?=\Bitrix\Main\Web\Json::encode($arParams["CATALOG_VARIABLES"])?>;
	var sectionPathList = <?=\Bitrix\Main\Web\Json::encode($arResult["SECTION_PATH_LIST"])?>;
	var lastSection = <?=\Bitrix\Main\Web\Json::encode($arResult["LAST_SECTION"])?>;
	var countTopProperties = "<?=$arParams["COUNT_TOP_PROPERTIES"]?>";
	var disableDimensions = "<?=$arParams["DISABLE_PRINT_DIMENSIONS"]?>";
	var disableWeight = "<?=$arParams["DISABLE_PRINT_WEIGHT"]?>";
	var lastSectionId = "<?=$arResult["LAST_SECTION"]["ID"]?>";
	var _topMenuNoFixed = true;

</script>