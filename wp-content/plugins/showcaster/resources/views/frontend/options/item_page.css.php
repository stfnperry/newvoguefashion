<?php
    echo "<style>";
?>

<?php
/* Item Page */
//$itemPageEnableImageZoom = $propertyOptions->itemPageEnableImageZoom;
$itemPageTitle = $propertyOptions->itemPageTitle;
$itemPageTitleColor = $propertyOptions->itemPageTitleColor;
$itemPageTitleFontStyle = $propertyOptions->itemPageTitleFontStyle;
$itemPageDescription = $propertyOptions->itemPageDescription;
$itemPageDescriptionColor = $propertyOptions->itemPageDescriptionColor;
$itemPageDescriptionFontStyle = $propertyOptions->itemPageDescriptionFontStyle;
$itemPagePrice = $propertyOptions->itemPagePrice;
$itemPagePriceColor = $propertyOptions->itemPagePriceColor;
$itemPagePriceFontStyle = $propertyOptions->itemPagePriceFontStyle;
$itemPageDiscountPrice = $propertyOptions->itemPageDiscountPrice;
$itemPageDiscountPriceColor = $propertyOptions->itemPageDiscountPriceColor;
$itemPageDiscountPriceFontStyle = $propertyOptions->itemPageDiscountPriceFontStyle;
$itemPageLabele = $propertyOptions->itemPageLabele;
$itemPageLabeleColor = $propertyOptions->itemPageLabeleColor;
$itemPageLabeleFontStyle = $propertyOptions->itemPageLabeleFontStyle;
$itemPageAttribute = $propertyOptions->itemPageAttribute;
$itemPageAttributeColor = $propertyOptions->itemPageAttributeColor;
$itemPageAttributeFontStyle = $propertyOptions->itemPageAttributeFontStyle;

?>

/*###################ITEM PAGE##################*/

.item_page_content .info_block .product_heading {
    font-size:<?php echo $itemPageTitle; ?>px;
    line-height:<?php echo $itemPageTitle; ?>px;
    color:<?php echo $itemPageTitleColor; ?>;
    font-family:<?php echo $itemPageTitleFontStyle; ?>;
}
.item_page_content .info_block .description_content {
    font-size:<?php echo $itemPageDescription; ?>px;
    line-height:<?php echo $itemPageDescription+2; ?>px;
    color:<?php echo $itemPageDescriptionColor; ?>;
    font-family:<?php echo $itemPageDescriptionFontStyle; ?>;
}
.item_page_content .info_block .product_price .old_price {
    font-size:<?php echo $itemPagePrice; ?>px;
    line-height:<?php echo $itemPagePrice+2; ?>px;
    color:<?php echo $itemPagePriceColor; ?>;
    font-family:<?php echo $itemPagePriceFontStyle; ?>;
}
.item_page_content .info_block .product_price .old_price_inner { color:<?php echo $itemPagePriceColor; ?>; }
.item_page_content .info_block .discount_price {
    font-size:<?php echo $itemPageDiscountPrice; ?>px;
    line-height:<?php echo $itemPageDiscountPrice+2; ?>px;
    color:<?php echo $itemPageDiscountPriceColor; ?>;
    font-family:<?php echo $itemPageDiscountPriceFontStyle; ?>;
}
.item_page_content .info_block .info_label {
    font-size:<?php echo $itemPageLabele; ?>px;
    line-height:<?php echo $itemPageLabele+2; ?>px;
    color:<?php echo $itemPageLabeleColor; ?>;
    font-family:<?php echo $itemPageLabeleFontStyle; ?>;
}
.item_page_content .info_block .info_label svg path {
    fill:<?php echo $itemPageLabeleColor; ?>;
}
.item_page_content .info_block .attributes_list li,
.item_page_content .info_block .product_categories .categories_list li {
    font-size:<?php echo $itemPageAttribute; ?>px;
    line-height:<?php echo $itemPageAttribute+2; ?>px;
    color:<?php echo $itemPageAttributeColor; ?>;
    font-family:<?php echo $itemPageAttributeFontStyle; ?>;
}
@media screen and (max-width:767px) {
    /* IF You Add ItemPageBackgorund option
    .item_page_content,
    .item_page_content .info_block .product_heading,
    .item_page_content .info_block .attributes_block,
    .item_page_content .info_block .product_description {

<?php
           // list($r, $g, $b) = sscanf($itemPageBackground, "#%02x%02x%02x");
           // $r=round($r*97/100);
            //$g=round($g*97/100);
           // $b=round($b*97/100);
        ?>
        border-color:RGB;
    }*/
}
<?php
    echo "</style>";
?>

