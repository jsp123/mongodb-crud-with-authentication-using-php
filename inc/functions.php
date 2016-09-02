<?php 

function generate_random_code($length=10) {

	$string = '';
	$characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

	for ($p = 0; $p < $length; $p++) {
	   $string .= $characters[mt_rand(0, strlen($characters)-1)];
	}

	return $string;
}

function pr( $a ) {
	print( '<pre>' ); print_r( $a ); print( '</pre>' );
}

function limit_words($text, $limit) {
		
	$words = explode(" ",$text);
	
	return implode(" ",array_splice($words,0,$limit));
	
}

/**
 * compress_output();
 *
 * This function seem reliable in terms of full code compression, 
 * but the problem is that it also removes spaces between commas.
 * Only use this when compressing DOM elements, like header or footer output.
 *
 */
function compress_output( $buffer ) {

    # remove comments, tabs, spaces, newlines, etc.
	$search = array(
		"/\/\*(.*?)\*\/|[\t\r\n]/s" => "",
		"/ +\{ +|\{ +| +\{/" => "{",
		"/ +\} +|\} +| +\}/" => "}",
		"/ +: +|: +| +:/" => ":",
		"/ +; +|; +| +;/" => ";",
		"/ +, +|, +| +,/" => ","
	);
	$buffer = preg_replace(array_keys($search), array_values($search), $buffer);
	
	return $buffer;
	
}

/**
 * compress_output_light();
 *
 * this is a light version of the sanitize_output above, 
 * I got the function from this link: http://php.net/manual/en/function.ob-start.php#71953
 * Problem with this function is sometimes it can not compress javascript code properly which 
 * is causing the page to return multiple lines of reponse code one line.
 *
 */
function compress_output_light( $buffer ) {
   
	$search = array(
        '/\>[^\S ]+/s', # strip whitespaces after tags, except space
        '/[^\S ]+\</s', # strip whitespaces before tags, except space
        '/(\s)+/s'  	# shorten multiple whitespace sequences
        );
    $replace = array(
        '>',
        '<',
        '\\1'
        );
	$buffer = preg_replace($search, $replace, $buffer);

	return $buffer;

}