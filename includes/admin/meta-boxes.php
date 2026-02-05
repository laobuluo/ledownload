<?php
if (!defined('ABSPATH')) {
    exit;
}

// 添加下载设置元框
add_action('add_meta_boxes', 'ledownload_add_meta_boxes');
function ledownload_add_meta_boxes() {
    add_meta_box(
        'ledownload-settings',
        __('下载设置', 'ledownload'),
        'ledownload_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

// 元框回调函数
function ledownload_meta_box_callback($post) {
    // 添加nonce验证
    wp_nonce_field('ledownload_meta_box', 'ledownload_meta_box_nonce');

    // 获取已保存的值
    $enabled = get_post_meta($post->ID, 'ledownload_enabled', true);
    $title = get_post_meta($post->ID, 'ledownload_title', true);
    $description = get_post_meta($post->ID, 'ledownload_description', true);
    $file_url = get_post_meta($post->ID, 'ledownload_file_url', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="ledownload_enabled"><?php _e('启用下载模块', 'ledownload'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="ledownload_enabled" name="ledownload_enabled" value="1" <?php checked($enabled, '1'); ?> />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="ledownload_title"><?php _e('下载标题', 'ledownload'); ?></label>
            </th>
            <td>
                <input type="text" id="ledownload_title" name="ledownload_title" value="<?php echo esc_attr($title); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="ledownload_description"><?php _e('下载描述', 'ledownload'); ?></label>
            </th>
            <td>
                <textarea id="ledownload_description" name="ledownload_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="ledownload_file_url"><?php _e('文件URL', 'ledownload'); ?></label>
            </th>
            <td>
                <input type="text" id="ledownload_file_url" name="ledownload_file_url" value="<?php echo esc_url($file_url); ?>" class="large-text" />
                <button type="button" class="button-secondary" id="ledownload-file-button"><?php _e('选择文件', 'ledownload'); ?></button>
            </td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        $('#ledownload-file-button').click(function(e) {
            e.preventDefault();
            var mediaUploader = wp.media({
                title: '<?php _e("选择下载文件", "ledownload"); ?>',
                button: {
                    text: '<?php _e("使用此文件", "ledownload"); ?>'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#ledownload_file_url').val(attachment.url);
            });

            mediaUploader.open();
        });
    });
    </script>
    <?php
}

// 保存元框数据
add_action('save_post', 'ledownload_save_meta_box_data');
function ledownload_save_meta_box_data($post_id) {
    // 检查nonce
    if (!isset($_POST['ledownload_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['ledownload_meta_box_nonce'], 'ledownload_meta_box')) {
        return;
    }

    // 检查自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // 检查权限
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 保存数据
    $enabled = isset($_POST['ledownload_enabled']) ? '1' : '';
    update_post_meta($post_id, 'ledownload_enabled', $enabled);

    if (isset($_POST['ledownload_title'])) {
        update_post_meta($post_id, 'ledownload_title', sanitize_text_field($_POST['ledownload_title']));
    }

    if (isset($_POST['ledownload_description'])) {
        update_post_meta($post_id, 'ledownload_description', sanitize_textarea_field($_POST['ledownload_description']));
    }

    if (isset($_POST['ledownload_file_url'])) {
        update_post_meta($post_id, 'ledownload_file_url', esc_url_raw($_POST['ledownload_file_url']));
    }
}

// 加载媒体上传脚本
add_action('admin_enqueue_scripts', 'ledownload_meta_box_scripts');
function ledownload_meta_box_scripts($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }
    wp_enqueue_media();
}