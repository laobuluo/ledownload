<?php
if (!defined('ABSPATH')) {
    exit;
}

// 添加管理菜单
add_action('admin_menu', 'ledownload_add_admin_menu');
function ledownload_add_admin_menu() {
    add_options_page(
        __('LeDownLoad 设置', 'ledownload'),
        __('LeDownLoad', 'ledownload'),
        'manage_options',
        'ledownload-settings',
        'ledownload_settings_page'
    );
}

// 注册设置
add_action('admin_init', 'ledownload_register_settings');
function ledownload_register_settings() {
    register_setting('ledownload_options', 'ledownload_options');
}

// 设置页面内容
function ledownload_settings_page() {
    $options = get_option('ledownload_options');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p>下载插件的基本设置。插件详细介绍：<a href="https://www.laojiang.me/6070.html" target="_blank">插件介绍</a>。公众号：老蒋朋友圈。</p>
        <form method="post" action="options.php">
            <?php
            settings_fields('ledownload_options');
            do_settings_sections('ledownload-settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('启用下载功能', 'ledownload'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="ledownload_options[enabled]" value="1" <?php checked(isset($options['enabled']) ? $options['enabled'] : false); ?> />
                            <?php _e('启用', 'ledownload'); ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('自定义模块小图标', 'ledownload'); ?></th>
                    <td>
                        <input type="text" name="ledownload_options[icon_url]" value="<?php echo esc_url($options['icon_url'] ?? ''); ?>" class="regular-text" />
                        <button type="button" class="button-secondary" id="ledownload-media-button"><?php _e('选择图片', 'ledownload'); ?></button>
                        <p class="description"><?php _e('选择或输入模块前面小图标（建议PNG透明背景图标48*48px）', 'ledownload'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('下载模块外框样式', 'ledownload'); ?></th>
                    <td>
                        <input type="text" name="ledownload_options[container_css]" value="<?php echo esc_attr($options['container_css'] ?? ''); ?>" class="large-text" />
                        <p class="description"><?php _e('自定义下载模块外框的CSS样式', 'ledownload'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('标题样式', 'ledownload'); ?></th>
                    <td>
                        <input type="text" name="ledownload_options[title_css]" value="<?php echo esc_attr($options['title_css'] ?? ''); ?>" class="large-text" />
                        <p class="description"><?php _e('自定义下载标题的CSS样式', 'ledownload'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('描述文字样式', 'ledownload'); ?></th>
                    <td>
                        <input type="text" name="ledownload_options[description_css]" value="<?php echo esc_attr($options['description_css'] ?? ''); ?>" class="large-text" />
                        <p class="description"><?php _e('自定义下载描述的CSS样式', 'ledownload'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('下载按钮样式', 'ledownload'); ?></th>
                    <td>
                        <input type="text" name="ledownload_options[button_css]" value="<?php echo esc_attr($options['button_css'] ?? ''); ?>" class="large-text" />
                        <p class="description"><?php _e('自定义下载按钮的CSS样式', 'ledownload'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#ledownload-media-button').click(function(e) {
            e.preventDefault();
            var mediaUploader = wp.media({
                title: '<?php _e("选择图标", "ledownload"); ?>',
                button: {
                    text: '<?php _e("使用此图片", "ledownload"); ?>'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('input[name="ledownload_options[icon_url]"]').val(attachment.url);
            });

            mediaUploader.open();
        });
    });
    </script>
    <?php
}

// 加载媒体上传脚本
add_action('admin_enqueue_scripts', 'ledownload_admin_scripts');
function ledownload_admin_scripts($hook) {
    if ('settings_page_ledownload-settings' !== $hook) {
        return;
    }
    wp_enqueue_media();
}