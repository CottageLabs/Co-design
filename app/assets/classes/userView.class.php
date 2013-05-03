<?php
class userView extends view {

    private $user;
    private $delete;
    
    public function __construct(user $thisUser){
        parent::__construct('frag.user');
        $this->user = $thisUser;
        $this->parse();
    }

    
    private function parse(){
        $this->replace("id", $this->user->getId() );
        $this->replace("name", $this->user->getName() );
        $this->replace("username", $this->user->getUsername() );
        
        
        if ($this->user->getIsAdmin()) {
            $this->replace("isadmin",  "<input type=\"checkbox\" name=\"user_isadmin_" . $this->user->getId() . "\" value=\"true\" checked=\"checked\" />");    
        } else {
            $this->replace("isadmin",  "<input type=\"checkbox\" name=\"user_isadmin_" . $this->user->getId() . "\" value=\"true\" />");
        }
        
        if ($this->user->getIsForum()) {
            $this->replace("isforum",  "<input type=\"checkbox\" name=\"user_isforum_" . $this->user->getId() . "\" value=\"true\" checked=\"checked\" />");    
        } else {
            $this->replace("isforum",  "<input type=\"checkbox\" name=\"user_isforum_" . $this->user->getId() . "\" value=\"true\" />");
        }
                
    }

}

?>