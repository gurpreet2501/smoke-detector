<?php

/**
 * Abstract class SpellChecker
 *
 */
abstract class SpellChecker {
	
	/**
	 * Maximum number of suggestions in case of a misspell
	 *
	 * @var int
	 */
	public $maxSuggestions = 5;
	
	/**
	 * Ignore the words smaller then this
	 *
	 * @var int
	 */
    public $wordsMinLength = 2;
    
    /**
     * Text is html
     *
     * @var bool
     */
    public $textIsHtml = false;

	/**
	 * Spelling process errors
	 *
	 * @var array
	 */
    protected $spellingError = false;
    
    /**
     * Spelling process warning
     *
     * @var array
     */
    protected $spellingWarnings = false;
	
    /**
     * Warning: no text to check
     *
     */
    const SPELLING_WARNING__TEXT_EMPTY = 10;
    /**
     * Warning: spelling did not returned a result
     *
     */
    const SPELLING_WARNING__EMPTY_RESULT = 11;
    /**
     * Error: an internal error
     *
     */
    const SPELLING_ERROR__INTERNAL_ERROR = 20;
    
    
    /**
     * Constructor
     *
     */
	public function __construct() {
		
	}
	
	/**
	 * Get all errors after spell checking
	 *
	 * @return array | false
	 */
	public function getErrors () {
		return $this->spellingError;
	}
	
	/**
	 * Delete all spell checking errors
	 *
	 */
	public function clearErrors() {
		$this->spellingError = false;
	}
	
	/**
	 * Delete all spell checking warnings
	 *
	 */
	public function clearWarnings () {
		$this->spellingWarnings = false;
	}
	
	/**
	 * Get all warnings after spell checking
	 *
	 * @return array | false
	 */
	public function getWarnings () {
		return $this->spellingWarnings;
	}
	
	/**
	 * Set the maximum suggestions
	 *
	 * @param int $maxSuggestions
	 */
	public function setMaxsuggestions($maxSuggestions = 5) {
		$this->maxSuggestions = abs((int)$maxSuggestions);
	}
	
	/**
	 * Set the minimum word length to check for spelling
	 *
	 * @param int $minLength
	 */
	public function setWordsMinLength ($minLength = 2) {
		$this->wordsMinLength = (int)$minLength;
	}
	
	/**
	 * Split a text and return an array of words
	 *
	 * @param string $text
	 * @return array
	 */
	protected function splitTextInWords ($text, $unique = true) {
//		$x = array_keys(array_flip(preg_split('/[\s\[\]]+/s', $text, -1, PREG_SPLIT_NO_EMPTY)));
		$patern = '/[\s\[\].*_!"\/():\-0-9#$%&\'’\+,;<=>\?\@\^{}\|`\\\]+/s';
		if($unique) {
			$x = array_unique(preg_split($patern, $text, -1, PREG_SPLIT_NO_EMPTY));
		} else {
			$x = preg_split($patern, $text, -1, PREG_SPLIT_NO_EMPTY);
		}
		$x = array_filter($x, array($this, "smallWordsArrayFilter"));
		return $x;
	}
	
	private function smallWordsArrayFilter($var) {
		return (strlen($var) > $this->wordsMinLength);
	}
	
	/**
	 * Set if the text to check is HTML or not
	 *
	 * @param bool $isHTML
	 */
	public function textIsHTML ($isHTML = true) {
		$this->textIsHtml = (bool)$isHTML;
	}
	
	
	public abstract function checkSpelling ($text, $locale, $suggestions = true);
	
	/**
	 * Check custom dictionary
	 *
	 * @param string $word
	 * @return bool
	 */
	public function isInLocalDictionary ($word, $locale) {
		
		$customDictFile = dirname(__FILE__)."/dictionaries/custom/".$locale.".php";
		if (!file_exists($customDictFile)) {
			return false;
		}
		$word = strtolower($word);
		static $SpecllCheckerCustom = array();
		
		require_once($customDictFile);
		
		if (is_array($SpecllCheckerCustom[$locale]) && in_array($word, $SpecllCheckerCustom[$locale])) {
			return true;
		} else {
			return false;
		}
		
	}
	
}

?>