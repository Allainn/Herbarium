<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonLogin for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Herbarium\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\SessionManager;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        $sessionManager->destroy();   
        return new ViewModel();
    }
}
