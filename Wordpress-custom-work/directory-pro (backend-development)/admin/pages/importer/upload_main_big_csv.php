<?php

$csv = file_get_contents( get_attached_file($csv_file_id) );
if($csv === false){	
	
	$url=get_attached_file($csv_file_id);
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$csv = curl_exec($ch);
}
$csv_rows = explode( "\n", $csv );
$total_rows = count( $csv_rows );
// Store the title row. This will be written at the top of every file.
$title_row = $csv_rows[ 0 ];
/* Calculate the number of rows that will consist of 10, and then calculate
 * the number of rows for the final file.
 *
 * We use floor() so we don't round up by one.
 */
 update_option( 'eppro_total_row',$total_rows-1);	
 update_option( 'eppro_current_row','1');	
 
$title_row_array= explode(",",$title_row);




$maping='';
$main_fields =array('id','post_title','post_content','category','tag','featured-image','image_gallery_urls','address','area','latitude','longitude','city','postcode','state','country','phone','contact-email','contact_web','youtube-video','facebook','linkedin','vimeo');

$default_fields = array();
$field_set=get_option('iv_directories_fields' );
$custom_field='';
if($field_set!=""){ 
		$default_fields=get_option('iv_directories_fields' );
}else{															
		$default_fields['business_type']='Business Type';
		$default_fields['main_products']='Main Products';
		$default_fields['number_of_employees']='Number Of Employees';
		$default_fields['main_markets']='Main Markets';
		$default_fields['total_annual_sales_volume']='Total Annual Sales Volume';	
}
if(sizeof($default_fields )){			
	foreach( $default_fields as $field_key => $field_value ) { 
			array_push($main_fields, $field_key);
	}					
}
$i=0;

$maping=$maping.'<form id="csv_maping" name="csv_maping" ><table class="table  table-striped">
  <thead>
    <tr>    
      <th>'.esc_html__('Post Field/Map to field', 'ivdirectories' ).'</th>
      <th>'.esc_html__('CSV Column Title/Name', 'ivdirectories' ).'</th>      
    </tr>
  </thead>';
  
foreach($title_row_array as $one_col){
	$sel_name= str_replace (' ','-', $one_col);
	$maping=$maping.'<tr><td><select name="'.trim($sel_name).'">';
	$maping=$maping.'<option value="">'.esc_html__('Email', 'ivdirectories' ).'</option>';
	$ii=0;
	foreach($main_fields as $main_one){		
		$maping=$maping.'<option value="'.$main_one.'" '.($i==$ii?' selected':"").'>'.$main_one.'</option>';		
		$ii++;
	}	
	$maping=$maping.'</select></td>';
	$maping=$maping.'<td>'.$one_col.'<input type="hidden" name="column'.$i.'" value="'.$one_col.'"></td>';
	$maping=$maping.'</tr>';	
	
 $i++;	
}

$maping=$maping.'</table></form>';

?>