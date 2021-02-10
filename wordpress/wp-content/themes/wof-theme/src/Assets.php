<?php


namespace WOF\Org\Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Class Assets
 *
 * An object that manages enqueueing/dequeueing scripts and styles based on user supplied conditions.
 *
 * @package WOF
 */
class Assets {

    /**
     * @var string the root assets directory to pull assets from
     */
    private $assetsDir;

    /**
     * @var string the asset version. Changing this forces a cache flush on the client.
     */
    private $version;


    /**
     * Construct a new assets object to abstract the enqueing of assets.
     *
     * @param string $assetsDir The location on the server of all the assets. Usually dist
     * @param string $version The version number to append all
     */
    public function __construct(string $assetsDir, string $version = '1.0.0') {
        $this->assetsDir = $assetsDir;
        $this->version = $version;
    }

    public function registerHooks () {
        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts') );
        add_action( 'admin_init', array($this, 'enqueueEditorScripts') );
    }

    /**
     * Enqueue scripts and styles on the frontend
     */
    public function enqueueScripts() {
        // Fonts
        wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap', array(), '1.0.0');
        wp_enqueue_style('fonts-dot-com', '//fast.fonts.net/cssapi/adaf91e8-dbab-490e-af58-66471d735ece.css', array(), '1.0.0');

        // Frontend Scripts and Styles
        wp_enqueue_style('wof-theme-style', $this->assetsDir . '/css/front.css', array(), $this->version);
        wp_enqueue_script('wof-theme-script', $this->assetsDir . '/js/front.min.js', array( 'jquery' ), $this->version, true);
    }

    /**
     * Enqueue scripts and styles on the admin side.
     */
    public function enqueueAdminScripts() {
	    // Fonts
	    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap', array(), '1.0.0');
	    wp_enqueue_style('fonts-dot-com', 'https://fast.fonts.net/cssapi/adaf91e8-dbab-490e-af58-66471d735ece.css', array(), '1.0.0');

        wp_enqueue_style('wof-theme-admin-style', $this->assetsDir . '/css/admin.css', array(), $this->version);
        wp_enqueue_script('wof-theme-admin-script', $this->assetsDir . '/js/admin.min.js', array( 'jquery' ), $this->version, true);
    }

	/**
	 * Add styles to the block editor.
	 */
    public function enqueueEditorScripts() {
	    remove_editor_styles();
	    add_editor_style($this->assetsDir . '/css/editor.css');
    }
}