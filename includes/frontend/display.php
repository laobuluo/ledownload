<?php
if (!defined('ABSPATH')) {
    exit;
}

// 在文章内容后添加下载模块
add_filter('the_content', 'ledownload_append_download_module');
function ledownload_append_download_module($content) {
    // 只在单篇文章页面显示
    if (!is_single()) {
        return $content;
    }

    // 获取文章ID
    $post_id = get_the_ID();
    if (!$post_id) {
        return $content;
    }

    // 检查是否启用下载模块
    $enabled = get_post_meta($post_id, 'ledownload_enabled', true);
    if (!$enabled) {
        return $content;
    }

    // 获取下载信息
    $title = get_post_meta($post_id, 'ledownload_title', true);
    $description = get_post_meta($post_id, 'ledownload_description', true);
    $file_url = get_post_meta($post_id, 'ledownload_file_url', true);

    // 获取全局设置
    $options = get_option('ledownload_options');
    $icon_url = $options['icon_url'] ?? '';

    // 加载默认样式
    wp_enqueue_style('ledownload-style', LEDOWNLOAD_PLUGIN_URL . 'assets/css/style.css', array(), LEDOWNLOAD_VERSION);

    // 添加自定义CSS
    $custom_css = '';
    if (!empty($options['container_css'])) {
        $custom_css .= ".ledownload-container {" . $options['container_css'] . "}\n";
    }
    if (!empty($options['title_css'])) {
        $custom_css .= ".ledownload-title {" . $options['title_css'] . "}\n";
    }
    if (!empty($options['description_css'])) {
        $custom_css .= ".ledownload-description {" . $options['description_css'] . "}\n";
    }
    if (!empty($options['button_css'])) {
        $custom_css .= ".ledownload-button {" . $options['button_css'] . "}\n";
    }
    if (!empty($custom_css)) {
        wp_add_inline_style('ledownload-style', $custom_css);
    }

    // 构建下载模块HTML
    $html = '<div class="ledownload-container">';
    // 左侧图标区域
    if ($icon_url) {
        $html .= '<div class="ledownload-icon"><img src="' . esc_url($icon_url) . '" alt="download icon"></div>';
    }
    // 中间内容区域
    $html .= '<div class="ledownload-content">';
    if ($title) {
        $html .= '<h4 class="ledownload-title">' . esc_html($title) . '</h4>';
    }
    if ($description) {
        $html .= '<p class="ledownload-description">' . esc_html($description) . '</p>';
    }
    $html .= '</div>';
    // 右侧下载按钮区域
    if ($file_url) {
        $html .= '<div class="ledownload-button-wrapper"><a href="' . esc_url($file_url) . '" class="ledownload-button" target="_blank">' . __('下载文件', 'ledownload') . '</a></div>';
    }
    $html .= '</div>';


    // 将下载模块添加到文章内容末尾
    return $content . $html;
}