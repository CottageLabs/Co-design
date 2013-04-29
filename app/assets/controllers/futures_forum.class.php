<?php

class controller_futures_forum extends controller {

    public $controller_name = "futures_forum";
	private $m_user;


	public function renderViewport() {
	    
		$this->m_user = $this->objects("user");

		util::userBox($this->m_user, $this->superView());
		
		//$side = new view("frag.sideInfo");
		//$side->append(new view("frag.projectResources"));
		//$side->append(new view('frag.presentations'));
		
		//$this->superview()->replace("sideContent", $side);

		//$this->bind('faq', 'faq');

		$this->bindDefault('futuresForumLanding');
	}
	
	
	protected function futuresForumLanding(){
		$this->setViewPort(new view('futures_forum'));
		$this->pageName = "- Futures Forum";
		$this->viewport();

        // Put the appropriate style on the navigation bar link pointing to the current page
        $this->superview()->replace("current-page-" . $this->controller_name, 'class="current"');
	}
	
	
}

?>
