<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if($arResult['ITEMS'])
{?>

<div id="detailTags" class="mobileHidden">
<h2 class="heading">C этим товаром искали</h2>
	<div class="detailTagsItems">
	<?foreach($arResult['ITEMS'] as $Item)
	{
        if($Item['TITLE'] && $Item['URL']) {
            ?>
			
				<div class="detailTagsItem">
					<a href="<?=$Item['URL'] ?>" class="detailTagsLink"><?=$Item['TITLE'] ?></a>
				</div>
			
					
		    <?
        }
	}?>
	</div>
</div>
<?}
?>