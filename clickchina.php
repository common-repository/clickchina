<?PHP
/**
 * @author liming and 飘叶寻梦
 * readme.txt
 */

@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
ob_start();
session_start();
session_register('verifysession');
header("Content-type: image/png");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
//$liulanqi="L_".$_SERVER['HTTP_USER_AGENT'];
//根据设置及用户语言判断验证码语言
//$clickchina_language = get_option('clickchina-language');
$user_lan=$_SESSION['userlan'];
if($user_lan == "en")
$click = imagecreatefrompng('click_en.png');
else
$click = imagecreatefrompng('click.png');
$im = imagecreate(200, 100);
$click_type = rand(0, 3); //随机选择最大/最小数字或唯一字母或数字
//$click_type = 3;
$text_y = 14*$click_type;
$color = imagecolorallocate($im, 0, 0, 0);
imagecopy($im, $click, 0, 0, 0, 0, 200, 100);

/* 绘图代码 Start */

$image_xy = array(3, 19, 196, 96); //暂时用不到
$xp_true = array();
$number = range(0, 9);
$del = rand(2, 5); //随机删除字符数量
$xp_xy = array(
    array(3, 3, 38, 58),
    array(3, 59, 38, 96),
    array(39, 59, 78, 96),
    array(40, 20, 78, 58),
    array(80, 20, 121, 58),
    array(79, 59, 121, 96),
    array(122, 59, 161, 96),
    array(122, 20, 161, 58),
    array(162, 3, 196, 58),
    array(162, 59, 196, 96)
);
switch($click_type){
    /*case 5: //最大的圆圈
        xp_image(3, 3, 51, 1);
    break;
    case 4: //最大的方框
        xp_image(3, 3, 51, 0);
    break;*/ //功能有待开发
    case 3: //唯一的数字
    case 2: //唯一的字母
        if($click_type==2){
            $xp_rand = rand(0, 24);
            $xp_rand = $xp_rand>=14?$xp_rand+1:$xp_rand; //去除字母“O”
            $xp_true['num'] = chr(65+$xp_rand);
            $number[0] = $xp_true['num']; //去除数字“0”
        }else{
            $xp_cur = rand(1, 9); //去除数字“0”
            $xp_true['num'] = $number[$xp_cur];
            foreach($number as $val=>$key){
                if($key!=$xp_cur){
                    $xp_rand = rand(0, 24);
                    $xp_rand = $xp_rand>=14?$xp_rand+1:$xp_rand; //去除字母“O”
                    $number[$val] = chr(65+$xp_rand);
                }
            }
        }
        while(count($number)!=0){
            $is_arc = rand(0, 1);
            shuffle($number);
            shuffle($xp_xy);
            $cur_xy = array_shift($xp_xy);
            $xp_x = rand($cur_xy[0], $cur_xy[2]-26);
            $xp_y = rand($cur_xy[1], $cur_xy[3]-26);
            $cur_num = array_shift($number);
            if($del>0&&$xp_true['num']!=$cur_num&&rand(0, 1)==1){
                --$del;
            }else{
                xp_image($xp_x, $xp_y, 27, $is_arc, $cur_num);
                if($xp_true['num']==$cur_num){
                    $xp_true['xy'] = $xp_x.','.$xp_y.',26';
                }
            }
        }
    break;
    case 1: //最小的数字
    default: //最大的数字
        $xp_true['num'] = $click_type==1?9:0;
        while(count($number)!=0){
            $is_arc = rand(0, 1);
            shuffle($number);
            shuffle($xp_xy);
            $cur_xy = array_shift($xp_xy);
            $xp_x = rand($cur_xy[0], $cur_xy[2]-26);
            $xp_y = rand($cur_xy[1], $cur_xy[3]-26);
            $cur_num = array_shift($number);
            //echo $xp_x.', '.$xp_y.'<br />';
            if($del>0&&rand(0, 1)==1){
                --$del;
            }else{
                xp_image($xp_x, $xp_y, 27, $is_arc, $cur_num);
                if($click_type==1){
                    if($xp_true['num']>$cur_num){
                        $xp_true['num'] = $cur_num;
                        $xp_true['xy'] = $xp_x.','.$xp_y.',26';
                    }
                }else{
                    if($xp_true['num']<$cur_num){
                        $xp_true['num'] = $cur_num;
                        $xp_true['xy'] = $xp_x.','.$xp_y.',26';
                    }
                }
            }
        }
    break;
}
$_SESSION['verifysession'] = isset($xp_true['xy'])?$xp_true['xy']:'';
/* 绘图代码 End */

imagecopy($im, $click, 46, 5, 200, $text_y, 108, 14);
//imagestring($im, 1, 0, 0, $xp_true['num'].','.$xp_true['xy'], $color);
imagepng($im);
imagedestroy($im);
imagedestroy($click);
flush();
ob_flush();
function xp_image($xp_x, $xp_y, $xp_wh, $xp_type='none', $xp_text=''){
    global $im, $click, $color;
    $xp_center = ceil($xp_wh/2);
    $center_x = $xp_x+$xp_center-1;
    $center_y = $xp_y+$xp_center-1;
    /* $xp_number = array(
        'x' => array(205, 216, 227, 238, 249, 205, 216, 227, 238, 249),
        'y' => array(59, 59, 59, 59, 59, 74, 74, 74, 74, 74)
    ); //数字的坐标 */
    switch($xp_type){
        case 1:
        imagearc($im, $center_x, $center_y, $xp_wh, $xp_wh, 0, 360, $color);
        break;
        default:
        $xp_x2 = $xp_x+$xp_wh-1;
        $xp_y2 = $xp_y+$xp_wh-1;
        imageline($im, $xp_x, $xp_y, $xp_x2, $xp_y, $color);
        imageline($im, $xp_x, $xp_y, $xp_x, $xp_y2, $color);
        imageline($im, $xp_x, $xp_y2, $xp_x2, $xp_y2, $color);
        imageline($im, $xp_x2, $xp_y, $xp_x2, $xp_y2, $color);
        break;
    }
    unset($_SESSION['userlan']);
    if(isset($xp_text))
    imagestring($im, 5, $center_x-4, $center_y-7, $xp_text, $color);
    //if(!empty($xp_num))imagecopy($im, $click, $center_x-3, $center_y-5, $xp_number['x'][$xp_num], $xp_number['y'][$xp_num], 7, 11); //从图片加载数字，效果太差所以没用
}
?>