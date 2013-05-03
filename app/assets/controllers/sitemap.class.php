<?php

class controller_sitemap extends controller {

    public $controller_name = "sitemap";

	private $m_user;

	public function renderViewport() {
		$this->m_user = $this->objects("user");

		util::userBox($this->m_user, $this->superView());
				
		$this->superview()->replace("sideContent", util::displayNewInnovators());

		$this->bindDefault('sitemapPage');
	}
	
	protected function sitemapPage(){
		$this->setViewport(new view("sitemap"));
		
		$this->pageName = "- Sitemap";
	}



}

?>
