<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if($arResult['ITEMS'])
{?>
	<div class="catalogTagItems">
	<?foreach($arResult['ITEMS'] as $Item)
	{
        if($Item['TITLE'] && $Item['URL']) {
            ?>
			
				<div class="catalogTagItem">
					<a href="<?=$Item['URL'] ?>" class="catalogTagLink"><?=$Item['TITLE'] ?></a>
				</div>
			
					
		    <?
        }
	}?>
	</div>
<?}
?>