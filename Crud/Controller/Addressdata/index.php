<?php
/**
 *
 * Copyright © 2015 Excellencecommerce. All rights reserved.
 */
namespace Excellence\Crud\Controller\Addressdata;

class Index extends \Magento\Framework\App\Action\Action
{

	/**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $_collectiondata;
    protected $_coreRegistry;
    protected $_addresscollection;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Excellence\Crud\Model\TestFactory  $collectiondata,
        \Excellence\Crud\Model\AddressFactory  $addresscollection,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_addresscollection = $addresscollection;
        $this->_collectiondata = $collectiondata;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Flush cache storage
     *
     */
    public function execute()
    {
        $address_add = $this->getRequest()->getParams();
        if(isset($address_add['delete_add_id'])){ //deleting address data..
            $id=$address_add['delete_add_id'];
            $Deletedata = $this->_addresscollection->create();
            
            $data = $Deletedata->load($id);
            $params = $data['excellence_user_id'];
            $d_deleted = $Deletedata->delete();
            
            if($d_deleted){
                $this->messageManager->addNotice( __('Record Deleted Successfully !') );
            }
            $this->_redirect('crud/viewaddress/index', array('view_add_id' => $params));
        }
        $edit_data = $this->getRequest()->getPostValue();
        if(isset($edit_data['id'])){ //for editing address data
            $a_id = $edit_data['id'];
            $u_id = $edit_data['user_id'];
            $house = $edit_data['h_no'];
            $street = $edit_data['street'];
            $city = $edit_data['city'];
            $state = $edit_data['state'];
            $pin = $edit_data['pin'];
            $params = array('uid' => $u_id);
            

            $model_update = $this->_addresscollection->create()->load($a_id);
            $model_update->addData([
                "excellence_address_id" =>$a_id,
                "excellence_user_id" =>$u_id,
                "House_no" => $house,
                "Street_name" => $street,
                "City_name" => $city,
                "State_name" => $state,
                "pin" => $pin
                ]);
            $save_updated_Data = $model_update->save();
            if($save_updated_Data){
                $this->messageManager->addSuccess( __('Record Updated Successfully....!') );
            }
            
            return ;
        }
        //for inserting address data into table
        if(isset($address_add['address_user_id'])){
            $data_add = $this->getRequest()->getPostValue();
           
           $user_id = $data_add['address_user_id'];
           $h_no = $data_add['house_add'];
           $street = $data_add['street_add'];
           $city = $data_add['city_add'];
           $state = $data_add['state_add'];
           $pin = $data_add['pin_add'];

           $address_insert = $this->_addresscollection->create();
           $address_insert->addData([
               "excellence_user_id" => $user_id,
               "House_no" => $h_no,
               "Street_name" => $street,
               "City_name" => $city,
               "State_name" => $state,
               "pin" => $pin,
               ]);
           $saveData = $address_insert->save();
           if($saveData){
               $this->messageManager->addSuccess( __('Insert Record Successfully !') );
           }
           $this->_redirect('crud/display/index');
        }
        
    }

}