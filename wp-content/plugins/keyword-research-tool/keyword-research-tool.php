<?php
/*
Plugin Name: Keyword Research Tool
Plugin URI: 
Description: <strong>Keyword Research</strong> made simple for Wordpress. Enter your <strong>keyword</strong> and quickly discover keyword opportunities related to your topic.
Version: 1.8.1
Author: Jasja ter horst - SEO Review Tools
Author URI: https://www.seoreviewtools.com
Author Email: jasja@seoreviewtools.com
License:
 
  Copyright 2023  (jasja@seoreviewtools.com)
 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.
 
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 
  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.
 
*/


if ( ! defined( 'ABSPATH' ) ) exit; 


class srtKwTool {
 
    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/
 
    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {
		
		 
        // Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
        register_uninstall_hook( __FILE__, 'uninstall_removedata'); 	

		
		// plugin Menu //	
		add_action( 'admin_menu', 'srt_keyword_tool_plugin_menu' );

		if (is_admin() ) {
			include_once( plugin_dir_path( __FILE__ ) . '/keywords.php' );
		}
		
		function srt_keyword_tool_plugin_menu() {
			add_menu_page( 
				'Keyword Research Tool ', 
				'KW Research Tool', 
				'manage_options', 
				'keyword-research-tool', 
				'srt_keyword_tool_options', 
				plugins_url( '/images/icon.png', __FILE__ ), 
				6  
			);
		}
		
		function srt_keyword_tool_options() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			
			// get full plugin URL
			$pluginUrl = plugin_dir_url( __FILE__ ) ;
			
		
		?>
            <style>
				
				#srt-kw-table {width:100%;}
				.srt-control {width:100%; }
				.srt-control.selected-keywords {padding:10px; margin:20px auto; background:#f9f9f9;}
				#srt-kw-table td, #srt-kw-table th{padding:12px 12px;}
				#srt-kw-table th{text-align:left;}
				.srt-column-row {clear:both; overflow:hidden;}
				.srt-column-left {float:left; width:70%;}
				.srt-column-right {float:left; width:29%; margin-left:1%; }
				.srt-wp-panel-look {  padding:20px; background:#fff; border: 1px solid #e5e5e5; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin:10px auto;}
				.srt-wp-panel-look.search-input { padding:5px 20px; background:#fff; border: 1px solid #e5e5e5; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
				#srt-kw-table select {color:#777;}
				#kw-search-submit.button.button-success {background-color: #79bf7e; color:#fff; border-color: #4cae4c; font-size:15px;}
				#srt-language-specifics {
					line-height: 20px;
					height: 42px;
					margin-top: -1px;
					padding: 0 20px;
				}
				
				.srt-search-holder {margin-left:0px;}
				.srt-search-holder .dashicons {
					font-size: 36px;
					padding: 4px 40px 0 0px;
					color: #79bf7e;
				}
				
				#kw-search-submit { height: 41px;}
				#kw-search-input {width:400px; padding:5px 10px 7px 10px;}
				
				
				.keyword-tool .button .dashicons {line-height:1.2;}
				
				.srt-footer a {text-decoration:none;}
				.srt-footer .srt-logo {
					max-width: 20px;
					margin-bottom: -6px;
					display: inline-block;
					padding: 0 0px 0 7px;
				}
				
				.srt-footer .linkedin {
					max-width: 17px;
					margin-bottom: -4px;
				}
				.keyword-tool a.black-link {color:#000;}
				
				.wrap h2.srt-title {
					padding-top: 25px;
				}				
				h2 .dashicons.dashicons-search {
					font-size: 25px;
					margin-right: 8px;
					background: #fff;
					padding: 12px 18px 17px 13px;
					border-radius: 50%;
					display: inline-block;
					color: #5d237a;
					box-shadow: 0px 0px 8px #ccc;
					margin-top: -7px;
				}
				
				#srt-kw-table tr:hover td {background:#f3f9f4; color:#000;}
				.keyword-tool table .dashicons {color:#aaa; padding:10px; cursor:pointer;}
				.keyword-tool table .dashicons:hover {color:#000;}
				
				/* The container */
				.keyword-tool .container-checkbox {
					display: block;
					position: relative;
					padding-left: 35px;
					margin-bottom: 12px;
					cursor: pointer;
					font-size: 22px;
					-webkit-user-select: none;
					-moz-user-select: none;
					-ms-user-select: none;
					user-select: none;
				}
								
				/* Hide the browser's default checkbox */
				.keyword-tool .container-checkbox input {
					position: absolute;
					opacity: 0;
					cursor: pointer;
					height: 0;
					width: 0;
				}
				
				/* Create a custom checkbox */
				.keyword-tool .checkmark {
					position: absolute;
					top: 20%;
					left: 0;
					height: 25px;
					width: 25px;
					background-color: #f9f9f9;
					border:1px solid #ddd;
				}
				
				/* On mouse-over, add a grey background color */
				.keyword-tool .container-checkbox:hover input ~ .checkmark {
					background-color: #f9f9f9;
					border:1px solid #ddd;
				}
				
				/* When the checkbox is checked, add a blue background */
				.keyword-tool .container-checkbox input:checked ~ .checkmark {
					background-color: #79bf7e;
					border:1px solid #fff;
				}
				
				
				.keyword-tool .container-checkbox .table-text {
				
					
					font-size: 15px;
					font-weight: normal;
					display: inline-table;
					margin-left: 20px;
				
				}
				#srt-kw-table .table-text {
					padding-top: 8px;
				}
				
				.keyword-tool .checkmark:after {
					content: "";
					position: absolute;
					display: none;
				}
				
				/* Show the checkmark when checked */
				.keyword-tool .container-checkbox input:checked ~ .checkmark:after {
					display: block;
				}
				
				/* Style the checkmark/indicator */
				.keyword-tool .container-checkbox .checkmark:after {
					left: 9px;
					top: 5px;
					width: 4px;
					height: 9px;
					border: solid white;
					border-width: 0 3px 3px 0;
					-webkit-transform: rotate(45deg);
					-ms-transform: rotate(45deg);
					transform: rotate(45deg);
				}
				.srt-hide {display:none;}

            </style>
            
            
            <script>
			

			
			jQuery(function() {
				
				function runTools (keywordInput, selectedCountry, selectedlanguage) {	
					var srt_data = {
						'action': 'get_srt_keywords_krt',
						'selectedCountry': selectedCountry, 
						'selectedlanguage': selectedlanguage,
						'keyword': keywordInput, 
						'security': '<?php echo wp_create_nonce( "srt-ajax-nonce" ); ?>'
					};
					
					jQuery.post(ajaxurl, srt_data, function(response) {
						
						
						kw_data = JSON.parse(response); 

						jQuery('#srt-kw-table tbody').empty();
						
						// array empty or does not exist
						if ( kw_data[0] === undefined || kw_data[0].length == 0) {
							jQuery('#srt-kw-table').append('<tr><td></td><td colspan="2"> Sorry, no results found for your input.</td></tr>');
						} else {
						
							var arrayLength = kw_data.length;
							for (var i = 0; i < arrayLength; i++) {
								var keyword = kw_data[i];
								
								var keywordResultClean = keyword.replace(/(<([^>]+)>)/ig,"");
								
								jQuery('#srt-kw-table').append('<tr><td>'+(i+1)+'</td><td class="checkbox-select"><label class="container-checkbox"><span class="table-text">'+keyword+'</span><input type="checkbox" name="select-kw" class="checkbox-select" value="'+keywordResultClean+'" /><span class="checkmark"></span></label></td><td class="additional-search"><span title="Get keywords"data-keyword="'+keywordResultClean+'" class="dashicons dashicons-search"></span></td></tr>');
						
							}
						}		
						
						return kw_data;
						
					});
					

				}
				
				
				// remove textarea items
				jQuery('.clear-checkbox').click(function (e) {    
					var txt = jQuery(this).text();
						jQuery('input:checkbox').prop('checked',false);            
						jQuery('#selected-keywords').val(''); 
						jQuery('button.check-checkbox').text('Check All');
				});
							
				function processKwDataInput (srtKeyword){
					if(srtKeyword){
						jQuery('#kw-search-input').val(srtKeyword);
					}else{
						var srtKeyword = jQuery('#kw-search-input').val();
					}
					if (srtKeyword != '') {
						var languageSpecifics = jQuery('#srt-language-specifics').find(":selected").val();
						var languageSpecificsArray = languageSpecifics.split('-');
						var selectedCountry = languageSpecificsArray[0];					
						var selectedlanguage = languageSpecificsArray[1];
						var dataOutput  = runTools(srtKeyword, selectedCountry, selectedlanguage); 
						jQuery('.srt-visibility').removeClass('srt-hide');
					}
				}
				

				/* copy to clipboard */  
				jQuery('.copy-clipboard').click(function (e)  {
					var copyText = document.getElementById("selected-keywords");
				  	copyText.select();
				  	document.execCommand("copy");
				});
				
				  
				// press search button
				jQuery('#kw-search-submit').click(function (e)  {
					processKwDataInput ('');
				});
				 
				// enter search input field 
				jQuery("#kw-search-input").keypress(function(e) {
					if(e.which == 13) {
						processKwDataInput ('');
					}
				});
				
				// click search icon
				jQuery(document).on('click', '.additional-search .dashicons-search', function(){
					var srtKeyword = jQuery(this).data('keyword');
					processKwDataInput (srtKeyword);
				});
				
			});
			
			

			
			jQuery(document).on('click', '.checkbox-select input', function(){
				
				var checkedVal = jQuery(this).val();
				
				if (jQuery(this).prop('checked')){
					var currentKeywords = jQuery('.selected-keywords').val(); 	
					jQuery('.selected-keywords').val(currentKeywords+(currentKeywords!=''? '\r\n' : '')+checkedVal);
				} else {
					var allVals = [];
					var currentKeywords = jQuery('.selected-keywords').val();
					
					var currentKeywordsArray = currentKeywords.split('\n');
					
					var filtered = currentKeywordsArray.filter(function (el) {
					  return el != checkedVal;
					});
					
					var filteredKeywordsArray = filtered;

					var stringValues = filteredKeywordsArray.join('\r\n');	
					jQuery('.selected-keywords').val(stringValues);

					
					
				}
				var currentKeywords = jQuery('.selected-keywords').val();
				 
			});

			
			
			
			
			</script>
            
            <?php	
			

			
		
			
			echo '
			
			<div class="wrap keyword-tool">
				<h2 class="srt-title"><span class="dashicons dashicons-search"></span> Keyword Research Tool</h2>
				<p>Enter your <strong>keyword</strong> and quickly discover keyword opportunities related to your topic. </p>
				<div class="srt-wp-panel-look search-input">
					<p class="srt-search-holder">
						<span class="dashicons dashicons-arrow-right-alt"></span> 	
							<input type="search" id="kw-search-input" name="s" placeholder="Enter your keyword" value="">
							<select value="" name="country" id="srt-language-specifics" class="form-control">
								<optgroup label="North america">
									<option value="us-en">United States</option>
									<option value="ca-en">Canada</option>
								</optgroup>
								<optgroup label="Europe">
									<option value="uk-en">United Kingdom</option>
									<option value="nl-nl">Netherlands</option>
									<option value="be-fr">Belgium (FR)</option>
									<option value="be-nl">Belgium (NL)</option>
									<option value="de-de">Germany</option>
									<option value="fr-fr">France</option>
									<option value="dk-dk">Denmark</option>
									<option value="ie-ie">Ireland</option>
									<option value="it-it">Italy</option>   
									<option value="es-es">Spain</option>
									<option value="pt-pt">Portugal</option>
								</optgroup>	
								<optgroup label="Other">
									<option value="au-en">Australia</option>
									<option value="nz-en">New Zealand (EN)</option>
								</optgroup>
						</select>							
						<input type="submit" id="kw-search-submit" class="button button-success" value="Search">
					</p>
				</div>
				
				
				<div class="srt-column-row">
					<div class="srt-column-left">
						<div class="srt-wp-panel-look">
							<table id="srt-kw-table" class="striped">
							<thead>
								<tr>
								<th style="width:5%;">#</th>
								<th style="width:80%;">Keyword</th>
								<th style="width:15%;">Get suggestions</th>
								</tr>
							<thead>
							<tbody>
								<tr>
								<td></td>
								<td colspan="2"> Enter your keyword to generate a list of related search queries.</td>
								</tr>
							
							</tbody>
							</table>
						</div>
					</div>
					
					<div class="srt-column-right">
						<div class="srt-wp-panel-look  srt-visibility srt-hide">
							<div class="panel-group">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h2><span class="dashicons dashicons-editor-alignleft"></span> Selected keywords</h2>
									</div>
									<div id="questions-box" class="panel-collapse collapse in" aria-expanded="true" style="">
										<div class="panel-body">
											<textarea id="selected-keywords" class="srt-control selected-keywords" placeholder="Selected keywords will automatically appear in this box" rows="10"></textarea>
											<button class="button button copy-clipboard feedback-message" data-message="Text copied to clipboard" data-autoclose="1"><span class="dashicons dashicons-editor-paste-word"></span> Copy text</button>
											<button type="button" class="button clear-checkbox"> <span class="dashicons dashicons-trash"></span> Clear</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<div class="srt-wp-panel-look srt-visibility srt-hide">
		
						<p><strong>Like this plugin?</strong></p>
						<p>Consider making a donation!</p>
						<p><a class="button button-primary" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=V6Z2QZHGBUC7Q&source=url" target="_blank">Donate <span class="dashicons dashicons-thumbs-up"></span> </a></p>
					</div>
					</div>
				</div>
				<div class="srt-wp-panel-look srt-footer ">
					<p>Developed by: <img class="srt-logo linkedin" alt="Jasja ter Horst" src="'.$pluginUrl.'images/LinkedIn.png"> <a class="black-link" href="https://nl.linkedin.com/in/jasja" target="_blank"><strong>Jasja ter Horst</strong></a> from <img class="srt-logo" alt="SEO Review Tools" src="'.$pluginUrl.'images/seo-review-tools.png"> <a href="https://www.seoreviewtools.com/" target="_blank"><strong>SEO Review Tools</strong></a> -- Like this plugin? Consider making a <a class="button button" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=V6Z2QZHGBUC7Q&source=url" target="_blank">Donation <span class="dashicons dashicons-thumbs-up"></span> </a>   </p>	
				</div>
			</div>';
			
			
		
		}	
		
    } // end constructor
 
 
    public function activate( $network_wide ) {   
    } // end activate
 
    public function deactivate( $network_wide ) {     
    } // end deactivate
    
    public function uninstall( $network_wide ) {
    } // end uninstall
 
 
    /*--------------------------------------------*
     * Core Functions
     *---------------------------------------------*/


 
} // end class
 
$plugin_name = new srtKwTool();