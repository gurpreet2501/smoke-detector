<?php

require_once (dirname(__FILE__)."/SpellChecker.class.php");

class PHPSpellChecker extends SpellChecker {
	
	private $wordsKeys = array();
	
	/**
	 * Check for spelling
	 * 
	 * @param string $text
	 * @param string $locale
	 * @param bool $suggestions
	 * @return array
	 */
	public function checkSpelling($text, $locale, $suggestions = true) {
		
		$dictFile = dirname(__FILE__)."/dictionaries/php/".$locale.".php";
		if (!file_exists($dictFile)) { // dictionary not found - try to compile it from hunspell
			$compileOK = $this->compileHunAffixDictionary($locale);
			if ($compileOK == false) { // compile successful
				$this->spellingError[] = array(self::SPELLING_ERROR__INTERNAL_ERROR=>"Could not compile the dictionary!");
				return false;
			}
		}
		
		static $SpecllChecker = array();
		require_once($dictFile);
		
		if (!isset($SpecllChecker[$locale])) {
			return false;
		}
		
		if ($this->textIsHtml == true) {
			$text = strip_tags($text);
		}
		
		if ($text == "") {
			$this->spellingWarnings[] = array(self::SPELLING_WARNING__TEXT_EMPTY=>"Text empty");
			return false;
		}
		$text = strtolower($text);
		
		$this->wordsKeys = array_keys($SpecllChecker[$locale]['words']);
		$badWords = array();
		
		$words = $this->splitTextInWords($text);
		
		foreach ($words as $word) {
			
			$result = false;
			
			if (isset($SpecllChecker[$locale]['words'][$word]) || strlen($word) <= $this->wordsMinLength || preg_match("/^[0-9]+$/", $word) || $this->isInLocalDictionary($word, $locale)) { // is number or exactly in the dictionary
				continue;
			}
			
			for($parsed = $word, $length = count($SpecllChecker[$locale]['rules']['PFX']),
				$i=0,$rule="", $str="", $seek="", $re="", $add=""; $i < $length;$i++)
			{
				$rule = $SpecllChecker[$locale]['rules']['PFX'][$i];
				$add = $rule[0];
				$seek = $rule[1];
				$re = $rule[2];
				$str = substr($word, 0, strlen($seek));

				if($str == $seek){
					$parsed = substr($word, strlen($str));
					if($add !== "0") {
						$parsed = $add.$parsed;
					}
					$result = isset($SpecllChecker[$locale]['words'][$parsed]);
					break;
				}
			};

			if(!$result && strlen($parsed)){
				for($rules = $SpecllChecker[$locale]['rules']['SFX'], $len = strlen($parsed), $length = count($rules),$i=0; $i<$length; $i++) {
					$rule = $rules[$i];
					$add = $rule[0];
					$seek = $rule[1];
					$re = $rule[2];
					$str =  substr($parsed, ($len - strlen($seek)));

					if($str == $seek){

						$seek = substr($parsed, 0, ($len - strlen($str)));
						if($add !== "0") {
							$seek .= $add;
						}
					
						if(isset($SpecllChecker[$locale]['words'][$seek]) && ($re === "." || preg_match('/'.$re."$".'/', $seek))){

                        	if (preg_match("/[A-Z]/", $rule[3]) && substr($str, -2*strlen($rule[1])) == $rule[1].$rule[1]) { // TODO - check for implications for this hack
                        		break;
                        	}
                        	$result = true;
                        	break;
                        }
                      }
                    }
                  }

                  if (!$result) {

                  	if ($suggestions) {
                  		if (!in_array($text,$this->wordsKeys)) {
                  			$this->wordsKeys[] = $word;
                  		}
                  		sort($this->wordsKeys);

                  		$index = array_search($word, $this->wordsKeys);

                  		$badWords[$word] = array_slice($this->wordsKeys, $index-1, $this->maxSuggestions+1);
                  		unset($badWords[$word][1]);
                  		unset($this->wordsKeys[$index]);
                  		sort($badWords[$word]);
                  	} else {
                  		$badWords[$word] = array();
                  	}
                  }
                }

                unset($this->wordsKeys);
                unset($SpecllChecker);
                return $badWords;
              }

	/**
	 * Convert the Hunspell dictionary into PHP
	 *
	 * @param string $locale
	 * @return bool
	 */
	public function compileHunAffixDictionary ($locale) {
		
		$affFile = dirname(__FILE__)."/dictionaries/hunspell/".$locale.".aff";
		$dictFile = dirname(__FILE__)."/dictionaries/hunspell/".$locale.".dic";
		if (!file_exists($affFile) || !file_exists($dictFile)) {
			return false;
		}
		
		$compiledDictionaryFile = dirname(__FILE__)."/dictionaries/php/".$locale.".php"; 
		
		$cdfh = fopen($compiledDictionaryFile, "w");
		if ($cdfh == false) {
			return false;
		}
		
		fputs($cdfh, "<?php\n\n");
		fputs($cdfh, "\$SpecllChecker['".$locale."'] = array(");

			// parse DIC file
		$dictContent = file($dictFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		fputs($cdfh, $this->getIndent(1)."'words'=>array(");
		next($dictContent);
		while (($word = next($dictContent))) {
			$word = explode("/", $word);
			if (count($word) == 2) {
				$out  = $this->getIndent(4)."'".addslashes(strtolower($word[0]))."'=>'".$word[1]."',";
				fputs($cdfh, $out);
			} elseif (count($word) == 1) {
				$out  = $this->getIndent(4)."'".addslashes(strtolower($word[0]))."'=>true,";
				fputs($cdfh, $out);
			}
		}
		fputs($cdfh, $this->getIndent(4)."),");
		unset($dictContent);


			// parse AFF file
		$affContent = file($affFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$rules = array('PFX'=>array(),'SFX'=>array());
		$alphabet = "/\\b[";
		fputs($cdfh, $this->getIndent(1)."'rules'=>array(");
		foreach ($affContent as $line) {
			if (strpos($line, "PFX") === 0) {
				$line = preg_split("/[\\s,]+/", $line);
				if (count($line) == 5) {
					$line = array_map("addslashes", $line);
					$rules['PFX'][] = array($line[2], $line[3], $line[4], $line[1]);
				}
			} elseif (strpos($line, "SFX") === 0) {
				$line = preg_split("/[\\s,]+/", $line);
				if (count($line) == 5) {
					$line = array_map("addslashes", $line);
					$rules['SFX'][] = array($line[2], $line[3], $line[4], $line[1]);
				}
			} elseif (strpos($line, "WORDCHARS") === 0 || (strpos($line, "TRY") === 0)) {
				$line = preg_split("/[\\s,]+/", $line);
				$alphabet .= $line[1];
			}
		}
		$alphabet .= "]+\\b/ig";
		fputs($cdfh, $this->getIndent(4)."'alphabet'=>'".addslashes($alphabet)."', ");
		unset($affContent);

		fputs($cdfh, $this->getIndent(4)."'PFX'=>array(");
		foreach ($rules['PFX'] as $rule) {
			$out  = $this->getIndent(7)."array(";
			$out .= "'".$rule[0]."', '".$rule[1]."', '".$rule[2]."', '".$rule[3]."'";
			$out .= "),";
			fputs($cdfh, $out);
		}
		fputs($cdfh, $this->getIndent(4)."),");

		fputs($cdfh, $this->getIndent(4)."'SFX'=>array(");
		foreach ($rules['SFX'] as $rule) {
			$out  = $this->getIndent(7)."array(";
			$out .= "'".$rule[0]."', '".$rule[1]."', '".$rule[2]."', '".$rule[3]."'";
			$out .= "),";
			fputs($cdfh, $out);
		}
		fputs($cdfh, $this->getIndent(4)."),");


		fputs($cdfh, $this->getIndent(1)."),");
		

		
		fputs($cdfh, $this->getIndent().");");
		fputs($cdfh, "\n\n?>");
		fclose($cdfh);
		
		return true;
	}
	
	protected function getIndent($level = 0, $newLine = true) {
		
		$indent  = $newLine ? "\n":"";
		$indent .= str_repeat("\t", (int)$level);
		
		return $indent;
	}
	
	
	
}

?>