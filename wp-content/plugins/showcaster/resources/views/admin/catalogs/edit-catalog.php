<?php/** * Template for edit product page * @var $catalog \SHWPortfolioCatalog\Models\Catalog * * @var $theme \SHWPortfolioCatalog\Models\Themes * @var $productOptions \SHWPortfolioCatalog\Models\Catalog */use SHWPortfolioCatalog\Controllers\Frontend\CatalogPreviewController as Preview;global $wpdb;$items = $catalog->getItemsCount();$catalogy_data = $catalog->getCatalog();$list = $catalog->getCatalogsUrl();$id = $catalog->getId();$new_catalog_link = admin_url('admin.php?page=shwportfolio&task=create_new_catalog');$new_catalog_link = wp_nonce_url($new_catalog_link, 'shwcatalog_create_new_catalog');$catalog_settings_link = admin_url('admin.php?page=shwfrm&task=edit_form_settings&id=' . $catalog->getId());$catalog_settings_link = wp_nonce_url($catalog_settings_link, 'shwfrm_edit_form_settings_' . $catalog->getId());$save_data_nonce = wp_create_nonce('shwcatalog_nonce_save_data' . $id);?><?php$productSettings = \SHWPortfolioCatalog\Models\Catalog::getProductSettings($id);$themeSelected = $productSettings['productOptionTheme']['theme_id'];$productOptionsEnableSearch = isset($productSettings['productOptionsEnableSearch']['value']) ? $productSettings['productOptionsEnableSearch']['value'] : 'on';$productOptionsactivateLoadMore = isset($productSettings['productOptionsactivateLoadMore']['value']) ? $productSettings['productOptionsactivateLoadMore']['value'] : 'Effect1';$productEnableCategoriesFilter = isset($productSettings['productEnableCategoriesFilter']['value']) ? $productSettings['productEnableCategoriesFilter']['value'] : 'on';$productEnableOrderingButtons = isset($productSettings['productEnableOrderingButtons']['value']) ? $productSettings['productEnableOrderingButtons']['value'] : 'on';$productPopup = isset($productSettings['productPopup']['value']) ? $productSettings['productPopup']['value'] : 'popup';$productEnableZoom = isset($productSettings['productEnableZoom']['value']) ? $productSettings['productEnableZoom']['value'] : 'on';$productEnableLightbox = isset($productSettings['productEnableLightbox']['value']) ? $productSettings['productEnableLightbox']['value'] : 'on';$productShowCategories = isset($productSettings['productShowCategories']['value']) ? $productSettings['productShowCategories']['value'] : 'on';$productShowAttributes = isset($productSettings['productShowAttributes']['value']) ? $productSettings['productShowAttributes']['value'] : 'on';$attributes = \SHWPortfolioCatalog\Models\Attributes::getAttributes($id);$items = \SHWPortfolioCatalog\Models\Catalog::getProducts_($id);$getThemeOption = \SHWPortfolioCatalog\Models\Themes::getThemeById_($themeSelected);$themeView = $getThemeOption->view;$hide = $themeView == 2 ? 'hide' : '';?><input type="hidden" name="noimage" value="<?php echo SHWPORTFOLIOCATALOG_IMAGES_URL ?>icons/noimage.png"/><div class="shwproduct-list-header">    <div class="logo_block">        <img src ="<?= SHWPORTFOLIOCATALOG_IMAGES_URL ?>icons/logo.png" alt="" />    </div>    <div class="navigation_block">        <ul>            <li><a href="https://showcaster.org/#pricing" class="pro_button" target="_blank">Get Pro</a></li>            <li><a href="https://showcaster.org/#demo" target="_blank">Demo</a></li>            <li><a href="https://showcaster.org/#contacts" target="_blank">Help</a></li>            <li><a href="https://wordpress.org/support/plugin/showcaster/" target="_blank">Support Forum</a></li>        </ul>    </div></div><ul class="tab_nav_list">    <?php foreach ($list as $val): ?><?php if ($val["id"] == $id): ?>        <li class='tab_nav_active_tab'>            <a href="javascript:;" id="shwproduct_edit_nameId" class="product-pencil shwproduct_edit_name"><i url="<?= $val["url"] ?>" uid="<?php echo $id ?>" class="fa fa-pencil" aria-hidden="true"></i></a>            <input type="hidden" id="shwcatalog_id" name="shwcatalog_id" value="<?php echo $id ?>">            <a href="javascript:;" url="<?= $val["url"] ?>" uid="<?php echo $id ?>" class="shwproduct_active_name"><?= $val["name"] ?></a>            <input type='text' name='edit_name_<?php echo $id ?>' value='<?= $val["name"] ?>' class="shwproduct_hidden edit_name_input" autofocus="autofocus">        </li>    <?php else: ?>        <li>            <a href="<?= $val["url"] ?>"><?= $val["name"] ?></a>        </li>    <?php endif; ?><?php endforeach; ?>    <li class="tab_nav_add_new_tab">        <a href="<?= $new_catalog_link ?>"><?php _e('Add New Grid'); ?><i class="fa fa-plus" aria-hidden="true"></i></a>    </li></ul><form action="admin.php?page=shwportfoliocatalog&id=<?php echo $catalog->getId(); ?>&save_data_nonce=<?php echo $save_data_nonce; ?>" method="post" name="shwproduct_images_form" id="shwproduct_images_form">    <div class="wrap shwproduct_edit_form_container">        <div class="single_grid_options">            <div class="single_grid_options_container">                <div class="single_grid_options_nav">                    <ul>                        <li class="active">                            <a href="#shwgrid_options"><?php _e('Grid Options'); ?></a>                        </li>                        <li>                            <a href="#shwitem_options"><?php _e('Item Options'); ?></a>                        </li>                        <li>                            <a href="#shwproduct_attributes"><?php _e('Attributes'); ?></a>                        </li>                        <li>                            <a href="#shwproduct_publish"><?php _e('Publish The Grid'); ?></a>                        </li>                    </ul>                    <div class="buttons_block">                        <div class="preview_button_block">                            <a href="<?php echo Preview::previewUrl($catalog->getId(), false); ?>" class="shwproduct-preview-grid-button" target="_blank">                                <?php _e('Preview'); ?>                            </a>                        </div>                        <div class="save_button_block">                            <input type="submit" value="Save" id="shwproduct-save-buttom" class="shwproduct-save-buttom">                        </div>                    </div>                </div>                <div class="single_grid_options_content">                 <!--#########GRID OPTIONS#############-->                    <div id="shwgrid_options" class="active">                        <div class="options_wrapper">                            <div class="optionsContainer">                                <div class="options">                                    <label class="productOptionsLabel"><?php _e('Choose Theme'); ?></label>                                    <select class="selectStyles" name="productOptionTheme" class="selectOptions">                                        <?php $themes = \SHWPortfolioCatalog\Models\Themes::getAllThemes(); ?>                                        <?php foreach ($themes as $theme): ?>                                            <option <?php echo $themeSelected == $theme->id ? "selected" : "" ?> value="<?php echo $theme->id; ?>"> <?php echo $theme->title; ?></option>                                        <?php endforeach; ?>                                    </select>                                </div>                                <div class="options <?= $hide ?>">                                    <label class="productOptionsLabel" for="activateLoadMoreID"><?php _e('Activate Load More Button'); ?></label>                                    <input type="checkbox" name="productOptionsactivateLoadMore" id="activateLoadMoreID" class="css-checkbox" <?php echo $productOptionsactivateLoadMore == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative; right: 0;  margin-left: 95%; display: block; top: 6px;" for="activateLoadMoreID"></label>                                </div>                                <div class="options">                                    <label class="productOptionsLabel" for="enableSearchId"><?php _e('Enable Search'); ?></label>                                    <input type="checkbox" name="productOptionsEnableSearch" id="enableSearchId" class="css-checkbox" <?php echo $productOptionsEnableSearch == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative;    right: 0;   margin-left: 95%;    display: block; top: 6px;" for="enableSearchId"></label>                                </div>                            </div>                            <div class="optionsContainer <?= $hide ?>">                                <div class="options <?= $hide ?>">                                    <label class="productOptionsLabel" for="productEnableCategoriesFilter"><?php _e('Enable Categories Filter'); ?></label>                                    <input type="checkbox" name="productEnableCategoriesFilter" id="productEnableCategoriesFilter" class="css-checkbox" <?php echo $productEnableCategoriesFilter == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative;    right: 0;   margin-left: 95%;    display: block; top: 6px;" for="productEnableCategoriesFilter"></label>                                </div>                                <div class="options <?= $hide ?>">                                    <label class="productOptionsLabel" for="productEnableOrderingButtons"><?php _e('Enable Ordering Buttons'); ?></label>                                    <input type="checkbox" name="productEnableOrderingButtons" id="productEnableOrderingButtons" class="css-checkbox" <?php echo $productEnableOrderingButtons == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative;    right: 0;   margin-left: 95%;    display: block; top: 6px;" for="productEnableOrderingButtons"></label>                                </div>                            </div>                        </div>                    </div>                     <!--#########ITEM OPTIONS#############-->                    <div id="shwitem_options">                        <div class="options_wrapper">                            <div class="optionsContainer">                                <div class="options">                                    <label class="productOptionsLabel"><?php _e('Show Item In'); ?></label>                                    <select class="selectStyles" name="productPopup" class="selectOptions">                                        <option <?php echo $productPopup == "popup" ? "selected" : "" ?> value="popup">Popup</option>                                        <option <?php echo $productPopup == "new" ? "selected" : "" ?> value="new">New Page</option>                                    </select>                                </div>                                <div class="options">                                    <label class="productOptionsLabel" for="productEnableZoomId"><?php _e('Enable Zoom'); ?></label>                                    <input type="checkbox" name="productEnableZoom" id="productEnableZoomId" class="css-checkbox" <?php echo $productEnableZoom == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative; right: 0;  margin-left: 95%; display: block; top: 6px;" for="productEnableZoomId"></label>                                </div>                            </div>                            <div class="optionsContainer">                                <div class="options">                                    <label class="productOptionsLabel" for="productShowCategoriesID"><?php _e('Show Categories'); ?></label>                                    <input type="checkbox" name="productShowCategories" id="productShowCategoriesID" class="css-checkbox" <?php echo $productShowCategories == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative; right: 0;  margin-left: 95%; display: block; top: 6px;" for="productShowCategoriesID"></label>                                </div>                                <div class="options">                                    <label class="productOptionsLabel" for="productShowAttributesId"><?php _e('Show Attributes '); ?></label>                                    <input type="checkbox" name="productShowAttributes" id="productShowAttributesId" class="css-checkbox" <?php echo $productShowAttributes == "on" ? "checked" : "" ?> />                                    <label class="css-label" style="position: relative; right: 0;  margin-left: 95%; display: block; top: 6px;" for="productShowAttributesId"></label>                                </div>                            </div>                        </div>                    </div>                    <!--#########ATTRIBUTES#############-->                    <div id="shwproduct_attributes">                        <div class="attributes_wrapper">                            <input type="text" placeholder="Attribute" name="addAttribute" id="addAtributeId" class="add_attribute_input" />                            <input type="button" class="shwcatalog_add_attributes_button" value="Add" />                            <div class="shwproduct_allAttributes" id="sortable">                                <div id="check" style=" "></div>                                <?php                                foreach ($attributes as $attribute) {                                    ?>                                    <label uid="<?= $attribute->id; ?>" id="attribute<?= $attribute->id; ?>" class="ui-state-default"><?= esc_html($attribute->title) ?>                                        <span uid="<?= $attribute->id; ?>" class="attributeClose"></span>                                    </label>                                    <?php                                }                                ?>                            </div>                            <div class="clear"></div>                            <input type="hidden" name="catalogId" value=<?= $id; ?>>                        </div>                    </div>                    <!--#########PUBLISH#############-->                    <div id="shwproduct_publish">                        <div class="shwproduct_shortcode_types">                            <div class="shwproduct_example">                                <h3><?php _e('Shortcode'); ?></h3>                                <p><?php _e('Copy and paste this shortcode into your posts or pages.'); ?></p>                                <div class="shwproduct_highlighted">                                    [showcaster id="<?= $id ?>"]                                </div>                            </div>                            <div class="shwproduct_example">                                <h3><?php _e('Page or Post'); ?></h3>                                <p><?php _e('Insert it into an existing post with the icon'); ?></p>                                <img src="<?= SHWPORTFOLIOCATALOG_IMAGES_URL ?>PostPage.png" />                            </div>                            <div class="shwproduct_example">                                <h3><?php _e('PHP Code'); ?></h3>                                <p><?php _e('Paste the PHP code into your template file'); ?></p>                                <div class="shwproduct_highlighted">                                    &lt;?php  echo do_shortcode('[showcaster id=<?= $id ?>]');  ?&gt;                                </div>                            </div>                        </div>                    </div>                </div>            </div>        </div>        <div class="shwproduct_items_section">            <div class="shwproduct_item_container">                <div class="shwproduct_add_new_product shwproduct_add_new_image shwcatalog_add_new_image" id="_unique_name_button">                    <p><?php _e('Add Grid Items'); ?></p>                </div>                <?php                if (!empty($items)) { ?>                    <a href="#" catalogId= <?php echo $id; ?> class="shwproduct_edit_product_images">Quick edit                        <i class="fa fa-pencil" aria-hidden="true"></i></a><p class="shwproduct_select_all_items">                        <label for="shwproduct_select_all_items"><?php _e(SHWPORTFOLIOCATALOG_TEXT_SELECT_ALL); ?></label>                        <input type="checkbox" id="shwproduct_select_all_items" name="select_all_items"/>                    </p>                    <a href="#" class="shwproduct_remove_selected_images catalog_delete_form"><?php _e('Remove selected items'); ?>                        <i class="fa fa-times" aria-hidden="true"></i></a>                <?php } ?>                <div class="shwproduct_clearfix"></div>                <div class="shwproduct_items_list" id="productsSortable">                    <?php                    $allGroups = 0;                    if (!empty($items)) {                        foreach ($items as $item):                            ?>                            <div class="shwproduct_item ui-state-default">                                <input type="hidden" name="imagegroup_<?= $item->id; ?>"/>                                <img src="<?= $item->image_id == -1 ? SHWPORTFOLIOCATALOG_IMAGES_URL . "icons/noimage.png" : $item->guid; ?>"/>                                <div class="shwproduct_item_overlay">                                    <input type="checkbox" name="items[]" value="<?= $item->id; ?>" class="items_checkbox"/>                                    <div class="shwproduct_item_edit shwcatalog_item_edit" productId="<?= $item->id; ?>">                                        <a href="#"><?php _e(SHWPORTFOLIOCATALOG_EDIT); ?> </a>                                    </div>                                </div>                            </div>                        <?php endforeach;                    } else {                        _e('No items in this group');                    } ?>                </div>            </div>        </div></form><?php \SHWPortfolioCatalog\Helpers\View::render('admin/edit-images.php', array('items' => $items, 'id' => $id, 'type' => 'catalog', "save_data_nonce" => $save_data_nonce)); ?><?php \SHWPortfolioCatalog\Helpers\View::render('admin/quick_editor.php', array('id' => $id, 'type' => 'catalog', "save_data_nonce" => $save_data_nonce)); ?>