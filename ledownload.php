<?php
/**
 * Plugin Name: LeDownLoad
 * Plugin URI: https://www.lezaiyun.com/879.html
 * Description: 一款美观的WordPress单页文件下载插件，支持自定义下载参数和样式设置。（公众号：老蒋朋友圈）
 * Version: 1.0.0
 * Author: 老蒋和他的小伙伴
 * Author URI: https://www.lezaiyun.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ledownload
 */

if (!defined('ABSPATH')) {
    exit;
}

// 定义插件常量
define('LEDOWNLOAD_VERSION', '1.0.0');
define('LEDOWNLOAD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LEDOWNLOAD_PLUGIN_URL', plugin_dir_url(__FILE__));

// 插件激活时的钩子
register_activation_hook(__FILE__, 'ledownload_activate');
function ledownload_activate() {
    // 设置默认选项
    $default_options = array(
        'enabled' => false,
        'container_css' => 'max-width: 800px; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; margin: 20px auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;',
        'title_css' => 'font-size: 20px; color: #333; margin: 0 0 8px 0; font-weight: 600;',
        'description_css' => 'color: #666; font-size: 14px; margin: 0; line-height: 1.6;',
        'button_css' => 'background: #4A90E2; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; transition: all 0.3s ease; border: none; cursor: pointer; font-size: 14px; box-shadow: 0 2px 4px rgba(74,144,226,0.2); white-space: nowrap;',
        'icon_url' => ''
    );
    add_option('ledownload_options', $default_options);
}

// 插件停用时的钩子
register_deactivation_hook(__FILE__, 'ledownload_deactivate');
function ledownload_deactivate() {
    // 停用时的清理工作
}

// 插件卸载时的钩子
register_uninstall_hook(__FILE__, 'ledownload_uninstall');
function ledownload_uninstall() {
    // 删除插件选项
    delete_option('ledownload_options');
    // 删除文章meta数据
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE 'ledownload_%'");
}

// 加载插件文件
require_once LEDOWNLOAD_PLUGIN_DIR . 'includes/admin/admin-menu.php';
require_once LEDOWNLOAD_PLUGIN_DIR . 'includes/admin/meta-boxes.php';
require_once LEDOWNLOAD_PLUGIN_DIR . 'includes/frontend/display.php';

// 初始化插件
add_action('plugins_loaded', 'ledownload_init');
function ledownload_init() {
    // 加载文本域
    load_plugin_textdomain('ledownload', false, dirname(plugin_basename(__FILE__)) . '/languages');
}