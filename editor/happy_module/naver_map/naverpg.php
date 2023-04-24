<?
	function newPaging( $totalList, $listScale, $pageScale, $startPage, $prexImgName, $nextImgName, $search) {
		$paging	= "<font style='font-size:13px'>";

		$nowPage	= ($startPage / $listScale) + 1;

		$Start		= ( $nowPage - $pageScale > 0 )?$nowPage-$pageScale:0;
		$Start		= ( $Start - 1 < 0 )?0:$Start-1;
		$End		= $nowPage+$pageScale;
		//$paging	= $nowPage." - ".$Start."<br>";


		if( $totalList > $listScale ) {

			if ( $nowPage - 1 > 0 )
			{
				$prePage	= ($nowPage-2)*$listScale;
				$paging	.= "<a href='$_SERVER[PHP_SELF]?start=".$prePage.$search."' onfocus=this.blur()>$prexImgName</a>";
			}
			else
				$paging	.= "$prexImgName";

			for( $j=$Start; $j<$End; $j++ ) {
				$nextPage = $j * $listScale;
				$pageNum = $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {

						$paging	.= "<div style='float:left; width:16px; height:16px; padding:2px; border:1px solid #BBB;'><div><a href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."' onfocus=this.blur()>$pageNum</a></div></div>";
					} else {
						$paging	.= "<div style='float:left; width:22px; height:16px; padding:2px; border:1px solid red; background-color:red;><div><a href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."' onfocus=this.blur()><font color=white><b>$pageNum</b></font></a></div></div>";
					}
				}
			}

			if ( ($nowPage*$listScale) < $totalList )
			{
				$nNextPage	= ($nowPage)*$listScale;
				$paging	.= "<a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur()>$nextImgName</a>";
			}
			else
				$paging	.= "$nextImgName";

		}
		if( $totalList <= $listScale) {
			$paging	.= "<div style='float:left; width:16px; height:16px; padding:2px; border:1px solid #BBB; background-color:red;><div><a href='$_SERVER[PHP_SELF]?start=0".$search."' onfocus=this.blur()><font color='white'>1</font></b></a></div></div>";
		}
		$paging	.= "</font>";
		return $paging;
	}

?>