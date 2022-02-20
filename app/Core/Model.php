<?php

declare(strict_types=1);

namespace Core;

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
    public function sort ($params)
    {
		$this->sql = "SELECT * FROM $this->tableName ORDER BY ";
	     foreach ($params as $column => $sortType) {
			$this->sql .= "$column $sortType, ";
			//var_dump($params);
			//var_dump($this->sql);
    }
	    $this->sql = rtrim(($this->sql), ', ');
		 var_dump($this->sql);
	    return $this;
    }
	
	public function addItem ($values) // розібратись
	{
		if (isset($values)){
			$columns = '';
			$valuesColumns = '';
			echo '<pre>';
			var_dump($values);
			foreach ($values as $column => $value){
				$columns .= $column . ', ';
				$valuesColumns .= $value. ', ';
			}
			$columns = rtrim($columns, ', ');
			$valuesColumns = rtrim($valuesColumns, ', ');
			$this->sql = "INSERT INTO $this->tableName ($columns) VALUES ($valuesColumns);";
			var_dump($this->sql);
		}
		echo 'товар ' . $values['name'] . ' у кількості '. $values['qty'] . ' успішно додано';
		
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
