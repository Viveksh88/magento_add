<?php 
namespace Excellence\Crud\Block\Address;
use Excellence\Crud\Block\BaseBlock;

class Index extends BaseBlock
{
    public function show_user_add(){
        $postCollection = $this->_coreRegistry->registry('show_data');
        return $postCollection;
    }
    
}
?>