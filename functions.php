<?php
/*
 * @author Oscar Weijman
 * @link www.oscarweijman.com
 * 
 * @package WordPress
 * @subpackage Theme
 * 
 * Template: genesis
 * Template Version: 1.0
 * License: GPL-3.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php 
 */

/** Start the engine **/
require_once( TEMPLATEPATH . '/lib/init.php');
require_once( 'inc/walker-menu.php');

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
//add_theme_support( 'custom-background' );

//* Add support for  3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


class OW_Bootstrap {
    
    public $layout;

    
    public function __construct() {
        
        $this->globals();
        
        //* Unregister layout settings
        genesis_unregister_layout( 'sidebar-content' );
        genesis_unregister_layout( 'content-sidebar-sidebar' );
        genesis_unregister_layout( 'sidebar-content-sidebar' );
        genesis_unregister_layout( 'sidebar-sidebar-content' );
        
        //* Unregister primary navigation menu
        add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );
        
        
        add_action('wp', array(&$this, 'init'));
        
        //Add container class
        add_filter('genesis_attr_site-container', array(&$this, 'container') );
        
        //Add main row class
        add_filter('genesis_attr_content-sidebar-wrap', array(&$this, 'main_row') );
        
        //Add content column class
        add_filter('genesis_attr_content', array(&$this, 'content_column') );
        
        //Add sidebar-primary class
        add_filter('genesis_attr_sidebar-primary', array(&$this, 'sidebar_primary') );
        
        //Add secondary-primary class
        //add_filter('genesis_attr_sidebar-secondary', array(&$this, 'sidebar_secondary') );
        
        //Primary nav
        add_filter('genesis_attr_nav-primary', array(&$this, 'nav_primary') );
        add_filter('wp_nav_menu_args', array(&$this, 'nav_menu') );
        
        add_filter('genesis_attr_site-header', array( &$this, 'site_header' ) );
        add_filter('genesis_attr_title-area', array( &$this, 'title_area') );
        add_filter('genesis_attr_header-widget-area', array(&$this, 'header_widget_area'));
        //Register styles/scripts
        add_action( 'wp_enqueue_scripts', array(&$this, 'scripts_styles') );
        add_action( 'genesis_site_title', array(&$this, 'mobile_nav_icon'), 0 );


    }
    
    
    public function init() {
        
        $layout = genesis_site_layout();
        $this->layout = $layout;
        
        $this->structural_wraps();
        //$this->sidebar();
        
    }
    
    
    public function globals() {
        
        define('OW_VERSION', '1.0.0');
        
        
    }
    
    
    public function scripts_styles() {
        
        wp_enqueue_script( 'bootstrap', CHILD_URL . '/js/bootstrap.min.js', array( 'jquery' ), OW_VERSION, true );
        wp_enqueue_script( 'jpanelmenu', CHILD_URL . '/js/jquery.jpanelmenu.min.js', array( 'jquery' ), OW_VERSION, true );
        wp_enqueue_script( 'functions', CHILD_URL . '/js/functions.js', array('jquery'), OW_VERSION, true );
        wp_enqueue_script('superfish');
        wp_enqueue_style( 'font-awesome', CHILD_URL . '/css/font-awesome.min.css', false, OW_VERSION );
        
    }
    
    
    public function structural_wraps() {
        
        // Remove all wrappers
        remove_theme_support( 'genesis-structural-wraps');
        
    }
    
    
    public function site_header($attr) {
        
        $attr['class'] = 'site-header row';
        return $attr;
    }
    
    
    
    public function title_area($attr) {
        
        $attr['class'] = 'title-area col-sm-6';
        return $attr;
    }
    
    
    public function header_widget_area($attr) {
        
        $attr['class'] = 'widget-area header-widget-area col-sm-6';
        return $attr;
        
    }
    
    public function mobile_nav_icon() {
        echo '<div class="hidden-lg hidden-sm pull-left responsive-menu-icon">
                <i class="fa fa-bars fa-2x white"></i> 
             </div>';
    }
    
    
    public function container($attr) {
           
        $attr['class'] = 'container';
        return $attr;
    
    }
    
    
    public function main_row($attr) {
            
        $attr['class'] = 'row';
        return $attr;
        
    }
    
    
    function content_column($attr) {

        $layout = $this->layout;
        
        if($layout == 'full-width-content') {

            $layout = 'col-sm-12';

        } elseif( $layout == 'content-sidebar-sidebar') {    
            $layout = 'col-sm-7';
        } else {
            $layout = 'col-sm-9';
        }

        $attr['class'] = $layout;
        return $attr;

    }
    
    
    public function sidebar_primary($attr) {
        
        $attr['class'] = 'col-sm-3';
        return $attr;

     }
     
     
     public function sidebar_secondary($attr) {
         
        $attr['class'] = 'col-sm-2';
        return $attr;
        
     }
     
     
     public function sidebar() {

         if( $this->layout == 'sidebar-content' ) {
             
             remove_action('genesis_content', 'genesis_do_content');
             //remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
             //add_action('genesis_before_content', 'genesis_do_sidebar');
             
         }
         
        //remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
        //add_action('genesis_after_content', 'genesis_do_sidebar_alt');
         
     }
     
     
     public function nav_primary( $attr ) {
         
         $attr['class'] = 'navbar navbar-default hidden-xs';
         return $attr;
         
     }
     
     
     public function nav_menu( $attr ) {
         
         $attr['walker'] = new wp_bootstrap_navwalker;
         $attr['menu_class'] = 'nav navbar-nav';
         return $attr;
         
     }
    
}

new OW_Bootstrap();

