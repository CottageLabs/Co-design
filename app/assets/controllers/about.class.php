<?php

class controller_about extends controller {

    public $controller_name = "about";

	private $m_user;

	public function renderViewport() {
		$this->m_user = $this->objects("user");

		util::userBox($this->m_user, $this->superView());
				
		$this->superview()->replace("sideContent", util::displayNewInnovators());

		$this->bindDefault('aboutPage');
	}
	
	protected function aboutPage(){
		$this->setViewport(new view("about"));
		
		$this->pageName = "- About";
	}



}

?>