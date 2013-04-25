<?php

class controller_futures_forum extends controller {

	private $m_user;


	public function renderViewport() {
	    
		$this->m_user = $this->objects("user");

		// Select the tab	
		util::selectTab($this->superview(), "resources");	

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
	}
	
	
}

?>