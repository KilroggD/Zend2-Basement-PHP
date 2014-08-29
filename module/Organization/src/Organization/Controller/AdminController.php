<?php
namespace Organization\Controller;
use Zend\View\Model\ViewModel;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author kopychev
 */
class AdminController extends MyAbstractController{
    /**
     * Просмотр списка организаций
     */
        public $query, $refUrl, $errors=array();
        /**
     * Репозиторий организации
     * @var \Organization\Repository\OrganizationsRepository
     */
        protected $orgRepository;
           /**
     * Репозиторий типа организации
     * @var \Organization\Repository\OrganizationsRepository
     */
        protected $typeRepository;
        
        
            public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->orgRepository=$this->getRepository("Organization\Entity\Organizations");
        $this->typeRepository=$this->getRepository("Organization\Entity\OrganizationTypes");
        parent::onDispatch($e);
    }
        
    public function indexAction() {
           $page=isset($this->query["page"])?$this->query["page"]:1;
            $form=$this->getFormByKey('Organization\Form\Search');
            if($this->query) {
            $form->setData($this->query);
            }
            $records=$this->orgRepository->search($this->query);
            $paginated=$this->Paginator()->paginate($records,20,$page);
            return array("orgs"=>$paginated->getItems(),"pages"=>$paginated->getCount(),"currentPage"=>$page,"form"=>$form, "pagelimit"=>3, "messages"=>$this->flashMessenger()->getMessages(),"query"=>$this->query);        
    }
    
    /**
     * Просмотр "карточки организации"
     */
    public function viewAction(){
        $id=(int)$this->params()->fromRoute("id");
        $organization=array();
        $users=array();
        $org=$this->orgRepository->find($id);
        if(!$org){            
        $organization=array(
            "name"=>$org->getName(),
            "shortName"=>$org->getShortName(),
            "inn"=>$org->getInn(),
            "kpp"=>$org->getKpp(),
            "address"=>$org->getAddress(),
            "type"=>$org->getType()->getName()
        );
        $users=$org->getUsers();
        }
        return array("org"=>$organization,"users"=>$users, "messages"=>$this->flashMessenger()->getMessages());
    }
    
    public function addAction(){
                        $request=$this->getRequest();
                $org=new \Organization\Entity\Organizations();
                $form = $this->getFormByKey('Organization\Form\OrgForm');
                $form->bind($org);
                if($request->isPost()){
                    $post=$request->getPost();
                    $form->setData($post);
                    if($form->isValid()){           
                        try{
                        $type=$this->typeRepository->find($post["type"]);
                        $org->setType($type);
                        $this->getEntityManager()->persist($org);
                        $this->getEntityManager()->flush();                         
                        }
                        catch (\Exception $e){
                            var_dump($e->getTrace());
                            exit;
                        }
                        return $this->redirect()->toRoute("organizations\\admin");
                    }
                    else  {
                        $this->errors[]="form is invalid";
                    }
                }             
                return array("form"=>$form, "errors"=>$this->errors);
    }
    /**
     * Редактирование организации
     * @return array
     */
    public function editAction(){
                $id=$this->params()->fromRoute('id');
        $request=$this->getRequest();
        if($id){
            $org=$this->getRepository('Organization\Entity\Organizations')->find($id);
            if($org){
                $form = $this->getFormByKey('Organization\Form\OrgForm');
                $form->bind($org);
                if($request->isPost()){
                    $post=$request->getPost();
                    $form->setData($post);
                    if($form->isValid()){            
                        $this->getEntityManager()->persist($org);
                        $this->getEntityManager()->flush();                         
                        return $this->redirect()->toRoute("organizations\\admin/view",array("id"=>$id));
                    }
                           }
                return array("form"=>$form, "errors"=>$this->errors);
            }
                    }
        else {
            return $this->redirect()->toRoute("user\\admin");
        }
    }
    /**
     * Удаление организации
     */
    public function deleteAction(){
                      $id=$this->params()->fromRoute('id');
                        if($id){
                            $org=$this->orgRepository->find($id);
                            if($org){
                                $this->getEntityManager()->remove($org);
                                $this->getEntityManager()->flush();
                                $this->flashMessenger()->addMessage("Организация удалена");
                            }
                        }
                                  
            $this->redirect()->toRoute("organizations\admin");     
    }
        
    
}
