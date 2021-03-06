<?php
/**
 * Plugin Name: Captcha Tanya Komen
 * Description: Simple anti spam komen dengan captcha tanya-jawab.
 * Plugin URI: https://github.com/ndunks/captcha-tanya-komen
 * Author: Mochamad Arifin
 * Author URI: http://klampok.id/
 */

define( 'CTK_DIR', plugin_dir_path( __FILE__ ) );
define( 'CTK_URL', plugins_url( '', __FILE__ ) . '/' );

class TanyaKomen
{
    public static $title = 'Captcha Tanya Komen';
    public static $name = 'captcha_tanya_komen';
    public static $version = '1.0.0';
    public static $me = false;
    public static $config = null;
    public static $table = null;
    public static $global = [];

    public function __construct()
    {
        global $table_prefix;

        self::$me = &$this;

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'admin_print_scripts', array( $this, 'javascripts' ) );
        add_action( 'admin_print_styles', array( $this, 'stylesheets' ) );

        // Set global table name
        self::$table = $table_prefix . self::$name;

        //intialize default config
        $saved_config = get_option( self::$name );
        if ( !empty( $saved_config ) && is_array( $saved_config ) ) {
            self::$config = $saved_config;
        }

        if ( empty( self::$config ) || self::$config['version'] != self::$version ) {
            include CTK_DIR . 'include/upgrade.php';
        }
    }

    public function init()
    {
        wp_register_script( 'captcha-tanya-komen', CTK_URL . 'script.js', ['jquery'], self::$version );
        wp_register_style( 'captcha-tanya-komen', CTK_URL . 'style.css', [], self::$version );

        //add_filter( 'comment_form_defaults', array( $this, 'comment_form_defaults' ), 999 );
        add_action( 'comment_form_after_fields', array( $this, 'comment_form_defaults' ) );
        add_filter( 'pre_comment_on_post', array( $this, 'pre_comment_on_post' ), 999 );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu()
    {
        add_submenu_page(
            'options-general.php',
            'Pengaturan Pertanyaan Kemanan pada Komentar',
            'Pertanyaan Kemanan',
            'administrator',
            'ctk-setting',
            array( $this, 'setting' ) );
    }
    public function setting()
    {
        if ( isset( $_POST['tanya'] ) && isset( $_POST['jawab'] ) &&
            is_array( $_POST['tanya'] ) && is_array( $_POST['jawab'] ) ) {
            $new_val = [];
            foreach ( $_POST['tanya'] as $i => $tanya ) {
                $new_val[] = [
                    'tanya' => $tanya,
                    'jawab' => $_POST['jawab'][$i],
                ];
            }
            self::save_config( 'pertanyaan', $new_val );
        }
        include CTK_DIR . 'page/setting.php';
    }

    public function javascripts()
    {
        wp_enqueue_script( 'captcha-tanya-komen' );
    }

    public function stylesheets()
    {
        wp_enqueue_style( 'captcha-tanya-komen' );
    }

    public function comment_form_defaults()
    {
        $jumlah = count( self::$config['pertanyaan'] );
        if ( $jumlah == 0 ) {
            return;
        }
        if ( $jumlah > 1 ) {
            $tanya = rand( 0, $jumlah - 1 );
        } else {
            $tanya = 1;
        }

        $pertanyaan = self::$config['pertanyaan'][$tanya]['tanya'];

        include CTK_DIR . 'page/tanya.php';
    }

    public function pre_comment_on_post( $data )
    {
        if ( is_user_logged_in() ) {
            return $data;
        }

        $jumlah = count( self::$config['pertanyaan'] );

        if ( !isset( $_POST['jawab'] ) || ( !isset( $_POST['tanya'] ) && $jumlah > 0 ) ) {
            wp_die( 'Gagal pertanyaan belum dijawab.' );
        }
        if ( $jumlah == 0 ) {
            return $data;
        }

        if ( empty( $_POST['jawab'] ) ) {
            wp_die( 'Pertanyaan Kemanan wajib di jawab!' );
        }
        $tanya = intval( $_POST['tanya'] );
        if ( $tanya < 0 || $tanya >= $jumlah ) {
            wp_die( 'Jawaban salah!' );
        }

        $jawab = strtolower( trim( $_POST['jawab'] ) );
        $kunci = strtolower( trim( self::$config['pertanyaan'][$tanya]['jawab'] ) );
        if ( $jawab != $kunci ) {
            wp_die( 'Jawaban salah.' );
        }

        return $data;
    }

    public static function save_config( $new_key = null, $new_val = null )
    {
        if ( !is_null( $new_key ) ) {
            self::$config[$new_key] = $new_val;
        }
        return update_option( self::$name, self::$config, true );
    }

    public static function run()
    {
        return self::$me ? self::$me : new TanyaKomen();
    }
}

$CTK = TanyaKomen::run();
