<?php
class resourceView extends view {

	private $resource;
	private $user;
	private $delete;
	
	private $resourceType;

	public function __construct(resource $resource, user $thisUser){
		parent::__construct('frag.idea');
		
		$this->resource = $resource;
		$this->user = $thisUser;
		
		if($this->resource instanceof idea){
			$this->resourceType = "idea";
		} else {
			if((BOOL)$this->resource->getIncubated()){
				$this->resourceType = "shortlist";
			} else {
				$this->resourceType = "project";
			}
		}
		
		$this->parse();
	}
	
    private function pluralise($name) {
        switch ($name) {
            case "shortlist":
                return "shortlist";
                break;
            default:
                return $name . "s";
                break;
        }
    }
    
	private function parse(){
		$this->replace("title", $this->resource->getName() );
        $this->replace("overview", $this->resource->getOverview() );
		$this->replace("points", $this->resource->countVotes());
		$this->replace("chats", $this->resource->getChatCount());
		$this->replace("pitch", $this->resource->getOverview());
        $this->replace("category-image", $this->resource->getCategory()->getImage());
        $this->replace("category-name", $this->resource->getCategory()->getName());
		$this->replace("image", $this->resource->getImage());
		$this->replace("id", $this->resource->getId());
		$this->replace("type", get_class($this->resource));
		$this->replace("url", "/" . $this->pluralise($this->resourceType) . "/" . $this->resource->getId());
		
		if(get_class($this->resource) == "project"){
			$this->replace("assoc", $this->resource->getSiblingCount());
		} else {
			$this->replace("assoc", $this->resource->getProjectCount());
		}
		
		if($this->user->getIsAdmin()){
			if($this->resource->getHidden()){
				$this->replace('delete', new view('frag.makeVisible'));
			} else {
				// Display the deletion icon
				$delete = new view('frag.deleteComment');
				$this->replace('delete', $delete);
			}
		} else {
			$this->replace('delete', '');
		}				
	}

}

?>