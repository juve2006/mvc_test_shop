<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\View;
use Core\DB;
use Core\Model;
use Models\Product;

/**
 * Class ProductController
 */
class ProductController extends Controller
{

    /**
     * Product index action that shows product list
     * 
     * @return void
     */
    public function indexAction(): void
    {
        $this->forward('product/list');
    }

    /**
     * Product list action
     * 
     * @return void
     */
    public function listAction(): void
    {
        $this->set('title', "Товари");

        $products = $this->getModel('Product')
                ->initCollection()
                ->filterPrice()
	            ->sort($this->getSortParams())
                ->getCollection()
                ->select();
        $this->set('products', $products);

        $this->renderLayout();
    }

    /**
     * Single product view action
     * 
     * @return void
     */
    public function viewAction(): void
    {
        $this->set('title', 'Карточка товара');

        $product = $this->getModel('Product');
        $product->initCollection()
                ->filter(['id', $this->getId()])
                ->getCollection()
                ->selectFirst();
        $this->set('products', $product);

        $this->renderLayout();
    }

    /**
     * Shows product editing page
     * 
     * @return void
     */
    public function editAction(): void  // редагування товару
    {
        $model = $this->getModel('Product');
        $this->set('saved', 0);
        $this->set("title", "Редагування товару");
        $id = filter_input(INPUT_GET, 'id');
        if ($id) {
            $values = $model->getPostValues();
	        $values = $model->productFilter($values);
            $this->set('saved', 1);
			$model->saveItem($id, $values);  //зробити функцію в моделі  saveItem
        }
        $this->set('product', $model->getItem($this->getId()));

        $this->renderLayout();
    }

    /**
     * Shows product add page
     * 
     * @return void
     */
    public function addAction(): void  // додавання товару в моделі зробити addItem
    {
        $model = $this->getModel('Product');
        $this->set("title", "Додавання товару");
        if ($values = $model->getPostValues()) {
			$values = $model->productFilter($values);
			$model->addItem($values);
	        $id = $model->getLastId();
	        //$this->redirect("/product/edit?id=$id"); //чогось не працює редирект якщо є фільрація html при редіректі в фільтрацію дає пустий масив TODO
        }
	    $this->renderLayout();
    }
    public function deleteAction(): void  // видалення товару на основі editAction  в моделі зробити deleteItem
    {
        $model = $this->getModel('Product');
        $this->set("title", "Вилучення товару");
        $id = filter_input(INPUT_GET, 'id');
        $id = array($id);

        if (filter_input(INPUT_POST, 'delete') === 'Так') {
            $model->deleteItem($id);
            $this->redirect("/product/list");
        }
        if (filter_input(INPUT_POST, 'delete') === 'Hі') {
	        $this->redirect("/product/list");
        }
        $this->renderLayout();
    }

    /**
     * @return array
     */
    public function getSortParams(): array
    {
        $params = [];
        $sortfirst = filter_input(INPUT_POST, 'sortfirst');
        if ($sortfirst === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }
        $sortsecond = filter_input(INPUT_POST, 'sortsecond');
        if ($sortsecond === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }
        return $params;
    }

    /**
     * @return array
     */
    public function getSortParams_old(): array
    {
        $sort = filter_input(INPUT_GET, 'sort');
        if (!isset($sort)) {
            $sort = "name";
        }
        if ((int) filter_input(INPUT_GET, 'order') === 1) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }
        return [$sort, $order];
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return filter_input(INPUT_GET, 'id');
    }

}
