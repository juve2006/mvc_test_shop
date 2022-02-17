<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\View;

/**
 * Class ProductController
 */
class CustomerController extends Controller
{

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
	}