<?php

abstract class AbstractModel

{

     static protected $table;

    protected $data = [];

    public function __set($name, $value)
    {
       $this->data[$name] = $value;
    }

    public function __get($name)
    {
       return $this->data[$name];
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public static function findAll()
    {
        $class = get_called_class();

        $sql = 'SELECT * FROM '. static::$table;
        $db = DB::getInstance();
        $db->setClassName($class);
        return $db->query($sql);
    }

    public static function findOneByPk($id)
    {

        $class = get_called_class();

        $sql = 'SELECT * FROM '.static::$table;
        $sql .= ' WHERE id=:id';
        $db = DB::getInstance();
        $db->setClassName($class);
        return $db->query($sql, [':id' => $id])[0];

    }

   public static function findOneByColumn($column, $value)
   {

       $db = DB::getInstance();
       $db->setClassName(get_called_class());
       $sql = 'SELECT * FROM '.static::$table;
       $sql .= ' WHERE '.$column.'=:value';
       $res = $db->query($sql, [':value' => $value]);
       if (empty($res)) {
           $e = new ModelException('Ничего не найдено...');
            throw $e;
       }


            return false;


   }


    public function delete()
    {
        $data[':id'] = $this->data['id'];
        var_dump($data);
        $sql = 'DELETE FROM '.static::$table;
        $sql .= ' WHERE id=:id';
        $db = DB::getInstance();
        $db->execute($sql,$data);
    }


    protected function update()
    {
        $cols = [];
        $data = [];
        foreach ($this->data as $k => $v){
            $data[':'.$k] = $v;
            if ($k == 'id'){
                continue;
            }

            $cols[] = $k.'=:'.$k;
        }
        $sql =' UPDATE '.static::$table.' SET '.implode(', ' ,$cols);
        $sql .= ' WHERE id=:id';
        $db = DB::getInstance();
        $db->execute($sql,$data);

    }


    protected function insert()
    {
        $cols = array_keys($this->data);
        $data = [];
        foreach ($cols as $col){
            $data[':'. $col] = $this->data[$col];
        }
        $sql =' INSERT INTO '.static::$table. ' 
        (' .implode(', ', $cols). ')
         VALUES 
        ('.implode(', ', array_keys($data)).')
         ';

        $db = DB::getInstance();
        $db->execute($sql, $data);
        $this->id = $db->lastInsertId();
    }

        public function save()
        {
            if (!isset($this->id)) {
                $this->insert();
            } else {
                $this->update();
            }
        }



















}