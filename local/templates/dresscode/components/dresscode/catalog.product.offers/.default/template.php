<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult["ITEMS"])):?>
	<?if(empty($arParams["FROM_AJAX"])):?>
		<div id="skuOffersTable">
			<span class="heading"><?=GetMessage("OFFERS_PRODUCT_VARIANT")?></span>
			<div class="offersTableContainer">
				<div class="offersTable">
					<div class="thead">
						<div class="tb">
							<?if($arParams["DISPLAY_PICTURE_COLUMN"] == "Y"):?>
								<div class="tc offersPicture"></div>
							<?endif;?>
							<div class="tc offersName"><?=GetMessage("OFFERS_NAME_COLUMN")?></div>
							<?foreach ($arResult["PROPERTY_NAMES"] as $nextPropertyName):?>
								<div class="tc property"><?=$nextPropertyName?></div>
							<?endforeach;?>
							<div class="tc priceWrap"><?=GetMessage("OFFERS_PRICE_COLUMN")?></div>
							<div class="tc quanBaskWrap">
								<div class="tb">
									<div class="tc quantity"><?=GetMessage("OFFERS_AVAILABLE_COLUMN")?></div>
									<div class="tc basket"><?=GetMessage("OFFERS_ADD_CART_COLUMN")?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="skuOffersTableAjax">
					<?endif;//empty($arParams["FROM_AJAX"])?>
						<?foreach ($arResult["ITEMS"] as $inx => $arNextElement):?>
							<?
								$this->AddEditAction("offers_".$arNextElement["ID"], $arNextElement["EDIT_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction("offers_".$arNextElement["ID"], $arNextElement["DELETE_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array());
							?>
							<div class="tableElem" id="<?=$this->GetEditAreaId("offers_".$arNextElement["ID"]);?>">
								<div class="tb">
									<?if($arParams["DISPLAY_PICTURE_COLUMN"] == "Y"):?>
										<div class="tc offersPicture">
											<img src="<?=$arNextElement["PICTURE"]["src"]?>" alt="<?=$arNextElement["NAME"]?>">
										</div>
									<?endif;?>
									<div class="tc offersName"><?=$arNextElement["NAME"]?></div>
									<?foreach ($arNextElement["PROPERTIES_FILTRED"] as $arNextPropertyFiltred):?>
										<div class="tc property"><?=$arNextPropertyFiltred["DISPLAY_VALUE"]?></div>
									<?endforeach;?>
									<div class="tc priceWrap">
										<?if(!empty($arNextElement["PRICE"])):?>
											<?if($arNextElement["EXTRA_SETTINGS"]["COUNT_PRICES"] > 1):?>
												<a class="price getPricesWindow" data-id="<?=$arNextElement["ID"]?>">
													<span class="priceIcon"></span><?=CCurrencyLang::CurrencyFormat($arNextElement["PRICE"]["DISCOUNT_PRICE"], $arNextElement["EXTRA_SETTINGS"]["CURRENCY"], true)?>
													
													<s class="discount">
														<?if(!empty($arNextElement["PRICE"]["DISCOUNT"])):?>
															<?=CCurrencyLang::CurrencyFormat($arNextElement["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], $arNextElement["EXTRA_SETTINGS"]["CURRENCY"], true)?>
														<?endif;?>
													</s>
												</a>
											<?else:?>
												<a class="price"><?=CCurrencyLang::CurrencyFormat($arNextElement["PRICE"]["DISCOUNT_PRICE"], $arNextElement["EXTRA_SETTINGS"]["CURRENCY"], true)?>
													
													<s class="discount">
														<?if(!empty($arNextElement["PRICE"]["DISCOUNT"])):?>
															<?=CCurrencyLang::CurrencyFormat($arNextElement["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], $arNextElement["EXTRA_SETTINGS"]["CURRENCY"], true)?>
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
												<?if($arNextElement["CATALOG_QUANTITY"] == 0):?>
													<?if(!empty($arNextElement["EXTRA_SETTINGS"]["STORES"]) && $arNextElement["EXTRA_SETTINGS"]["STORES_MAX_QUANTITY"] > 0):?>
														<a href="#" data-id="<?=$arNextElement["ID"]?>" class="inStock label getStoresWindow"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("AVAILABLE")?>" class="icon"><span><?=GetMessage("AVAILABLE")?></span></a>
													<?else:?>
														<span class="inStock label"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("AVAILABLE")?>" class="icon"><span><?=GetMessage("AVAILABLE")?></span></span>
													<?endif;?>
												<?else:?>
													<?if($arNextElement["CATALOG_AVAILABLE"] == "Y"):?>
														<a class="onOrder label"><img src="<?=SITE_TEMPLATE_PATH?>/images/onOrder.png" alt="<?=GetMessage("ON_ORDER")?>" class="icon"><?=GetMessage("ON_ORDER")?></a>
													<?else:?>
														<a class="outOfStock label"><img src="<?=SITE_TEMPLATE_PATH?>/images/outOfStock.png" alt="<?=GetMessage("CATALOG_NO_AVAILABLE")?>" class="icon"><?=GetMessage("CATALOG_NO_AVAILABLE")?></a>
													<?endif;?>
												<?endif;?>
											</div>
											<div class="tc basket">
												<?if(!empty($arNextElement["PRICE"])):?>
													<?if($arNextElement["CATALOG_AVAILABLE"] != "Y"):?>
														<?if($arNextElement["CATALOG_SUBSCRIBE"] == "Y"):?>
															<a onclick="ym(21192229,'reachGoal','CLICK_OFFER');" target="_blank" href="/red.php?red=<?=urlencode('https://ad.admitad.com/g/17lxnyyakg5082102477c109c80522/?subid=elem_' . $arNextElement['ID'] . '&ulp=' . $arNextElement['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart subscribe" data-id="<?=$arNextElement["ID"]?>" data-quantity="<?=$arNextElement["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>
														<?else:?>
															<a onclick="ym(21192229,'reachGoal','CLICK_OFFER');" target="_blank" href="/red.php?red=<?=urlencode('https://ad.admitad.com/g/17lxnyyakg5082102477c109c80522/?subid=elem_' . $arNextElement['ID'] . '&ulp=' . $arNextElement['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart disabled" data-id="<?=$arNextElement["ID"]?>" data-quantity="<?=$arNextElement["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>															
														<?endif;?>
													<?else:?>
														<a onclick="ym(21192229,'reachGoal','CLICK_OFFER');" target="_blank" href="/red.php?red=<?=urlencode('https://ad.admitad.com/g/17lxnyyakg5082102477c109c80522/?subid=elem_' . $arNextElement['ID'] . '&ulp=' . $arNextElement['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart" data-id="<?=$arNextElement["ID"]?>" data-quantity="<?=$arNextElement["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>														
													<?endif;?>
												<?else:?>
													<a onclick="ym(21192229,'reachGoal','CLICK_OFFER');" target="_blank" href="/red.php?red=<?=urlencode('https://ad.admitad.com/g/17lxnyyakg5082102477c109c80522/?subid=elem_' . $arNextElement['ID'] . '&ulp=' . $arNextElement['PROPERTIES']['URL_PRODUCT']['VALUE'])?>" class="addCart disabled requestPrice" data-id="<?=$arNextElement["ID"]?>" data-quantity="<?=$arNextElement["EXTRA_SETTINGS"]["BASKET_STEP"]?>">Подробнее</a>
												<?endif;?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?endforeach;?>
						<?if(!empty($arResult["PAGER_ENABLED"]) && !empty($arParams["PAGER_NUM"])):?>
							<div class="catalogProductOffersPager">
								<a href="#" class="catalogProductOffersNext btn-simple btn-small" data-page-num="<?=$arParams["PAGER_NUM"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/plusWhite.png" alt=""><?=GetMessage("PAGER_NEXT_PAGE_LABEL")?></a>
							</div>
						<?endif;?>
					<?if(empty($arParams["FROM_AJAX"])):?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var catalogProductOffersParams = '<?=\Bitrix\Main\Web\Json::encode($arParams);?>';
			var catalogProductOffersAjaxDir = "<?=$this->GetFolder();?>";
		</script>
	<?endif;//empty($arParams["FROM_AJAX"])?>
<?endif;?>