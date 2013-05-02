<?php

class controller_admin extends controller {

    public $controller_name = "admin";
	private $m_user;
	

	public function renderViewport() {
		$this->m_user = $this->objects("user");
        
        util::userBox($this->m_user, $this->superView());   
		
		//$this->bind("(?P<name>ideas)/(?P<id>[0-9]+)/hide", "hide"); // Delete comment
		//$this->bind("(?P<name>projects)/(?P<id>[0-9]+)/hide", "hide"); // Delete comment
		 
		 # These bindings should only work for Admins
        if($this->m_user->getIsAdmin()) {   
            $this->bindDefault('userManagement');
        } else {
            $this->redirect("/home?alert=" . urlencode('Please login as an authorised user to view the Admin page'));
        }
	}
    
    protected function userManagement(){
        $this->setViewport(new view("users"));
        
        $this->pageName = "- Users";
    }
	
    /*
	protected function hide($args){
		$this->m_noRender = true;
	
		if($this->m_user->getId() == null) throw new Exception("You do not have access to this area.");
		
		$object = new $args['name']($args['id']);
		if($_POST['action'] == "enable"){
			$object->setHidden(FALSE);
		} else {
			$object->setHidden(TRUE);
		}
		
		$object->commit();
		
		echo json_encode(array("status" => 200));
	}

	protected function noRender(){
		return $this->m_noRender;
	}
	
	protected function defaultHandler(){
		$this->m_noRender = false;
		
		// Select the tab	
		//util::selectTab($this->superview(), "project");	

		util::userBox($this->m_user, $this->superView());		
		
		$this->superView()->replace('sideContent', '');
		
		$this->setViewport(new view('denied'));
	}
    */

}

?>