       ___________________________________________________________

            PHP Spell Checker & Spell Suggestion - Version 1.1
                             February 2010
       ___________________________________________________________

                   Copyright (c) 2010 Dragos Protung

_______________________

CONTENTS
_______________________

1. Description
2. System Requirements
3. How to use
4. Contact

_______________________

1. Product Description
_______________________

This class can be used to check the spelling of texts and also provide suggestions in case some words are spelled wrong.

_______________________

2. System Requirements
_______________________

PHP 5.x - required
hunspell - optional: if you don't have it then you can use the pure PHP based version or Google 'Did you mean' version
______________

3. How to use
______________

3.1 - Installation
	this class uses affix dictionaries. This means that you can use the dictionaries from OpenOffice or Mozilla products.
	Just go to https://addons.mozilla.org/en-US/firefox/browse/type:3 and download the dictionaries that you want.
	Unpack the *.xpi files and extract the *.aff and *.dic files into dictionaries/hunspell/ folder.
	This class also works with MySpell dictionaries.
	There is nothing more you have to do, just start using the class. Please read further and then take a look at the examples.

3.2 - HunSpell version
	The hunspell version of this class is preferred.
	It uses less memory for complex languages or with a very big dictionary (over 150.000 words) and the word suggestion is excellent.
	You can get the binaries from http://sourceforge.net/projects/hunspell/files/Hunspell/1.2.8/
	When using this version of the class you need to specify where hunspell is installed by calling the setHunspellPath() method
	or add hunspell to the system path.
	
3.3 - PHP version
	In case you can not install hunspell on your server you can use a pure PHP version.
	The words suggestions is not as good as the HunSpell version (will implement a new algorithm soon).
	Also the PHP version can use a lot of memory for complex languages or with a very big dictionary (over 150.000 words).
	As an example, for German languages the script can use over 100Mb. On the other hand for simple languages it only uses about 10Mb.
	The affix dictionaries can not be used as it is. They need to be converted to PHP code.
	This can be done manuall by calling the compileHunAffixDictionary() method.
	If the dictionary is not compiled yet, the first time you use it it will try to compile it from hunspell.
	For complex languages this file can be over 15Mb.
3.4 - Google 'Did you mean'
	You can use this version to use google's 'Did you mean' function
	The class sends a query to google website and checks for any misspelled words.
	
3.5 - Known bugs, accuracy and performance concerns
	There are several known bugs:
		- initially if a word has the suffix doubled (misspell) the spell checker reports it as a correct word. (pure PHP version only)
		  There is a fix implmented that will rezolve the issue but if a word is correctly spelled with the doubled sufix it will be reported ar wrong.
		  You can remove the fix by commenting the 93-95 lines in PHPSpellChecker.class.php
		- in some languages there is a need for a special encoding and this is not yet supported (will be soon)
	Accuracy: (pure PHP version)
		- Word suggestion is not very smart. It's just a simple "algorithm". I plan on improveing this (maybe you can help out)
	Performance:
		- For very complex languages, or with a very big dictionary (over 150.000 words) (pure PHP version only) the script can use alot of memmory (100Mb)

3.6 - Conclusion
	The PHP version can be used very efficient for simple languages or with small dictionary (ex. english)
	This is just the first release and it will be greatlly improved.
	If you use Google 'Did you mean' you might get banned by Google for using this service.
	If you want to participate on this project please contact me. 
______________

4. Contact
______________

Please send your suggestions, bug reports and general feedback to dragos@protung.ro
Also visit http://www.protung.ro


Out for now ;)