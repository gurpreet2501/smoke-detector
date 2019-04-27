<?php

// include the class
require_once(dirname(__FILE__)."/../PHPSpellChecker.class.php");

// instantiate the class
$spellCheck = new PHPSpellChecker();

/////////////////////////
// set some text to check
$text1 = "Die Commerzbank blickt besorgt in die Zukunft: Das Geldhaus rechnet in der zweiten Jahreshälfte mit einer Zunahme von Kreditausfällen - denn Firmen wie Privatkunden bekommen Probleme, ihre Schulden zu bedienen. Schon jetzt hat das Institut vorsichtshalber knapp eine Milliarde Euro zurückgelegt";
$result = $spellCheck->checkSpelling($text1, "de-DE"); // should return an empty array (text is correct)
//print_r($spellCheck->getWarnings());// get all warnings
//print_r($spellCheck->getErrors());// get all errors
if (count($result) == 0) {
	print "Text is OK !<br/>";
} else {
	print "Text has errors !<br/>";
	print "<pre>";
	print_r($result);
}
$spellCheck->clearWarnings(); // clear all previous warnings
$spellCheck->clearErrors(); // clear all previous errors

$textWithErrors = "PHP: the quik browm fox jumps over the lazi dog"; // this text has 3 errors
$result = $spellCheck->checkSpelling($textWithErrors, "en-US"); // will return an array with the wrong words with associated suggestions
//$result = $spellCheck->checkSpelling($textWithErrors, "en-US", false); // will return an array with the wrong words without associated suggestions
//print_r($spellCheck->getWarnings());// get all warnings
//print_r($spellCheck->getErrors());// get all errors
if (count($result) == 0) {
	print "Text is OK !<br/>";
} else {
	print "Text has errors !<br/>";
	print "<pre>";
	print_r($result);
}

?>