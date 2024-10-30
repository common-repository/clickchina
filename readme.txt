=== ClickChina ===
Contributors: q409640976
Donate link: http://jishigu.com/
Tags: clickchina, spam, antispam, anti-spam, comments, comment, captcha, clickcha, comment spam
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

防止垃圾评论插件,点击正确的图形提交评论,仿"Clickcha"(Click on the Right picture to submit comments,to prevent spam comments,as clickcha)

== Description ==

防止垃圾评论插件,点击正确的图形提交评论(仿wp-Clickcha),使用简单，自动识别用户语言中文或者英文。不必连接指定服务器,速度更快,没有广告。we can stop spam comments,as clickcha,Click on the Right picture to submit comments,Automatic recognition of user language,it's Open source,and not need to connect to other servers，so it's Faster,And no Ads.

[查看演示：](http://jishigu.com/2163.html "Clickchina演示") 你可以查看评论效果.

[See Demo](http://jishigu.com/2163.html "Clickchina Demo") to use Clickchina to send a comment.

== Installation ==

1. (上传至插件目录)Upload me to the /wp-content/plugins/,
2. (激活插件)Activate the plugin through the 'Plugins' menu in WordPress.
3. (模板中的comments.php文件，如果没有这段代码`<?php do_action('comment_form', $post->ID); ?>`，请添加到`</form>`前)
If your theme doesn't have the code`<?php do_action('comment_form', $post->ID); ?>`, you must add them before the closing `</form>` tag in the `comments.php` file of the theme.
4. (如果你的模板评论使用了ajax,请不要使用本插件)we are conflicting with "ajax" comment theme.

== Changelog ==

= 1.0 =
* 第一次上传 begin.

= 1.01 =
* 自动识别用户语言Automatic recognition of user language.

= 1.02 =
* 自动隐藏提交按钮Automatically hide the submit button

= 1.03 =
* 添加语言设置 Add language settings options
== Screenshots ==
1. 只需要点击正确的图形，就能提交评论.
2. Just need one click to send your comment.

