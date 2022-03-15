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
		return $_GET['id'] ?? NULL;
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
    public function initCollection(): self
    {
        $columns = implode(',', $this->getColumns());
        $this->sql = "SELECT $columns FROM " . $this->getTableName();

        return $this;
    }
    
    /**
     * @param $params
     * @return $this
     */
    public function sort (array $params): self
    {
        $this->sql .= " ORDER BY ";
	     foreach ($params as $column => $sortType) {
			$this->sql .= "$column $sortType, ";
    }
	    $this->sql = rtrim(($this->sql), ', ');

	    return $this;
        var_dump($this);
    }

    public function deleteItem (array $id): void // видалення товару в БД
    {
        $db = new DB ();
        $sql = "DELETE FROM $this->tableName WHERE id =?";
        $db->query($sql, $id); // у нашій функції query вже є prepare і execute
    }

	public function addItem (array $values): void // додавання товару в БД
	{
            $columns = '';
			$vals ='';
            foreach ($values as $column => $value) {
                $columns .= $column . ', ';
				$vals .= "'$value', ";
            }
            $columns = rtrim($columns, ', ');
			$vals = rtrim($vals, ', ');
			$db = new DB ();
			$sql = "INSERT INTO $this->tableName ($columns) VALUES ($vals)";
			$db->query($sql);// у нашій функції query вже є prepare і execute
			echo 'товар ' . $values['name'] . ' у кількості ' . $values['qty'] . ' успішно додано';

	}
    public function saveItem (string $id, array $values): void // редагування товару в БД
    {
        if(!empty($id) && !empty($values)) {
            $sku = $values['sku'];
            $name = $values['name'];
            $qty = $values['qty'];
            $price = $values['price'];
			$description = $values['description'];

        $db = new DB();
        $sql = "UPDATE $this->tableName SET sku = ?, name = ?, price = ?, qty = ?, description = ?, id = ? WHERE id = $id";
        $db->query ($sql, array($sku, $name, $price, $qty, $description, $id));// у нашій функції query вже є prepare і execute
	    echo 'Дані успішно редаговано';
        }
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
    public function getMaxValue(string $column): string
    {
        $db = new DB();
        $sql = "SELECT MAX($column) FROM $this->tableName";
        $max = $db->query($sql); //array returned
        return $max[0]["MAX($column)"];
    }

    public function filterPrice(): self
    {
	    if (empty($_POST['priceFrom'])) {
            $priceFrom = 0;
        } else {
	        $priceFrom = $_POST['priceFrom'];
        }
	
	    if (empty($_POST['priceTo'])) {
		    $priceTo = $this->getMaxValue('price');
	    } else {
		    $priceTo = $_POST['priceTo'];
	    }
	    $this->sql = "SELECT * FROM $this->tableName WHERE price BETWEEN $priceFrom AND $priceTo";

		return $this;
    }
    /**
     * @return $this
     */
   
    public function getCollection(): self
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
    public function getItem(string $id): ?array
    {
        $sql = "select * from {$this->getTableName()} where $this->idColumn = ?;";
        $db = new DB();
        $params = [$id];
        return $db->query($sql, $params)[0] ?? null;
    }

    /**
     * @return array
     */
    public function getPostValues(): array
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
	public function getLastId(): string
	{
		$db = new DB();
		return $db->getConnection()->lastInsertId(); // id останньо доданого елемента в БД
	}
	public function productFilter (array $values): array
	{
		$definition = [
			'name' => [
				'filter' => FILTER_CALLBACK,
				'options' => [$this, 'checkLenghtString']
			],
			'price' => [
				'filter' => FILTER_VALIDATE_FLOAT,
				'options' => ['min_range' => 0.01]
			],
			'sku' => [
				'filter' => FILTER_CALLBACK,
				'options' => [$this, 'checkLenghtString']
			],
			'qty' => [
				'filter' => FILTER_VALIDATE_FLOAT,
				'options' => ['min_range' => 0]
			],
			'description' => [
				'filter' => FILTER_DEFAULT,
				'options' => [$this, 'checkLenghtString']
			]
		];
		
		$checked = filter_var_array($values, $definition);
		foreach ($checked as $key => $text) {
			if ($key === 'description') {
				$text = htmlspecialchars($text);
			}
		}
		return $checked;
		
	}
	
	public function checkLenghtString (string $value): string|bool
	{
		if (mb_strlen(trim($value)) > 0) {
			return $value;
		} else {
			return '';
		}
	}
}
