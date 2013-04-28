<?php
class controller_help extends controller {
	
    public $controller_name = "help";
    
	private $m_user;
	
	public function renderViewport() {
		$this->m_user = $this->objects("user");
		
		util::userBox($this->m_user, $this->superView());
				
		$this->superview()->replace("sideContent", "");
		
		$this->bindDefault('renderHelp');
	}
	
	protected function renderHelp(){
		$this->setViewport(new view("help"));	
		
		$this->pageName = "- Help";
	}
	
}
?>
