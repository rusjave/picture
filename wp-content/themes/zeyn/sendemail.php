<?php
    /*print_r(dirname(__FILE__));
    exit;*/
    //require_once( dirname(__FILE__) . '/wp-load.php' );
    require_once( '../../../wp-load.php' );
    require( ABSPATH . WPINC . '/pluggable.php' );

/*    if (function_exists('wp_mail')) {
        echo 'has function';
        exit;
    } else {
        echo 'no function';
        exit;
    }
*/
    //$targetemail = 'your_em@il.com';
    //$targetemail = 'atawai@djavaweb.com';
    //$targetemail = 'dasril.mail@gmail.com';
    
    $targetemail = $_POST['hiddenEmail'];

    $name = $_POST['inputFullname'];

    $email = $_POST['inputEmail'];

    $phone = $_POST['inputPhone'];

    $message = $_POST['inputMessage'];


    $num1 = isset($_POST['num1']) ? $_POST['num1'] : "";
    $num2 = isset($_POST['num2']) ? $_POST['num2'] : "";
    $total = isset($_POST['captcha']) ? $_POST['captcha'] : "";

    $captcha_error = captcha_validation($num1, $num2, $total);

    if (is_null($captcha_error)) { 
        $fullmessage = __('Name : ','detheme') . $name . '<br />' .

        __('Email : ','detheme') . $email . '<br />' .

        __('Phone : ','detheme') . $phone . '<br />' .

        __('Message : ','detheme') . $message . '<br />';

        $headers = 'MIME-Version: 1.0' . '\r\n';
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . '\r\n';

        if (function_exists('wp_mail')) {
                add_filter( 'wp_mail_content_type', 'set_html_content_type' );

                wp_mail($targetemail, __("Contact from ",'detheme') . $name, $fullmessage);
        } else {
                mail($targetemail, __("Contact from ",'detheme') . $name, $fullmessage);
        }
    }

    function captcha_validation($num1, $num2, $total) {
            global $error;
            //Captcha check - $num1 + $num = $total
            if( intval($num1) + intval($num2) == intval($total) ) {
                    $error = null;
            }
            else {
                    $error = __("Captcha value is wrong.","");
            }
            return $error;
    }


    function set_html_content_type() {
        return 'text/html';
    }
    
?>
