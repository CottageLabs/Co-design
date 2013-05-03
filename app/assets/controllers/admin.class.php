<?php

class controller_admin extends controller {

    public $controller_name = "admin";
	private $m_user;
	private $m_noRender = false;

	public function renderViewport() {
		$this->m_user = $this->objects("user");
        
        util::userBox($this->m_user, $this->superView());   
		
		//$this->bind("(?P<name>ideas)/(?P<id>[0-9]+)/hide", "hide"); // Delete comment
		//$this->bind("(?P<name>projects)/(?P<id>[0-9]+)/hide", "hide"); // Delete comment
		 
		 # These bindings should only work for Admins
        if($this->m_user->getIsAdmin()) {
            $this->bind("save", "adminSave"); // Save updates
            $this->bind("delete/(?P<id>[0-9]+)", "deleteUser"); // Delete user
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
        //Only admins can use this page
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
            
            foreach($users as $user_id){
                $is_admin = in_array($user_id, $admins);
                $is_forum = in_array($user_id, $forums);
                
                $user = new user($user_id, user::ID_LOCAL);
                $user->setIsAdmin($is_admin);
                $user->setIsForum($is_forum);
                
                $user->commit();
            }
            
            $this->redirect("/admin");
        } else {
            //None-admins get redirected to home
            $this->redirect("/home?alert=" . urlencode('Please login as an authorised user to view the Admin page'));
        }
    }

    protected function deleteUser($args){
        $this->m_noRender = true;
        
        try {
            $user = new user($args['id'], user::ID_LOCAL);
            $this->m_user->delete($user);        
            echo json_encode(array("status" => 200));
        } catch(Exception $e){
            echo json_encode(array("status" => 599, "message" => $e->getMessage()));
        }
    }
    
    protected function noRender(){
        return $this->m_noRender;
    }

}

?>