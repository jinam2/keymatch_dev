/*
 해피CGI 솔루션외 사용을 금합니다.
*/

// Register the related command.
FCKCommands.RegisterCommand( 'navermaps', new FCKDialogCommand( 'navermaps','Naver Map (네이버지도)', FCKPlugins.Items['navermaps'].Path + 'navermaps.php', FCKConfig.NaverMaps_Tool_Width, FCKConfig.NaverMaps_Tool_Height ) ) ;

// Create the "navermaps" toolbar button.
var onavermapsItem = new FCKToolbarButton( 'navermaps', 'Naver Map', 'Naver Map (네이버지도)', null, null, false, true) ;
onavermapsItem.IconPath = FCKPlugins.Items['navermaps'].Path + 'navermaps.gif' ;
onavermapsItem.IconSize = 20;

FCKToolbarItems.RegisterItem( 'navermaps', onavermapsItem ) ;

