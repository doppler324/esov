<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	//comp mode
	$this->setFrameMode(false);
	//css?>
	<?
	$this->AddEditAction("offers_".$arResult["ID"], $arResult["EDIT_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction("offers_".$arResult["ID"], $arResult["DELETE_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array());
?>
<div class="tableElem" id="<?=$this->GetEditAreaId("offers_".$arResult["ID"]);?>">
	<div class="tb">
		<div class="tc offersPicture">
			<img src="<?=$arResult["PICTURE"]["src"]?>" alt="<?=$arResult["NAME"]?>">
		</div>
		<div class="tc offersName"><a style="color:#000000;" href="<?=explode("?", $arResult["DETAIL_PAGE_URL"])[0]?>"><?=$arResult["NAME"]?></a></div>
		<?foreach ($arResult["PROPERTIES_FILTRED"] as $arNextPropertyFiltred):?>
			<div class="tc property"><?=$arNextPropertyFiltred["DISPLAY_VALUE"]?></div>
		<?endforeach;?>
		<div class="tc priceWrap">
			<?if(!empty($arResult["PRICE"])):?>
				<?if($arResult["EXTRA_SETTINGS"]["COUNT_PRICES"] > 1):?>
					<a class="price getPricesWindow" data-id="<?=$arResult["ID"]?>">
						<span class="priceIcon"></span><?=CCurrencyLang::CurrencyFormat($arResult["PRICE"]["DISCOUNT_PRICE"], $arResult["EXTRA_SETTINGS"]["CURRENCY"], true)?>
						
						<s class="discount">
							<?if(!empty($arResult["PRICE"]["DISCOUNT"])):?>
								<?=CCurrencyLang::CurrencyFormat($arResult["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], $arResult["EXTRA_SETTINGS"]["CURRENCY"], true)?>
							<?endif;?>
						</s>
					</a>
				<?else:?>
					<a class="price"><?=CCurrencyLang::CurrencyFormat($arResult["PRICE"]["DISCOUNT_PRICE"], $arResult["EXTRA_SETTINGS"]["CURRENCY"], true)?>
						
						<s class="discount">
							<?if(!empty($arResult["PRICE"]["DISCOUNT"])):?>
								<?=CCurrencyLang::CurrencyFormat($arResult["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], $arResult["EXTRA_SETTINGS"]["CURRENCY"], true)?>
							<?endif;?>
						</s>
					</a>
				<?endif;?>								
			<?else:?>
				<a class="price"><?=GetMessage("OFFERS_REQUEST_PRICE_LABEL")?></a>
			<?endif;?>
		</div>
		<div class="tc quanBaskWrap">
			<div class="tb">
				<div class="tc quantity">
					<?if($arResult["CATALOG_QUANTITY"] == 0):?>
						<?if(!empty($arResult["EXTRA_SETTINGS"]["STORES"]) && $arResult["EXTRA_SETTINGS"]["STORES_MAX_QUANTITY"] > 0):?>
							<a href="#" data-id="<?=$arResult["ID"]?>" class="inStock label getStoresWindow"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("AVAILABLE")?>" class="icon"><span><?=GetMessage("AVAILABLE")?></span></a>
						<?else:?>
							<span class="inStock label"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("AVAILABLE")?>" class="icon"><span><?=GetMessage("AVAILABLE")?></span></span>
						<?endif;?>
					<?else:?>
						<?if($arResult["CATALOG_AVAILABLE"] == "Y"):?>
							<a class="onOrder label"><img src="<?=SITE_TEMPLATE_PATH?>/images/onOrder.png" alt="<?=GetMessage("ON_ORDER")?>" class="icon"><?=GetMessage("ON_ORDER")?></a>
						<?else:?>
							<a class="outOfStock label"><img src="<?=SITE_TEMPLATE_PATH?>/images/outOfStock.png" alt="<?=GetMessage("CATALOG_NO_AVAILABLE")?>" class="icon"><?=GetMessage("CATALOG_NO_AVAILABLE")?></a>
						<?endif;?>
					<?endif;?>
				</div>
				<div class="tc basket">
					<?if(!empty($arResult["PRICE"])):?>
						<?if($arResult["CATALOG_AVAILABLE"] != "Y"):?>
							<?if($arResult["CATALOG_SUBSCRIBE"] == "Y"):?>
								<a onclick="ym(<?=$arTemplateSettings['TEMPLATE_METRICA_ID']?>,'reachGoal','<?=$arTemplateSettings['TEMPLATE_METRICA_ADD_CART']?>');" target="_blank" href="/red.php?red=<?=urlencode($arResult["PARTNER_LINK"] . '?subid=sect_' . $arResult['ID'] . '&ulp=' . $arResult['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart subscribe" data-id="<?=$arResult["ID"]?>" data-quantity="<?=$arResult["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>
							<?else:?>
								<a onclick="ym(<?=$arTemplateSettings['TEMPLATE_METRICA_ID']?>,'reachGoal','<?=$arTemplateSettings['TEMPLATE_METRICA_ADD_CART']?>');" target="_blank" href="/red.php?red=<?=urlencode($arResult["PARTNER_LINK"] . '?subid=sect_' . $arResult['ID'] . '&ulp=' . $arResult['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart disabled" data-id="<?=$arResult["ID"]?>" data-quantity="<?=$arResult["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>															
							<?endif;?>
						<?else:?>
							<a onclick="ym(<?=$arTemplateSettings['TEMPLATE_METRICA_ID']?>,'reachGoal','<?=$arTemplateSettings['TEMPLATE_METRICA_ADD_CART']?>');" target="_blank" href="/red.php?red=<?=urlencode($arResult["PARTNER_LINK"] . '?subid=sect_' . $arResult['ID'] . '&ulp=' . $arResult['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart" data-id="<?=$arResult["ID"]?>" data-quantity="<?=$arResult["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>														
						<?endif;?>
					<?else:?>
						<a onclick="ym(<?=$arTemplateSettings['TEMPLATE_METRICA_ID']?>,'reachGoal','<?=$arTemplateSettings['TEMPLATE_METRICA_ADD_CART']?>');" target="_blank" href="/red.php?red=<?=urlencode($arResult["PARTNER_LINK"] . '?subid=sect_' . $arResult['ID'] . '&ulp=' . $arResult['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart disabled requestPrice" data-id="<?=$arResult["ID"]?>" data-quantity="<?=$arResult["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>
					<?endif;?>
				</div>
			</div>
		</div>
	</div>
</div>