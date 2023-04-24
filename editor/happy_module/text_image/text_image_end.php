<?php
include_once("../config.php");

/*	필수체크	*/
if( $_POST['title'] == '' )
{
	msg("텍스트를 입력해 주세요.");
}
if( $_POST['width'] == '' )
{
	msg("가로 길이 를 입력해 주세요.");
}
if( $_POST['height'] == '' )
{
	msg("세로 길이 를 입력해 주세요.");
}
if( $_POST['font_size'] == '' )
{
	msg("폰트 크기를 입력해 주세요.");
}
if( $_POST['outfont'] == '' )
{
	msg("폰트 종류를 선택 하세요.");
}
if( $_POST['format'] == '' )
{
	msg("이미지 종류를 선택 하세요.");
}
if( $_POST['fcolor'] == '' )
{
	msg("폰트 색상을 입력해 주세요.");
}
if( $_POST['bgcolor'] == '' )
{
	msg("폰트 배경색상을 입력해 하세요.");
}
if( $_POST['quality'] == '' )
{
	msg("글씨의 퀄리티를 설정하세요.");
}

/*	필수체크	*/
if( preg_match("/rgb/i",$_POST['fcolor']) )
{
	$_POST['fcolor']		= str_replace("rgb(","",str_replace(")","",str_replace(" ","",$_POST['fcolor'])));
}
if( preg_match("/rgb/i",$_POST['bgcolor']) )
{
	$_POST['bgcolor']		= str_replace("rgb(","",str_replace(")","",str_replace(" ","",$_POST['bgcolor'])));
}

if( $_POST['width_auto'] == 'y' )
{
	$_POST['width']			= '';
}

if( $_POST['height_auto'] == 'y' )
{
	$_POST['height']			= '';
}
make_text_image_tag();
?>