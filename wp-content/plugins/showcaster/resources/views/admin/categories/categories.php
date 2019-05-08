<div class="shwproduct-list-header">    <div class="logo_block">        <img src ="<?= SHWPORTFOLIOCATALOG_IMAGES_URL ?>icons/logo.png" alt="" />    </div>    <div class="navigation_block">        <ul>            <li><a href="https://showcaster.org/#pricing" class="pro_button" target="_blank">Get Pro</a></li>            <li><a href="https://showcaster.org/#demo" target="_blank">Demo</a></li>            <li><a href="https://showcaster.org/#contacts" target="_blank">Help</a></li>            <li><a href="https://wordpress.org/support/plugin/showcaster/" target="_blank">Support Forum</a></li>        </ul>    </div></div><div class="nosubsub">    <form class="search-form_" method="Post" onSubmit="return false;">        <div style="width: 100%; float: right; display: block;position: relative">            <p class="search-box">                <input type="text" id="categoryTerm" name="" value="">                <input type="button" id="searchCategory" class="button" value="Search">            <div class="loader" style="display:none" id="load"></div>            </p>        </div>    </form>    <div id="col-container" class="wp-clearfix">        <div id="col-left">            <div class="col-wrap">                <div class="form-wrap">                    <h2><?php _e('Categories', SHWPORTFOLIOCATALOG_TEXT_DOMAIN); ?></h2>                    <form id="addtag" method="post" class="validate">                        <div class="form-field form-required term-name-wrap">                            <label for="tag-name"><?php _e(SHWPORTFOLIOCATALOG_NAME); ?></label>                            <input name="tag-name" id="tag-name" type="text" value="" size="40" aria-required="true">                            <p><?php _e('The name is how it appears on your site.', SHWPORTFOLIOCATALOG_TEXT_DOMAIN); ?></p>                        </div>                        <input name="slug" id="tag-slug" type="hidden" value="" size="40">                        <?php                        $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;                        $categories = \SHWPortfolioCatalog\Models\Category::get(array(                            'paged' => $paged,                            'orderby' => 'id',                            'search_target' => 'title'                        ));                        ?>                        <div class="form-field term-description-wrap">                            <label for="tag-description"><?php _e(SHWPORTFOLIOCATALOG_TEXT_DESCRIPTION); ?></label>                            <textarea name="catDescription" id="catDescription" rows="5" cols="40"></textarea>                            <p><?php _e('The description is not prominent by default; however, some themes may show it.', SHWPORTFOLIOCATALOG_TEXT_DESCRIPTION); ?></p>                        </div>                        <p class="submit">                            <input type="button" name="submit" id="submit" class="button button-primary addCategoryBtn" value="Add New Category">                        </p>                    </form>                </div>            </div>        </div>        <div id="col-right">            <div class="col-wrap">                <form method="post" action="">                    <div class="tablenav top">                        <div class="alignleft actions bulkactions">                            <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>                            <select name="action1" id="bulk-action-selector-bottom">                                <option value="-1">Bulk Actions</option>                                <option value="delete">Delete</option>                            </select>                            <input type="submit" name="doaction" class="button action" value="Apply" id="doaction">                        </div>                        <br class="clear">                    </div>                    <h2 class="screen-reader-text"><?php _e('Categories list', SHWPORTFOLIOCATALOG_TEXT_DOMAIN); ?></h2>                    <table class="wp-list-table widefat fixed striped tags">                        <thead>                        <tr>                            <td id="cb" class="manage-column column-cb check-column">                                <label class="screen-reader-text" for="cb-select-all-1"><?php _e(SHWPORTFOLIOCATALOG_TEXT_SELECT_ALL); ?></label>                                <input id="cb-select-all-1" type="checkbox">                            </td>                            <th scope="col" id="name" class="manage-column column-name column-primary sortable desc">                                <a href="#">                                    <span>Name</span>                                    <span class="sorting-indicator"></span>                                </a>                            </th>                            <th scope="col" id="description" class="manage-column column-description sortable desc">                                <a href="#">                                    <span>Description</span>                                    <span class="sorting-indicator"></span>                                </a>                            </th>                        </tr>                        </thead>                        <tbody id="the-list" data-wp-lists="list:tag">                        <?php if (!empty($categories)) {                            foreach ($categories as $child) {                                $editUrl = admin_url('admin.php?page=shwcategories&task=edit_category&id=' . $child->getCategory()->id);                                $delete_category_link = admin_url('admin.php?page=shwcategories&task=delete_category&id=' . $child->getCategory()->id);                                $child = $child->getCategory();                                \SHWPortfolioCatalog\Helpers\View::render('admin/categories/categories-list.php', array('child' => $child, 'editUrl' => $editUrl, 'delete_category_link' => $delete_category_link));                            }                        } else {                            ?>                            <tr style="background-color: #fff">                                <th scope="row" class="check-column">&nbsp;</th>                                <td class="name column-name has-row-actions column-primary" data-colname="Name">                                    <strong>                                        <a class="row-title">No Category</a>                                    </strong>                                    <br>                                </td>                            </tr>                            <?php                        } ?>                        </tbody>                        <tfoot>                        <tr>                            <td class="manage-column column-cb check-column">                                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>                                <input id="cb-select-all-2" type="checkbox">                            </td>                            <th scope="col" class="manage-column column-name column-primary sortable desc">                                <a href="#">                                    <span>Name</span>                                    <span class="sorting-indicator"></span>                                </a>                            </th>                            <th scope="col" class="manage-column column-description sortable desc">                                <a href="#">                                    <span>Description</span>                                    <span class="sorting-indicator"></span>                                </a>                            </th>                        </tr>                        </tfoot>                    </table>                    <div class="tablenav bottom">                        <div class="alignleft actions bulkactions">                            <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>                            <select name="action" id="bulk-action-selector-bottom">                                <option value="-1">Bulk Actions</option>                                <option value="delete">Delete</option>                            </select>                            <input type="submit" name="doaction" class="button action" value="Apply" id="doaction">                        </div>                    </div>                    <br class="clear">            </div>            </form>        </div>    </div></div></div>