<?php

require_once(dirname(__FILE__)."/SpellChecker.class.php");

/**
 * Spellchecker using Google's "Did you mean"
 *
 */
class GDYMSpellChecker extends SpellChecker {
	
	const GDYMUrl = "/search?meta=&q=";
	
	private function getGoogleURL ($locale) {
		
		$locale = strtolower($locale);
		
		switch ($locale) { // TODO add more websites for different languages
			case 'de':
			case 'de-de':
				$ext = '.de';
				break;
			case 'de-at':
				$ext = '.at';
				break;
			case 'de-ch':
				$ext = '.ch';
				break;
			case 'ro':
			case 'ro-ro':
				$ext = '.ro';
				break;
			default:
				$ext = '.com';
				break;
		}
		
		return "http://www.google".$ext.self::GDYMUrl;
	}
	
	/**
	 * Check for spelling
	 * 
	 * @param string $text
	 * @param string $locale
	 * @param bool $suggestions
	 * @return array
	 */
	public function checkSpelling ($text, $locale, $suggestions = true) {
		
		if ($this->textIsHtml == true) {
			$text = strip_tags($text);
		}
		$text = trim($text);
		
		$url = $this->getGoogleURL($locale).urlencode($text);
		$gdymresult = file_get_contents($url);
		
		$badWords = array();
		if ($gdymresult != false) {
			
			if (preg_match_all("/class\\=spell\\>(.*?)\\<\\/a\\>/i", $gdymresult, $matches)) {
				$gdymresult = $matches[1][0];
					
				foreach($this->splitTextInWords($text) as $word) {
					$origText[] = $word;
				}
				foreach ($this->splitTextInWords($gdymresult) as $word) {
					$suggText[] = $word;
				}
					
//				if (count($origText) == count($suggText)) {
					foreach (array_diff($suggText,$origText) as $key=>$word) {
						if ($suggestions == true) {
							$badWords[$origText[$key]] = array($word);
						} else {
							$badWords[$origText[$key]] = array();
						}
					}
//				}
				// TODO detect if words have been split by google (misspell by missing a space between words)
			} else {
				// the spelling is correct
			}
			
			return $badWords;
			
		} else {
			return false;
		}
	}
}

?>