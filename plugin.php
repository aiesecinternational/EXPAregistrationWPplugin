<?php
/*
Plugin Name: AIESEC EXPA Registration 
Description: Plugin based on gis_curl_registration script by Dan Laush upgraded to Wordpress plugin
Version: 0.1
Author: Krzysztof Jackowski
Author URI: https://www.linkedin.com/profile/view?id=202008277&trk=nav_responsive_tab_profile_pic
License: GPL 
*/
wp_enqueue_script('jquery');
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

// [expa-form program="gt"]

function expa_form( $atts ) {
    $a = shortcode_atts( array(
        'program' => '',
    ), $atts );
    
    $configs = include('config.php');
        
    $form = file_get_contents('form.html',TRUE);
    
    $leads_json = plugins_url('leads.json', __FILE__ );

    $json = file_get_contents($leads_json, false, stream_context_create($arrContextOptions)); 
    $leads = json_decode($json); 
    $option_list = "";
    foreach($leads as $key => $value){
        $option_list = $option_list.'<option value="'.$key.'">'.$key.'</option>'."\n";//var_dump($lead->);    
    }
    $form = str_replace("{path-gis_reg_process}",plugins_url('gis_reg_process.php', __FILE__ ),$form);
    $form = str_replace("{path-gis_lcMapper}",plugins_url('gis_lcMapper.js', __FILE__ ),$form);
    $form = str_replace("{path-leads-json}",plugins_url('leads.json', __FILE__ ),$form);
    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $form = str_replace("{website_url}",$actual_link,$form);
    $form = str_replace("{leads-option-list}",$option_list,$form);
    $form = str_replace("{name}",$configs["name"],$form);
    $form = str_replace("{surname}",$configs["surname"],$form);
    $form = str_replace("{e-mail}",$configs["e-mail"],$form);
    $form = str_replace("{password}",$configs["password"],$form);
    $form = str_replace("{lead-name}",$configs["lead-name"],$form);
    $form = str_replace("{lc}",$configs["lc"],$form);
    
    
    if($_GET["thank_you"]==="true"){
        return $configs["thank-you-message"]; 
    } elseif ($_GET["error"]!=""){
        
        $form = str_replace('<div id="error" class="error"><p></p></div>','<div id="error" class="error"><p>'.$_GET["error"].'</p></div>',$form);
        return $form;    
    }
    //var_dump( plugins_url('gis_reg_process.php', __FILE__ ));
    return $form;
}
add_shortcode( 'expa-form', 'expa_form' );

?>
