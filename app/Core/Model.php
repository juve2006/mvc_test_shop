<?php

declare(strict_types=1);

namespace Core;

use Core\DB;


use http\Exception\UnexpectedValueException;


/**
 * Class Model
 */
abstract class Model implements DbModelInterface
{

    /**
     * @var string
     */
    protected string $tableName;

    /**
     * @var string
     */
    protected string $idColumn;

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var
     */
    protected $collection;

    /**
     * @var string
     */
    protected string $sql;

    /**
     * @var array
     */
    protected array $params = [];
	
	/**
	 * @return string
	 */
	public function getTableName(): string
	{
		return $this->tableName;
	}
	
	public function getPrimaryKeyName(): string
	{
		return $this->idColumn;
	}
	
	public function getId(): ?int
	{
		return 1;
	}
	
	/**
	 * @return array
	 */
	public function getColumns(): array
	{
		$db = new DB();
		$sql = "show columns from {$this->getTableName()};";
		$results = $db->query($sql);
		foreach ($results as $result) {
			$this->columns[] = $result['Field'];
		}
		return $this->columns;
	}
	
    /**
     * @return $this
     */
    public function initCollection()
    {
        $columns = implode(',', $this->getColumns());
        $this->sql = "select $columns from " . $this->getTableName();

        return $this;
    }
    
    /**
     * @param $params
     * @return $this
     */
    public function sort (array $params)
    {
		$this->sql = "SELECT * FROM $this->tableName ORDER BY ";
	     foreach ($params as $column => $sortType) {
			$this->sql .= "$column $sortType, ";
    }
	    $this->sql = rtrim(($this->sql), ', ');

	    return $this;
    }

    public function deleteItem (array $id) // видалення товару в БД
    {
        $db = new DB ();
        $sql = "DELETE FROM $this->tableName WHERE id =?";
        $db->query($sql, $id); // у нашій функції query вже є prepare і execute
    }

	public function addItem (array $values) // додавання товару в БД
	{
            $columns = '';
            foreach ($values as $column => $value) {
                $columns .= $column . ', ';
            }
            $columns = rtrim($columns, ', ');


            $qty = filter_input(INPUT_POST, 'qty');
            $name = filter_input(INPUT_POST, 'name');
            $price = filter_input(INPUT_POST, 'price');
            $sku = filter_input(INPUT_POST, 'sku');
             $db = new DB ();
            $sql = "INSERT INTO $this->tableName ($columns) VALUES (?, ?, ?, ?)";
            $db->query($sql, array($sku, $name, $price, $qty));// у нашій функції query вже є prepare і execute
            echo 'товар ' . $values['name'] . ' у кількості ' . $values['qty'] . ' успішно додано';

	}
    public function saveItem (string $id, array $values) // редагування товару в БД
    {/*
        $columns = '';
        foreach ($values as $column => $value) {
            $columns .= $column . ', ';
        }
        $db = new DB ();

        $qty = filter_input(INPUT_POST, 'qty');
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price');
        $sku = filter_input(INPUT_POST, 'sku');


        $sql = "UPDATE $this->tableName SET sku = ?, name = ?, price = ?, qty = ?, id = ? WHERE id = $id";
        $db->query ($sql, array($sku, $name, $price, $qty));// у нашій функції query вже є prepare і execute
        echo 'Дані успішно редаговано';*/
    }
    /**
     * @param $params
     */
    public function filter($params)
    {
        /*
          TODO
         */
        return $this;
    }

    /**
     * @return $this
     */
    public function getCollection()
    {
        $db = new DB();
        $this->sql .= ";";
        $this->collection = $db->query($this->sql, $this->params);
        return $this;
    }

    /**
     * @return mixed
     */
    public function select()
    {
        return $this->collection;
    }

    /**
     * @return array|null
     */
    public function selectFirst(): ?array
    {
        return $this->collection[0] ?? null;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getItem($id): ?array
    {
        $sql = "select * from {$this->getTableName()} where $this->idColumn = ?;";
        $db = new DB();
        $params = [$id];
        return $db->query($sql, $params)[0] ?? null;
    }

    /**
     * @return array
     */
    public function getPostValues()
    {
        $values = [];
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            /*
              if ( isset($_POST[$column]) && $column !== $this->id_column ) {
              $values[$column] = $_POST[$column];
              }
             * 
             */
            $column_value = filter_input(INPUT_POST, $column);
            if ($column_value && $column !== $this->idColumn) {
                $values[$column] = $column_value;
            }
        }
        return $values;
    }
}
