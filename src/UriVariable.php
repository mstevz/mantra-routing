<?php 

namespace Mantra\Routing;

/**
 * * Examples readable Mantra Url:
 *  {variable}                              - Default type as string with min of 1
 *  {variable:type}                         - Default with min of 1
 *  {variable:type(minLength, maxLength)} 
 */
class UriVariable { 

	private string $type;
	private string $minLength;
	private string $maxLength;

	private string $regexp;

	public function __construct($value){
		$this->minLength = 1;
		$this->maxLength = -1;
		$this->getVariableDefinition($value);
	}


	public function getAsRegularExpression(){
		
		switch($this->type){
			case 'string':
				$this->regexp = "(\w";
				break;
			case 'int':
				$this->regexp = '(\d';
				break;
		}

		if($this->minLength != -1 && $this->maxLength != -1) {
			$this->regexp .= "{{$this->minLength},{$this->maxLength}}";
		}
		else{
			$this->regexp .= "+";
		}
		
		return $this->regexp . ')';
	}



	private function setType(string $type){
		switch($type) {
			case 'string':
			case 'int':
				$this->type = $type;
				break;
			default: 
				throw new \Exception('Invalid type.');
		}
	}

	private function getVariableDefinition(string $value){
		
		$typeDefIniPos = strpos($value, ':');
		
		if($typeDefIniPos != false){
			
			$typeDefEndPos = strpos($value, '(');
	
			if($typeDefEndPos == false){
				$typeDefEndPos = strlen($value);
			}
			else{
				
				$sizesDefinition = substr($value, $typeDefEndPos, strlen($value));
				$sizesDefinition = preg_replace('/\(|\)/', '', $sizesDefinition); // Removes parenthesis

				$sizes = explode(',', $sizesDefinition);

				$this->minLength = array_shift($sizes);
				$this->maxLength = array_pop($sizes);

			}
	
			$value = substr($value, $typeDefIniPos+1, $typeDefEndPos-$typeDefIniPos-1);	

			$this->setType($value);
			
		} else {
			$this->setType('string');
		}
	
		return $value;
	}
	

}
?> 