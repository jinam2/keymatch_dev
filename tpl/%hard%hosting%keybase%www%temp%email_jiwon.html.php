<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 09:45:25 */
function SkyTpl_Func_566494920 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="font-family:'Noto Sans KR', sans-serif; width:1000px; margin:40px auto; border:1px solid #ddd; border-radius:15px; box-sizing:border-box; background:#f5f5f5; overflow:hidden;">
	<a href="<?=$_data['main_url']?>" style="display:block; text-align:center; margin:2.5% auto;"><img src="<?=$_data['main_logo_src']?>" style="max-height:40px; height:100%; "></a>
	<div style="font-family:'Noto Sans KR', sans-serif;padding:15px; box-sizing:border-box; background:#274c7f; text-align:center; width:95%; margin:2.5% auto; border-radius:10px;">
		<strong style="font-family:'Noto Sans KR', sans-serif;font-size:24px; color:#fff; letter-spacing:-1px; font-weight:500;">온라인입사지원 등록 알림 메일</strong>
		<p style="font-family:'Noto Sans KR', sans-serif;margin:5px 0 0; font-size:14px; color:#fff; letter-spacing:-0.5px;">기업회원님이 등록하신 채용정보에 접수된 온라인 입사지원이 있습니다.</p>
	</div>
	<div style="padding:15px; box-sizing:border-box; background:#fff; margin:40px auto 0; width:95%; border:1px solid #ddd; border-radius:15px; box-sizing:border-box;">
		<h3 style="margin:0; margin-bottom:10px; font-size:20px;font-family:'Noto Sans KR', sans-serif;">등록한 공고</h3>
		<table style="border-collapse:collapse; width:100%;">
			<colgroup>
				<col width="18%"/>
				<col width="82%"/>
			</colgroup>
			<tbody>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;"><span>채용공고</span></th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['COM']['guin_title']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;"><span>마감일</span></th>					
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['guin_end_date']?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="padding:15px; box-sizing:border-box; background:#fff; margin:40px auto 0; width:95%; border:1px solid #ddd; border-radius:15px; box-sizing:border-box;">
		<h3 style="font-family:'Noto Sans KR', sans-serif;margin:0; margin-bottom:10px; font-size:20px;">지원자 정보</h3>
		<table style="border-collapse:collapse; width:100%;">
			<colgroup>
				<col width="18%"/>
				<col width="82%"/>
			</colgroup>
			<tbody>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">이력서</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['PER']['title']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">이름</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['per_name']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">성별</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['PER']['user_prefix']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">연령</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['PER']['user_age']?>세</td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">주소</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;">[<?=$_data['PER']['user_zipcode']?>]<br><?=$_data['PER']['user_addr1']?> <?=$_data['PER']['user_addr2']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">경력사항</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['경력사항']?></td>
				</tr>
				<tr>
					<th style="font-family:'Noto Sans KR', sans-serif;background:#fafafa; font-weight:400; font-size:16px; padding:8px 16px; border:1px solid #ccc;">열람 현황</th>
					<td style="font-family:'Noto Sans KR', sans-serif;font-size:16px; padding:8px 16px; border:1px solid #ccc;"><?=$_data['read_ok']?></td>
				</tr>
			</tbody>
		</table>		
	</div>
	<p style="width:200px; margin:40px auto;">
		<a href="<?=$_data['이력서상세페이지주소']?>" target="_blank"  style="font-family:'Noto Sans KR', sans-serif; border:1px solid #ddd; box-sizing:border-box; display:block; padding:10px; font-size:18px; color:#fff; background:#666; border-radius:5px;  text-align:center; text-decoration:none; width:100%; ">이력서 자세히보기</a>
	</p>
	
</div>
<? }
?>