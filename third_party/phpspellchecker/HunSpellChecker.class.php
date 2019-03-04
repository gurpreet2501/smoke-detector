<?php

require_once(dirname(__FILE__)."/SpellChecker.class.php");

/**
 * Spellchecker using hunspell
 *
 */
class HunSpellChecker extends SpellChecker {
	
	/**
	 * Path to hunspell
	 *
	 * @var string
	 */
	private $hunspellPath = "hunspell";
	
	/**
	 * Set the path to hunspell
	 *
	 * @param string $path
	 */
	public function setHunspellPath ($path) {
		$this->hunspellPath = $path;
	}
	
	/**
	 * Check spelling
	 *
	 * @param string $text
	 * @param string $locale
	 * @param bool $suggestions
	 * @return array
	 */
	public function checkSpelling ($text, $locale, $suggestions = true) {
		
		$text = trim($text);
		
		if ($this->textIsHtml == true) {
			$text = strtr($text, "\n", ' ');
		}
		if ($text == "") {
			$this->spellingWarnings[] = array(self::SPELLING_WARNING__TEXT_EMPTY=>"Text empty");
			return false;
		}
		
		$descspec = array(
						  0=>array('pipe', 'r'),
						  1=>array('pipe', 'w'),
						  2=>array('pipe', 'w')
					);
		
		$pipes = array();
		$cmd  = $this->hunspellPath;
		$cmd .= ($this->textIsHtml) ? " -H ":"";
		$cmd .= " -d ".dirname(__FILE__)."/dictionaries/hunspell/".$locale;
		
		$process = proc_open($cmd, $descspec, $pipes);
		
		if (!is_resource($process)) {
			$this->spellingError[] = array(self::SPELLING_ERROR__INTERNAL_ERROR=>"Hunspell process could not be created.");
			return false;
		}
		
		fwrite($pipes[0], $text);
		fclose($pipes[0]);
		
		$out = '';
		while (!feof($pipes[1])) {
			$out .= fread($pipes[1], 4096);
		}
		fclose($pipes[1]);
		
		// check for errors
		$err = '';
		while (!feof($pipes[2])) {
			$err .= fread($pipes[2], 4096);
		}
		if ($err != '') {
			$this->spellingError[] = array(self::SPELLING_ERROR__INTERNAL_ERROR=>"Spell checking error: ".$err);
			fclose($pipes[2]);
			return false;
		}
		fclose($pipes[2]);
		
		proc_close($process);
		
		if (strlen($out) === 0) {
			$this->spellingError[] = array(self::SPELLING_WARNING__EMPTY_RESULT=>"Empty result");
			return false;
		}
		
		return $this->parseHunspellOutput(explode("\n", $out), $locale, $suggestions);
	}
	
	/**
	 * Parse the output from hunspell
	 *
	 * @param array $lines
	 * @return array
	 */
	private function parseHunspellOutput ($lines = array(), $locale, $suggestions = true) {
		
		if (is_array($lines) && count($lines) > 0) {
			
			$misspelledWords = array();
			foreach ($lines as $line) {
				
				$line = trim($line);
				if ($line == '') continue;
				 
				$word = explode(' ', $line, 3);
				if (!isset($word[1])) {
					continue;
				}
				$word = $word[1];
				
				if (strlen($word) <= $this->wordsMinLength || isset($misspelledWords[$word]) || $this->isInLocalDictionary($word, $locale)) {
					continue;
				}
				
				switch ($line[0]) {
					case '#': // Misspelling with no suggestions
						$misspelledWords[$word][] = array();
						break;
					case '&': // Suggestions
						$misspelledWords[$word] = $suggestions ? array_slice(explode(', ', substr($line, strpos($line, ':') + 2)), 0, $this->maxSuggestions) : array();
						break;
				}
			}
			return $misspelledWords;
		} else {
			$this->spellingError[] = array(self::SPELLING_WARNING__EMPTY_RESULT=>"Empty result");
			return false;
		}
	}
}

?>