<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;


/**
 * Class ProductController
 */
class CustomerController extends Controller
{
    private int $invalid_password;

    /**
     * Customer index action that shows customer list
     *
     * @return void
     */
    public function indexAction(): void
    {
        $this->forward('customer/list');
    }

    /**
     * Customer list action
     *
     * @return void
     */
    public function listAction(): void
    {
        $this->set('title', "Клієнти");

        $costumers = $this->getModel('Customer')
                ->initCollection()
                ->getCollection()
                ->select();
        $this->set('customer', $costumers);

        $this->renderLayout();
    }

    /**
     * Single customer view action
     *
     * @return void
     */
    public function viewAction(): void
    {
        $this->set('title', 'Карточка клієнта');
	
	    $customer = $this->getModel('Customer');
	    $customer->initCollection()
                ->getCollection()
                ->selectFirst();
        $this->set('customer', $customer);

        $this->renderLayout();
    }
    
    public function LoginAction()
    {
        $this->set('title', "Вхід");
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $email = filter_input(INPUT_POST, 'email');
            $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
            $params = [
                'email' => $email,
                'password' => $password
            ];
            $customer = $this->getModel('customer')->initCollection()
                ->filter($params)
                ->getCollection()
                ->selectFirst();
            if (!empty($customer)) {
                $_SESSION['id'] = $customer['customer_id'];
                $this->redirect('/index/index');
            } else {
                $this->invalid_password = 1;
            }
        }
        $this->renderLayout();
    }

    public function LogoutAction()
    {
        $this->clearSession();
        $this->redirect('/index/index');
    }

    private function clearSession(): void
    {
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 3600, "/");
        }
        session_destroy();
    }
	}