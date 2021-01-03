<?php
/**
 * Plugin Name: Doctor's Appointment
 * Plugin URI: https://github.com/sanjeevpuspam/doctor-appointment-leo-test
 * Description: Leo Doctor's appointment booking sample code with the shortcode <strong>[bookappointment]</strong>
 * Version: 0.1
 * Text Domain: 
 * Author: Sanjeev Puspam
 * Author URI: https://www.linkedin.com/in/sanjeevpuspam
 */

add_filter( 'auto_update_plugin', '__return_true' );
add_action('wp_head',function(){
    global $post;
    if ($post) {
        setup_postdata($post);
        $content = get_the_content();
        preg_match('/\[bookappointment\]/', $content, $matches);
        if ($matches) {
            echo '<style>#speciality, #doctors{display :none;}</style>';
        }
    }
});

add_action('wp_footer',function(){
    global $post;
    if ($post) {
        setup_postdata($post);
        $content = get_the_content();
        preg_match('/\[bookappointment\]/', $content, $matches);
        if ($matches) {
            echo "<script>
            function selectSpeciality(){
                var location = document.getElementById('location').value;
                if(location != -1){
                    document.getElementById('specialityselect').style.display = 'block';
                } else {
                    document.getElementById('specialityselect').style.display = 'none';
                    document.getElementById('doctorselect').style.display = 'none';
                }
            }
            function selectDoctor(){
                var doctor = document.getElementById('specialityselect').value;
                if(doctor != -1){
                    document.getElementById('doctorselect').style.display = 'block';
                } else {
                    document.getElementById('doctorselect').style.display = 'none';
                }
            }
            function bookAppointment(){
                var doctor = document.getElementById('doctorselect').value;
                if(doctor != -1){
                    var localtion  = document.getElementById('location').value;
                    var speciality = document.getElementById('specialityselect').value;
                    var doctor     = document.getElementById('doctorselect').value;
                    window.location.href = 'https://www.google.com?localtion='+localtion+'&speciality='+speciality+'&doctor='+doctor+'&is_submit=1';
                } else {
                    return false;
                }
            }  
        </script>";
        }
    }
});

function bookAppointment($atts) {
    $locationArray = array("Delhi","Gurgaon","Noida","Punjab","UP");
    $specialityArry = array("Dermatology","Anesthesiology","Family medicine");
    $doctorArray    = array("Dr. Ramesh","Dr. Mahesh","Dr. Amresh");

    $Content = "<div style='display:inline'><select name='country' onchange='selectSpeciality()' id='location'>";
    $Content .= "<option value='-1'>Select Location</option>";
    foreach($locationArray as $loc) {
        $Content .= "<option value='".strtolower($loc)."'>$loc</option>";
    }
    $Content .= "</select>";

    $Content .= "<select style='display:none' name='state' onchange='selectDoctor()' id='specialityselect'>";
    $Content .= "<option value='-1'>Select speciality</option>";
    foreach($specialityArry as $sp) {
        $Content .= "<option value='".strtolower($sp)."'>$sp</option>";
    }
    $Content .="</select>";

    $Content .= "<select style='display:none' onchange='bookAppointment()' name='state' id='doctorselect'>";
    $Content .= "<option value='-1'>Select Doctor</option>";
    foreach($doctorArray as $dr) {
        $Content .= "<option value='".strtolower($dr)."'>$dr</option>";
    }
    $Content .="</select></div>";
    return $Content;
}
if(is_user_logged_in()) {
	add_shortcode('bookappointment', 'bookAppointment');
}

