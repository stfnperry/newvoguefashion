<?php
namespace SHWPortfolioCatalog\Controllers\Frontend;
use SHWPortfolioCatalog\Controllers\Frontend\WP_Router;
use SHWPortfolioCatalog\Controllers\Frontend\WP_Route;
use SHWPortfolioCatalog\Controllers\Frontend\WP_Router_Page;
use SHWPortfolioCatalog\Models\Catalog;
class FrontendController
{
	public function __construct() {
		add_shortcode('showcaster', array('SHWPortfolioCatalog\Controllers\Frontend\ShortcodeController', 'run'));
        add_action('wp_router_generate_routes', array($this, 'generate_routes'));
		FrontendAssetsController::init();
        new CatalogPreviewController();
        WP_Router_Page::init();
	}
	public static function generate_routes(WP_Router $router) {
        $posts = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'publish'
        ));
        foreach ($posts as $key=>$post) {
            $permalink_structure = explode(home_url() . "/", get_permalink($post->ID))[1];
            $pattern = "/(\?)?([0-9A-Za-z]+=[0-9A-Za-z]+(\&)?)/";
            $path = '';
            if ($_GET) {
                FrontendController::permalinkPlain($_SERVER['REQUEST_URI']);
            } else {
                $id = rand(1, mt_getrandmax());
                $lastChar = $permalink_structure[strlen($permalink_structure) - 1];
                if ($lastChar == '/') {
                    $path = '^' . $permalink_structure . 'catalog/(.*?)$';
                } else {
                    $path = '^' . $permalink_structure . '/catalog/(.*?)$';
                }
                $router->add_route('wp-router-sample' . $id, array(
                    'path' => $path,
                    'query_vars' => array(
                        'sample_argument' => 1
                    ),
                    'page_callback' => array(get_class(), 'sample_callback'),
                    'page_arguments' => array('sample_argument'),
                    'access_callback' => TRUE
                ));
            }
        }
    }

    public static function sample_callback($title) {
        $catalog = new Catalog();
        $allData = $catalog->getAllCatalogDataByTitle($title);
        do_action('shwproductShortcodeScripts');
	    \SHWPortfolioCatalog\Helpers\View::render('frontend/single.php', array('allData' => $allData));
    }

    public static function permalinkPlain($permalink_structure) {
        ob_start();
        $extra = array(
            'route-$id.php',
            'route.php',
            'page-$id.php',
            'page.php'
        );
        $template = locate_template($extra);
        $title = substr($permalink_structure, strrpos($permalink_structure, '/') + 1);
        $returned =FrontendController::sample_callback($title);
        $echoed = ob_get_clean();
        $page = new WP_Router_Page( $echoed.$returned, $title, $template);
    }
}