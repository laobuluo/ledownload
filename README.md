# LeDownLoad

一款美观的 WordPress 单页文件下载插件，支持自定义下载参数和样式设置。

## 主要功能

- **文章内文件下载**：在自定义内容页面的文章中添加文件下载功能
- **美观的下载框架**：下载模块自动附注在文章底部，提供统一的视觉样式
- **灵活样式定制**：支持自定义下载模块外框、标题、描述、按钮的 CSS 样式
- **自定义图标**：可为下载模块添加小图标（建议 48×48px PNG 透明背景）
- **媒体库集成**：通过 WordPress 媒体库选择下载文件和图标图片

## 安装方法

1. 将 `ledownload` 文件夹上传到 `/wp-content/plugins/` 目录
2. 在 WordPress 后台 **插件** 列表中激活 LeDownLoad
3. 进入 **设置 → LeDownLoad** 进行基本配置

## 使用说明

### 全局设置

在 **设置 → LeDownLoad** 中可配置：

- **启用下载功能**：开启或关闭插件功能
- **自定义模块小图标**：设置下载模块前的图标（建议 48×48px PNG）
- **下载模块外框样式**：自定义容器的 CSS 样式
- **标题样式**：自定义下载标题的 CSS 样式
- **描述文字样式**：自定义描述文字的 CSS 样式
- **下载按钮样式**：自定义下载按钮的 CSS 样式

### 文章设置

在编辑文章时，会看到 **下载设置** 元框，可配置：

- **启用下载模块**：为该文章启用下载功能
- **下载标题**：显示在下载模块中的标题
- **下载描述**：对下载内容的简要说明
- **文件 URL**：下载文件的链接（可通过媒体库选择）

## 目录结构

```
ledownload/
├── assets/
│   └── css/
│       └── style.css      # 默认样式
├── includes/
│   ├── admin/
│   │   ├── admin-menu.php # 设置页面
│   │   └── meta-boxes.php # 文章编辑元框
│   └── frontend/
│       └── display.php    # 前端展示逻辑
├── ledownload.php         # 主插件文件
├── readme.txt             # WordPress 插件目录格式说明
└── README.md              # 本文件
```

## 插件团队和技术支持

[老蒋](https://www.laojiang.me/)（老蒋和他的伙伴们），本着资源共享原则，在运营网站过程中用到的或者是有需要用到的主题、插件资源，有选择的免费分享给广大的网友站长，希望能够帮助到你建站过程中提高效率。

感谢团队成员，以及网友提出的优化工具的建议，才有后续产品的不断迭代适合且满足用户需要。不能确保100%的符合兼容网站，我们也仅能做到在工作之余不断的接近和满足你的需要。

| 类目            | 信息                                                         |
| --------------- | ------------------------------------------------------------ |
| 插件更新地址    | https://www.laojiang.me/6070.html                            |
| 团队成员        | [老蒋](https://www.laojiang.me/)、老赵、[CNJOEL](https://www.rakvps.com/)、木村 |
| 支持网站        | [乐在云](https://www.lezaiyun.com/)、主机评价网              |
| 建站资源推荐    | [便宜VPS推荐](https://www.zhujipingjia.com/pianyivps.html)、[美国VPS推荐](https://www.zhujipingjia.com/uscn2gia.html)、[外贸建站主机](https://www.zhujipingjia.com/wordpress-hosting.html)、[SSL证书推荐](https://www.zhujipingjia.com/two-ssls.html)、[WordPress主机推荐](https://www.zhujipingjia.com/wpblog-host.html) |
| 提交WP官网（F） |                                                              |

![](wechat.png)

## 更新日志

### 1.0.0
- 首次发布

## 许可证

GPL v2 or later - [查看完整许可证](https://www.gnu.org/licenses/gpl-2.0.html)
