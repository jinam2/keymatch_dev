<?PHP
include("config.php");

// Optional: instance name (might be used to adjust the server folders for example)
$CKEditor = $_GET['CKEditor'];

// Required: Function number as indicated by CKEditor.
$funcNum = $_GET['CKEditorFuncNum'];

// Optional: To provide localized messages
$langCode = $_GET['langCode'] ;

$tmp_name = $_FILES['upload']['tmp_name'];

// Check if this uploader has been enabled.
if ( !$Config['Enabled'] )
{
	//SendResults( '1', '', '', 'This file uploader is disabled. Please check the "editor/filemanager/upload/php/config.php" file' ) ;
	SendResults2( $funcNum, '', 'This file uploader is disabled.' );
	exit;
}

// Check if the file has been correctly uploaded.
//if ( !isset( $_FILES['NewFile'] ) || is_null( $_FILES['NewFile']['tmp_name'] ) || $_FILES['NewFile']['name'] == '' )
if ( !isset( $_FILES['upload'] ) || is_null( $_FILES['upload']['tmp_name'] ) || $_FILES['upload']['name'] == '' )
{
	//SendResults( '202' ) ;
	SendResults2( $funcNum,'','업로드가 실패했습니다.다시 시도해주세요.' ) ;
	exit;
}


// Get the posted file.
$oFile = $_FILES['upload'] ;

// Get the uploaded file name extension.
$sFileName = $oFile['name'] ;

// Replace dots in the name with underscores (only one dot can be there... security issue).
if ( $Config['ForceSingleExtension'] )
{
	$sFileName = preg_replace( '/\\.(?![^.]*$)/', '_', $sFileName ) ;
}

$sOriginalFileName = $sFileName ;


#이미지 새이름부여
$get_time = happy_mktime();
$rand_number =  rand(0,100);
$temp_name = explode(".",$sOriginalFileName);
$ext = strtolower($temp_name[sizeof($temp_name)-1]);
$new_file_name = "$get_time-$rand_number.$ext";
$sFileName = $new_file_name;
#SendResults( '1', '', '', "$new_file_name" );
#exit;

// Get the extension.
$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
$sExtension = strtolower( $sExtension ) ;

// The the file type (from the QueryString, by default 'File').
$sType = isset( $_GET['type'] ) ? $_GET['type'] : 'File' ;

// Check if it is an allowed type.
if ( !in_array( $sType, array('File','Images','Flash','Media') ) )
{
    //SendResults( 1, '', '', 'Invalid type specified' ) ;
	SendResults( $funcNum, '', 'Invalid type specified' ) ;
	exit;
}

// Get the allowed and denied extensions arrays.
$arAllowed	= $Config['AllowedExtensions'][$sType] ;
$arDenied	= $Config['DeniedExtensions'][$sType] ;

// Check if it is an allowed extension.
if ( ( count($arAllowed) > 0 && !in_array( $sExtension, $arAllowed ) ) || ( count($arDenied) > 0 && in_array( $sExtension, $arDenied ) ) )
{
	//SendResults( '202' ) ;
	SendResults2( $funcNum,'','업로드가 실패했습니다.다시 시도해주세요.' ) ;
	exit;
}

$happy_ext = array('php','php2','php3','php4','php5',
					'phtml','pwml','inc','asp','aspx',
					'ascx','jsp','cfm','cfc','pl','bat',
					'exe','com','dll','vbs','js',
					'reg','cgi','html','htm','shtml') ;
if ( in_array($sExtension,$happy_ext) )
{
	//SendResults( '1', '', '', "업로드 하실수 없는 확장자입니다" ) ;
	SendResults2( $funcNum, '', "업로드 하실수 없는 확장자입니다" ) ;
	exit;
}


$sServerDir = $Config['UserFilesAbsolutePath'] ;

#실제 파일업로드 경로
$sFilePath = $sServerDir . $sFileName ;
$cFilePath	= $Config['UserFilesPath'].$sFileName;

//echo $sFilePath;
move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;


//$tmp_name2 = base64_encode($tmp_name);
//$sFilePath2 = base64_encode($sFilePath);
//$sFileName2 = base64_encode($sFileName);

?>
<script>
//var file_name = '';
//var message = '';

window.parent.CKEDITOR.tools.callFunction(<?=$funcNum?>,'',function() {

	//alert(funcNum);

    // Get the reference to a dialog window.
    var element,
        dialog = this.getDialog();


	//alert(dialog.getName());
    // Check if this is the Image dialog window.
    if ( dialog.getName() == 'link' || dialog.getName() == 'image' )
	{
		file_name = '<?=$cFilePath?>';
		upload_success(file_name);
    }




    // Return false to stop further execution - in such case CKEditor will ignore the second argument (fileUrl)
    // and the onSelect function assigned to a button that called the file browser (if defined).
    return false;
});


function upload_success(file_name)
{
	message = '업로드가 완료되었습니다';
	window.parent.CKEDITOR.tools.callFunction(<?=$funcNum?>,file_name,message);
}
</script>

<?
exit;
?>