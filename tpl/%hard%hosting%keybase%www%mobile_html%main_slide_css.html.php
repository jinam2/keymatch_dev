<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_2000224479 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
	<STYLE type='text/css'>
		#container_slides {
			width:100%;
			z-index:1;
		}
		#slides { width:100%;
			display:none;
			position:relative;
		}

		.slidesjs-pagination {
			vertical-align:top;
			height:18px;
			list-style:none;
			position:absolute;
			top:10px;
			margin: 6px 0 0;
			right:0;
			z-index:100;
			overflow:hidden;
		}
		.slidesjs-pagination li { display:inline-block;_display:inline;margin:0 1px;_zoom:1 }
		.slidesjs-pagination li a {
			display: block;
			width:28px;
			padding-top:250px;
			background:url('<?=$_data['스킨폴더명']?>/img/slide_supersized/nav-dot_mobile.png') no-repeat 0 -20px;
			cursor:pointer;
		}

		.slidesjs-pagination li a.active,
		.slidesjs-pagination li a:hover.active { background-position:0 0px }
		.slidesjs-pagination li a:hover { background-position:0 -20px }

	</STYLE>
<? }
?>