<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult["ITEMS"])):?>
	<?if(empty($arParams["FROM_AJAX"])):?>
		<div id="skuOffersTable" style="margin-top:1rem;">
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
					<?foreach ($arResult["ITEMS"] as $index => $arElement):?>
						<?$APPLICATION->IncludeComponent(
							"dresscode:catalog.item",
							"datail_models",
							array(
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"HIDE_MEASURES" => $arParams["HIDE_MEASURES"],
								"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"PRODUCT_ID" => $arElement["ID"],
								"PRODUCT_SKU_FILTER" => $arResult["FILTER"],
								"PICTURE_HEIGHT" => "",
								"PICTURE_WIDTH" => "",
								"PRODUCT_PRICE_CODE" => $arParams["PRICE_CODE"],
								"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
								"LAZY_LOAD_PICTURES" => $arParams["LAZY_LOAD_PICTURES"],
								"CURRENCY_ID" => $arParams["CURRENCY_ID"],
								"UF_BEFORE_PRODUCT" => $arResult['UF_BEFORE_PRODUCT'],
								"TAGS" => $arParams["TAGS"],
								"LSI" => $arElement["LSI"]
							),
							false,
							array("HIDE_ICONS" => "Y")
						);?>
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