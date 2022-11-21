<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}

//$GLOBALS['APPLICATION']->SetTitle('Highloadblock List');

?>

<?
$rsSites = CSite::GetByID('s1');
$arSite = $rsSites->Fetch();
?>
<div id="empty">
	<div class="emptyWrapper">
		<ul class="emptyMenu">
			<? foreach ($arResult['rows'] as $row): ?>
				<li><a href="<?="https://".$row['UF_SUBDOMAIN'].".".DOMAIN?>"><?=$row['UF_CITY']?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>