<?php

function print_pre($var, $return=false) {
	if ($return) {
		return '<pre>'.print_r($var,1).'</pre>';
	}
	else {
		echo '<pre>'.print_r($var,1).'</pre>';
	}
}