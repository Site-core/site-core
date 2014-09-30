<?php
defined('sCore') or die('access denied');
class template {
# SC_engine v1.1
	private $files = array();
    private $vars = array();
    VAR $template;
	VAR $homepage;
	
	function __construct() {
		$this->homepage = 'home';
		$this->set_content();
	}
	
	function set_tpl($tpl_name){
		$this->template = $this->get_file($tpl_name);
	}

	function set_vars($key,$var,$pages='',$wrapper=false){
	do {
		if ($pages) {
			$page = isset($_GET['page']) ? $_GET['page'] : $this->homepage;
			if(!in_array($page, explode(",", $pages))){
				if(!array_key_exists($key, $this->vars))
					$this->vars[$key] = '';
				break;
			}
		}
		if($wrapper){
			$BEGIN = '<div class="'.$wrapper.'">';
			$END = '</div>';
			$var = $BEGIN.$var.$END;
		}
		$this->vars[$key] = $var;
	} while (0);
		
	}

	function get_file($file_name,$parse=false) {
		$fh = @fopen($file_name, "r") or die("Couldn't open the file!");
		$file_contents = fread($fh, filesize($file_name));
		fclose($fh);
		if($parse)
			$file_contents = $this->parse_file($file_contents);
		return $file_contents;
	}

// Обработчик страниц
	function set_content () {
	$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"/^[a-z0-9_]+$/")));
		
		if ($page) {
			$content = PGS_DIR.'/'.$page.'.html';
			if (!file_exists($content)){
				http_response_code(404);
				$content = '404.html';
			}	
		} elseif (is_null($page)) {
			$content = PGS_DIR.'/'.$this->homepage.'.html';
		} else {
			http_response_code(404);
			$content = '404.html';
		}

		$content = $this->get_file($content);
		$content = $this->parse_file($content);
		$this->set_vars('CONTENT', $content);
	}
	function parse_file ($file){
		foreach($this->vars as $find => $replace){
			$file = str_replace("{".$find."}", $replace, $file);
		}
		return $file;
	}
	function tpl_parse(){
		$this->template = $this->parse_file($this->template);
	}
}
?>