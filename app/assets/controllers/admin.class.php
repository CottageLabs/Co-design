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
            $this->bind("save", "adminSave"); // Delete comment
            $this->bindDefault('adminIndex');
        } else {
            $this->redirect("/home?alert=" . urlencode('Please login as an authorised user to view the Admin page'));
        }
	}
    
    protected function adminIndex(){
        $this->setViewport(new view("users"));
        
        $this->pageName = "- Users";
        
        
        $users_admin = new collection(collection::TYPE_USER);
        $users_admin->setSort("name", collection::SORT_ASC);
        $users_admin->setQuery(array("", "admin", "=", 1));
        $users_admin_view = new view();        
        $users_admin_array = $users_admin->get();
        foreach($users_admin_array as $user) {
            $template = new userView($user);
            $users_admin_view->append( $template->get() );
        }
        $this->viewport()->replace("users_admin", $users_admin_view);
        
        
        
        $users_forum = new collection(collection::TYPE_USER);
        $users_forum->setSort("name", collection::SORT_ASC);
        $users_forum->setQuery(array("", "forum", "=", 1));
        $users_forum->setQuery(array("AND", "admin", "=", 0));
        $users_forum_view = new view();        
        $users_forum_array = $users_forum->get();
        foreach($users_forum_array as $user) {
            $template = new userView($user);
            $users_forum_view->append( $template->get() );
        }
        $this->viewport()->replace("users_forum", $users_forum_view);
        
        
        $users_general = new collection(collection::TYPE_USER);
        $users_general->setSort("name", collection::SORT_ASC);
        $users_general->setQuery(array("", "forum", "=", 0));
        $users_general->setQuery(array("AND", "admin", "=", 0));
        $users_general_view = new view();        
        $users_general_array = $users_general->get();
        foreach($users_general_array as $user) {
            $template = new userView($user);
            $users_general_view->append( $template->get() );
        }
        $this->viewport()->replace("users_general", $users_general_view);
    }


    protected function adminSave(){
        if($this->m_user->getIsAdmin()) {
            $users = array();
            $admins = array();
            $forums = array();
            
            foreach ($_POST as $key => $value) {
                
                if (preg_match('/^user_(\d+)$/', $key, $matches)) {
                    array_push($users, $matches[1]);
                }
                
                if (preg_match('/^user_isadmin_(\d+)$/', $key, $matches)) {
                    array_push($admins, $matches[1]);
                }
                
                if (preg_match('/^user_isforum_(\d+)$/', $key, $matches)) {
                    array_push($forums, $matches[1]);
                }
            }
            
            //print_r ($users);
            //print_r ($admins);
            //print_r ($forums);
                
           
           
            
            $this->redirect("/admin");
        } else {
            //None-admins get redirected to home
            $this->redirect("/home?alert=" . urlencode('Please login as an authorised user to view the Admin page'));
        }
    }

}

?>