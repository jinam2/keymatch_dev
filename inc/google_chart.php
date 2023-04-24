<?

function graph_data_remake($graph_data){
	//데이터 검증하고 부족한 부분 매꿔주자.
	$tmp_graph_data		= explode(",",$graph_data);
	$success_graph_data = "";
	foreach( $tmp_graph_data as $key => $value ){
		$tmp = explode(",",$value);
		if( $tmp[0] == '' ){
			continue;
		}
		else if( $tmp[1] == ']' ){
			$tmp[1] = 0;
		}
		$success_graph_data	.= $tmp[0].",".$tmp[1]."";
	}
	return $success_graph_data;
}

//구글 area 그래프
function google_area_graph_js($function_name,$graph_div_id,$graph_data,$columns,$options)
{

	$showTextEvery		= $options['showTextEvery'];
	$colors				= $options['colors'];
	$series				= "";
	if ($options['series'] != "")
	{
		$series				= ",series: [".$options['series']."]";
	}

	$js = "";
	$js = "
		google.charts.setOnLoadCallback(".$function_name.");

		function ".$function_name."()
		{
			var data1 = new google.visualization.DataTable();

			data1.addColumn('string', '".$columns[0]."');		// Implicit domain label col.
			data1.addColumn('number', '".$columns[1]."');		// Implicit series 1 data col.
			";
			if (count($columns) > 2)
			{
				for($i=2;$i<count($columns); $i++)
				{
		$js .= "
			data1.addColumn('number', '".$columns[$i]."');		// Implicit series 1 data col.
		";
				}
			}
	$js .= "

			data1.addRows([
				//['2019-01',1.12],
				".$graph_data."
			]);

			var options1 = {
				title: '',
				hAxis: { title: '',  titleTextStyle: {color: '#333'}, showTextEvery:".$showTextEvery." },
				vAxis: { title: '', minValue: 0},

				//색상
				colors:['".$colors."'],
				chartArea: {
					left:0,
					top:20,
					width:'100%',
					height:'75%'
				},

				//포인트
				legend: 'none',
				pointSize: 5,
				dataOpacity: 0.7,
				series: {
					0: { pointShape: 'circle' }
				}
				".$series."
		";
		$js .= "

			};


			var chart1 = new google.visualization.AreaChart(document.getElementById('".$graph_div_id."'));
			chart1.draw(data1, options1);
		}
	";

	return $js;
}

//구글 pie 그래프
function google_pie_graph_js($function_name,$graph_div_id,$graph_data,$columns,$options)
{
	$sliceVisibilityThreshold		= $options['sliceVisibilityThreshold'];

	$slices				= "";
	if ($options['slices'] != "")
	{
		$slices				= ",slices: {".$options['slices']."}";
	}
	$etc				= $options['etc'];

	$js = "";
	$js = "
		google.charts.setOnLoadCallback(".$function_name.");

		function ".$function_name."()
		{
			var data = new google.visualization.DataTable();
			data.addColumn('string', '".$columns[0]."'); // Implicit domain label col.
			data.addColumn('number', '".$columns[1]."'); // Implicit series 1 data col.
			data.addRows([
				".$graph_data."
			]);


			var options = {
				title: '',
				chartArea: {left:50, top:10, bottom:10, width:'100%', height:'100%' },
				sliceVisibilityThreshold: ".$sliceVisibilityThreshold."
				".$etc."
				".$slices."
			};

			var chart = new google.visualization.PieChart(document.getElementById('".$graph_div_id."'));
			chart.draw(data, options);
		}
	";

	return $js;
}

//구글 Bar 그래프
function google_bar_graph_js($function_name,$graph_div_id,$graph_data,$columns,$options)
{
	$colors		= $options['colors'];
	$height		= $options['height'];

	$js = "";
	$js = "
		google.charts.setOnLoadCallback(".$function_name.");

		function ".$function_name."()
		{
			var data = new google.visualization.DataTable();
			data.addColumn('string', '".$columns[0]."'); // Implicit domain label col.
			data.addColumn('number', '".$columns[1]."'); // Implicit series 1 data col.
			data.addRows([
				".$graph_data."
			]);


			var options = {

				title: '',
				width: '100%',
				height: ".$height.",
				colors: ['".$colors."'],

				legend: { position: 'none' },
				bars: 'horizontal', // Required for Material Bar Charts.
				hAxis: {format: 'decimal'},
				bar: { groupWidth: '90%' }

			};

			var chart = new google.charts.Bar(document.getElementById('".$graph_div_id."'));
			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	";

	return $js;

}



function google_double_bar_graph_js($function_name,$graph_div_id,$graph_data,$columns,$options)
{
	$width		= $options['width'];
	$height		= $options['height'];
	$x_title	= $options['x_title'];

	$js = "";
	$js = "
		google.charts.setOnLoadCallback(".$function_name.");

		function ".$function_name."()
		{
			var data = google.visualization.arrayToDataTable([
				$graph_data
			]);

			var options = {
				height:$height,
				chartArea: {top:10, width:'$width'},
				hAxis: {
				  title: '$x_title',
				  minValue: 0
				},
				vAxis: {
				  title: ''
				}
			};

			//var chart = new google.charts.Bar(document.getElementById('".$graph_div_id."'));
			//chart.draw(data, google.charts.Bar.convertOptions(options));
			var chart = new google.visualization.BarChart(document.getElementById('".$graph_div_id."'));
			chart.draw(data, options);
		}
	";

	return $js;

}



function google_area_graph_data_str($data_str)
{
	$graph_data_txt			= "";

	if ( strlen($data_str) < 5 )
	{
		$no_sample = '';
		for ($i = 1 ; $i <= 30 ; $i++)
		{
			if ($i == '30')
			{
				$mark_num= '1';
			}
			else
			{
				$mark_num= '0';
			}

			$no_sample .= "['정보없음$i',$mark_num],\n";
		}

		$graph_data_txt = $no_sample;
	}
	else
	{
		$gDatas			= explode("\n",$data_str);
		$comma			= "";
		foreach($gDatas as $k => $data)
		{
			if (count(explode("|",$data)) > 2)
			{
				$data_Array	= explode("|",$data);
				$graph_data_txt .= "{$comma}[";
				$i	= 0;
				foreach($data_Array as $key => $val)
				{
					if ($i==0)
					{
						$graph_data_txt .= "'$val'";
					}
					else
					{
						$graph_data_txt .= ",$val";
					}
					$i++;
				}
				$graph_data_txt .= "]\n";

			}
			else
			{
				list($txt,$cnt) = explode("|",$data);
				$cnt	= ( $cnt == '' )?'0':$cnt;
				$txt = kstrcut($txt, 40 , "...");
				$graph_data_txt .= "{$comma}['$txt',$cnt]\n";
			}
			$comma			= ",";
		}
	}

	return $graph_data_txt;
}

function google_pie_graph_data_str($data_str)
{
	$graph_data_txt			= "";

	if ( strlen($data_str) < 5 )
	{
		$no_sample = '';
		for ($i = 1 ; $i <= 5 ; $i++)
		{
			if ($i == '5')
			{
				$mark_num= '1';
			}
			else
			{
				$mark_num= '0';
			}

			$no_sample .= "['정보없음$i',$mark_num],\n";
		}

		$graph_data_txt = $no_sample;
	}
	else
	{
		$gDatas			= explode("\n",$data_str);
		$comma			= "";
		foreach($gDatas as $k => $data)
		{
			list($txt,$cnt) = explode("|",$data);
			$cnt	= ( $cnt == '' )?'0':$cnt;
			$txt = kstrcut($txt, 40 , "...");
			$graph_data_txt .= "{$comma}['$txt',$cnt]\n";
			$comma			= ",";
		}
	}

	return $graph_data_txt;
}

function google_keyword_graph_data_str($data_str)
{
	$graph_data_txt			= "";

	if ( strlen($data_str) < 5 )
	{
		$no_sample = '';
		for ($i = 1 ; $i <= 100 ; $i++)
		{
			if ($i == '100')
			{
				$mark_num= '1';
			}
			else
			{
				$mark_num= '0';
			}

			$no_sample .= "['정보없음$i',$mark_num],\n";
		}

		$graph_data_txt = $no_sample;
	}
	else
	{
		$gDatas			= explode("\n",$data_str);
		$comma			= "";
		foreach($gDatas as $k => $data)
		{
			#검색단어키워드면 맨앞에꺼는 날린다
			if ( $k == 0 )
			{

			}
			else
			{
				list($txt,$cnt) = explode("|",$data);
				$cnt	= ( $cnt == '' )?'0':$cnt;
				$graph_data_txt .= "{$comma}['$txt',$cnt]\n";
				$comma			= ",";
			}
		}
	}

	return $graph_data_txt;
}

?>