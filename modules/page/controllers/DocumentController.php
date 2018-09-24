<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\service\DocumentService;

class DocumentController extends BaseController
{

    //文书范例列表
    public function actionList()
    {
        $this->defineMethod = 'GET';
        $userId = $this->data['user_id'];
        $documentService = new DocumentService();
        $documentList = $documentService->documentList($userId);
        $this->data['page_topo'] = 'document_admin';
        $this->data['active_page'] = 'document_list';
        $this->data['document_list'] = $documentList;
        return $this->render('list.tpl', $this->data);
    }
    
}