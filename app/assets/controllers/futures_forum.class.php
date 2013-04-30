<?php

class controller_futures_forum extends controller {

    public $controller_name = "futures_forum";
	private $m_user;


	public function renderViewport() {
	    
		$this->m_user = $this->objects("user");

		util::userBox($this->m_user, $this->superView());	
        
        $this->bind("^edit", "futuresForumEdit");
        $this->bind("^save", "futuresForumSave");

		$this->bindDefault('futuresForumIndex');
	}
	
	
	protected function futuresForumIndex(){
		$this->setViewPort(new view('futures_forum'));
		$this->pageName = "- Futures Forum";
		$this->viewport();

        

        // Add a link to edit this page (TODO - enable only for admins)
        $this->superview()->replace("edit", "<div class=\"edit\"><a href=\"/futures_forum/edit\">edit</a></div>");
        
        // Put the appropriate style on the navigation bar link pointing to the current page
        $this->superview()->replace("current-page-" . $this->controller_name, 'class="current"');
	}
    
     protected function futuresForumSave(){
        $content = ($_POST['content']!='') ? $_POST['content'] : ' ';
        $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><a><strong><em><ul><ol><li><img><code><pre><span><div><sup><sub><br><b><i>';
        
        file_put_contents(realpath( SYS_ASSETDIR . "views/futures_forum.html"), strip_tags($content, $allowed_tags));
         
        $this->redirect("/futures_forum/edit");
     }
    
    protected function futuresForumEdit(){
        
        $view = new view('futures_forum_edit');
        $view->replace("editor-error", ""); //<p class="alert alert-error"></p>
        $view->replace("editor-msg", ""); //<p class="alert alert-success"></p>
        $view->replace("content", file_get_contents(realpath( SYS_ASSETDIR . "views/futures_forum.html")));
        
        $this->pageName = "- Futures Forum - edit";
        
        
        $this->superview()->replace("additional-assets", util::newScript("/presentation/lib/tinymce/tinymce.min.js"));

        // Add a link to edit this page (TODO - enable only for admins)
        //$this->superview()->replace("edit", "<div class=\"edit\"><a href=\"/futures_forum/edit\">edit</a></div>");
        
        // Put the appropriate style on the navigation bar link pointing to the current page
        $this->superview()->replace("current-page-" . $this->controller_name, 'class="current"');
        
        $this->setViewPort($view);
        $this->viewport();
    }
    
	
	
}

?>
