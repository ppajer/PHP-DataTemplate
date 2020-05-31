<?php

class DataTemplate {

	private $template;
	private $templateDir;
	private $templateTagsOpen;
	private $templateTagsClose;

	public function __construct($template, $templateDir = '/templates/', $templateTags = array('{{', '}}')) {
		$this->templateDir =$templateDir;
		if (!$this->templateExists($template)) {
			throw new Exception("Unable to find template: $template", 1);
		}
		$this->template = $template;
		$this->templateTagsOpen = $templateTags[0];
		$this->templateTagsClose = $templateTags[1];
	}

	public function render($data) {
		foreach ($data as $key => $value) {

			if (strpos($key, '.html') !== false) {
				$value = $this->partialTemplate($key, $value);				
			}

			$template = str_replace($this->templateTagsOpen.$key.$this->templateTagsClose, $value, $template);
		}

		return $template;
	}

	private function partialTemplate($template, $data) {

		$repeat = (strpos($template, '*') !== false);
		$template = str_replace('*', '', $template);

		if ($repeat && $this->templateExists($template)) {
			
			$part = '';

			foreach ($data as $key => $value) {
				$part .= $this->fillTemplate($this->getTemplate($template), $value);
			}

			return $part;

		} else {
			return '';
		}
	}

	private function getTemplate($templateName) {
		return file_get_contents($this->templateDir.$templateName);
	}

	private function templateExists($templateName) {
		return file_exists($this->templateDir.$templateName);
	}
}

?>
