<?php
function ggc_hs_abm_shortcode( $atts = [], $content = null, $tag = '' ) {

	$utk = $_COOKIE['hubspotutk'];
	$url = 'http://api.hubapi.com/contacts/v1/contact/utk/'.$utk.'/profile?hapikey=5d3f209a-9b48-45f3-8c4c-108f049ebb2e';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	$response = json_decode($response);
	curl_close($ch);

		//PROPERTY TO EXCLUDE
    // extract( shortcode_atts( array(
    //       'value' => 'value',
    //       'property' => 'property',
		// 			'function' => 'function',
    // ), $atts ) );

		// RETRIEVE SHORT CODE ATTRIBUTES
    $values_string 	= strval( $atts['value'] );
		$property 			= strval( $atts['property'] );
		$display				= strval( $atts['display'] );

		$property_values = explode( ',', $values_string );

    //VALUE FROM HUBSPOT COOKIE
    $hs_property_value = strval($response->properties->$property->value);


		if($display == 'custom' ){

				$show = 'false';

				foreach( $property_values as $prop_val ){
						if( $prop_val == $hs_property_value ){
							$show = 'true';
							break;
						}else{
							$show = 'false';
						}
				}

				if( $show == 'true' ){
					$new_content = $content;
				}else{
					$new_content = '';
				}

		}


		if($display == 'default' ){

				$show = 'false';

				foreach( $property_values as $prop_val ){
						if( $prop_val == $hs_property_value ){
							$show = 'false';
							break;
						}else{
							$show = 'true';
						}
				}

				if( $show == 'true' ){
					$new_content = $content;
				}else{
					$new_content = '';
				}

		}



 	return $new_content;


}
add_shortcode( 'hs_abm', 'ggc_hs_abm_shortcode' );

function ggc_hs_property_shortcode( $atts = [], $content = null ) {
	$utk = $_COOKIE['hubspotutk'];
	$url = 'http://api.hubapi.com/contacts/v1/contact/utk/'.$utk.'/profile?hapikey=5d3f209a-9b48-45f3-8c4c-108f049ebb2e';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	$response = json_decode($response);
	curl_close($ch);

	$property 	= strval( $atts['property'] );
	$hs_property_value = strval($response->properties->$property->value);

	return $hs_property_value;
}
add_shortcode( 'hs_property', 'ggc_hs_property_shortcode' );
?>
