<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 


add_action( 'wp_ajax_get_srt_keywords_krt', 'get_srt_keywords_krt' );

function get_srt_keywords_krt() {
	
	check_ajax_referer( 'srt-ajax-nonce', 'security' );

	$keyword = sanitize_text_field($_POST['keyword']);
	$toolLanguage = sanitize_text_field($_POST['selectedlanguage']);
	$toolCountry = sanitize_text_field($_POST['selectedCountry']);
	$security = sanitize_text_field($_POST['security']);
	
	
	if (empty($security) or empty($keyword) or empty($toolLanguage) or empty($toolCountry)){
		print_r(json_encode(''));	
		wp_die();
	}
	

function get_srt_data($keyword, $toolLanguage, $toolCountry){
	
	$args = array(
		'user-agent'  => ''
	);
	
	$srt_engine = 'google';
	$srt_service_option = 'complete';
	$srt_service = 'suggestqueries';
	$srt_browser_option = 'firefox';
	$srt_option = 'search';
	
	$dataresponse = wp_remote_request( 'http://'.$srt_service.'.'.$srt_engine.'.com/'.$srt_service_option.'/'.$srt_option.'?output='.$srt_browser_option.'&client=psy-ab&gs_rn=64o&hl='.$toolLanguage.'&gl='.$toolCountry.'&q='.urlencode($keyword), $args );

	$data = $dataresponse['body'];	
	$responseCode = $dataresponse['response']['code'];
	
	if (!empty($responseCode) and $responseCode !== 200){
		print_r(json_encode(''));	
		wp_die();
	} 
	
	
	$data = htmlentities($data, ENT_NOQUOTES, "ISO-8859-1");
	
	
	if (($data = json_decode($data, true)) !== null) {
		$keywords = $data[1];
		$keywordsArray = [];
	
		foreach ($keywords as $key => $keywordResults){
			$keywordsArray[$key] = sanitize_text_field($keywordResults[0]);
		}
		
	} else {
		$keywords = '';	
	}
	
	return $keywordsArray;
}

$keywordSpace = $keyword.' ';

$primaryKeywordQueryClean = get_srt_data($keyword, $toolLanguage, $toolCountry);
$primaryKeywordQuerySpace = get_srt_data($keywordSpace, $toolLanguage, $toolCountry);
$keywordQueryCombined = array_merge($primaryKeywordQueryClean, $primaryKeywordQuerySpace);

array_unshift($keywordQueryCombined, $keyword);
$keywordQueryCombined = array_values(array_unique($keywordQueryCombined, SORT_REGULAR));

$secondaryKeywordArray = [];
foreach ($keywordQueryCombined as $key => $keywordInput){	
	if ($key <=5 ){	
		$keywordInput = strip_tags($keywordInput);
		$secondaryKeywordData = '';
		if (strtolower(trim($keywordInput)) !== strtolower(trim(strip_tags($keyword)))){
			$secondaryKeywordData = get_srt_data($keywordInput, $toolLanguage, $toolCountry);
			$secondaryKeywordArray = array_merge($secondaryKeywordArray, $secondaryKeywordData); 
		} 
	}

}
if (!empty($secondaryKeywordArray)){
	$keywordQueryCombined = array_merge($keywordQueryCombined, $secondaryKeywordArray);
	$keywordQueryCombined = array_values(array_unique($keywordQueryCombined, SORT_REGULAR));
}
print_r(json_encode($keywordQueryCombined));	

wp_die();
		
}