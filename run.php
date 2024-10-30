<?php
/*
Plugin Name: ClickChina
Plugin URI: http://jishigu.com/2163.html
Description: 防止垃圾评论插件,点击正确的图形提交评论(仿wp-Clickcha),使用简单。不必连接指定服务器,速度更快,没有广告。we can stop spam comments,as clickcha,Click on the Right picture to submit comments,it's Open source,and not need to connect to other servers，so it's Faster,And no Ads.
Version: 1.03
Author: liming
Author URI: http://jishigu.com
*/
if(!class_exists('clickchina')):
class clickchina {
	
	function plugin_url(){
		return get_option('home').'/wp-content/plugins/clickchina';
	}

	function is_loggin(){
		return is_user_logged_in();
	}

function clickchina() {
		@session_start();
		add_action('comment_form', array(& $this, 'comment_seccode'));//comment in web
		add_filter('preprocess_comment', array(& $this, 'preprocess_comment'));//is right?
		add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'clickchina_add_action_links' );
	function clickchina_add_action_links( $links ) {
		$link = '<a href="options-general.php?page=clickchina">Setting(设置)<a>'; 
		array_unshift( $links, $link ); 
		return $links; 
			}
		// Add admin menu for settings
		add_action('admin_menu', 'add_to_option_page');
	function add_to_option_page() {
   	 	// Add a new submenu under options:
    	add_options_page('ClickChina', 'ClickChina', 'edit_themes', 'ClickChina', 'here_is_options_page');
			}
	function here_is_options_page() {
		if(isset($_POST['save-language'])) {
			update_option('clickchina-language',$_POST['clickchina-language']);
			echo "<div id='message' class='updated fade'><p>ClickChina settings saved.</p></div>";
    }
	$clickchina_language = get_option('clickchina-language');
		if($clickchina_language=="en" || $clickchina_language=="cn")
			$clickchina_language = $clickchina_language;
		else
			$clickchina_language ="auto";
   ?>
	<div class="wrap"><h2>ClickChina Settings</h2>


	<div>
	<table style="width: 500px; float: left">	
			<h3 class="title">警告Warning！</h3>
<p>1.<strong><font color="#ff0000">此插件和Ajax评论冲突</font></strong><br>
This Plugin Conflicting with "ajax" comment;</p>
<p>2.请关闭其他验证码插件<br>
  Please Close other CAPTCHA Plugins;</p>
<p>3.<a href="http://wordpress.org/extend/plugins/clickchina/installation/" title="help" target="_blank">安装帮助(Help)</a></p>
			<form name="site" action="" method="post" id="clickchina-form">
	
		<tr>
			<td style="width: 100px"><label for="clickchina-public-key">Language(语言):</label>
			<img width="1" height="1" src="http://img.tongji.linezing.com/1742496/tongji.gif"/>
				</td>
			<td style="width: 200px">
			<select name="clickchina-language" id="clickchina-language" style="width: 90%" />
				<option value="auto" <?php if($clickchina_language == "auto") echo "selected";?>>Auto(自动)</option>
				<option value="cn" <?php if($clickchina_language == "cn") echo "selected";?> >中文</option>
				<option value="en" <?php if($clickchina_language == "en") echo "selected";?> >English</option>
			</select>
			</td>
		</tr>
		<tr>
			<td class="submit"><input name="save-language" id="save-language" type="submit" style="font-weight: bold;" value="Save Settings" /></td>
		</tr>
				</form>	
</table>
	</div>

</div>	
			
	
	<?php
    }
}
    function comment_seccode() {
    	session_start();
			session_register('userlan');		
		$clickchina_language = get_option('clickchina-language');	
		$user_language="en";
		if($clickchina_language=="en" || $clickchina_language=="cn")
			$user_language = $clickchina_language;
		else
			{
				$lang = "l".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
			if(strpos($lang,"zh"))
				$user_language="cn";
			else
				$user_language="en";
			}
		$_SESSION['userlan'] =$user_language;
		if(!$this->is_loggin()) {
		$lang = "l".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$str = 'Click the right image To submit your comment：';
		if($user_language=="cn")
			$str = '点击正确的图片来提交评论:';		
		$str.= '<div id="clickchina">';
		$str.='<input type="image" name="submit1" id="submit1" style="border:none;padding:0" src="'.$this->plugin_url().'/clickchina.php?q='.rand(0,100000).'"/>';
		$str.='<span></span></div><style type="text/css">#submitx, #commentform input[type="submit"], #commentform button[type="submit"], #commentform span.submit {display: none;}</style>';
		echo $str;
	}
	else
	echo '';
    }
    function preprocess_comment($commentdata) {
if(!$this->is_loggin()){
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
				wp_die('非post');
}
 if(isset($_POST['submit1_x'])&&isset($_POST['submit1_y'])){
    $xp_xy = isset($_SESSION['verifysession'])?$_SESSION['verifysession']:NULL;
    $xp_xy = explode(',', $xp_xy);
    $show_xy = $_POST['submit1_x'].', '.$_POST['submit1_y'];
    $istrue=false;
    if(isset($xp_xy[2])){
        $xp_x = range($xp_xy[0], $xp_xy[0]+$xp_xy[2]-1);
        $xp_y = range($xp_xy[1], $xp_xy[1]+$xp_xy[2]-1);
        if(in_array($_POST['submit1_x'], $xp_x)&&in_array($_POST['submit1_y'], $xp_y)){
            $istrue=true;
        }
    }
    if(!$istrue)
    {
    	$lang = "l".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
			if(strpos($lang,"zh"))
				wp_die('图形点击错误,请返回刷新');
			else
				wp_die('You clicked The wrong picture,Please try again');
    }
    			
 }			
else wp_die('错误请求');	
unset($_SESSION['verifysession']);
}
        return $commentdata;
    }
}
endif;
if( !isset($clickchina) ) {
	$clickchina =& new clickchina();
}
?>