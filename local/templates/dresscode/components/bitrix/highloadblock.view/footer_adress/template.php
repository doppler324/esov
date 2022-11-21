<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<?if(Regions::is_region()):?>
<p style="color:#ffffff;" class="hr">Наш адрес: <?=$arResult['fields']['UF_REGION']['VALUE']?>, г. <?=$arResult['fields']['UF_CITY']['VALUE']?>, <?=$arResult['fields']['UF_ADDRESS']['VALUE']?></p>
<p style="color:#ffffff;" class="hr">Наш телефон: <?=$arResult['fields']['UF_PHONE']['VALUE']?></p>
<?endif;?>