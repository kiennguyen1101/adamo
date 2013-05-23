<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kien
 * Date: 5/22/13
 * Time: 8:43 PM
 * To change this template use File | Settings | File Templates.
 */

class option extends database
{
    private $data;

    public function __construct()
    {
        $query = $this->query('SELECT name, value FROM ' . DB_PREFIX . 'option WHERE autoload=1');
        $result = $this->fetch_all($query, true);
        foreach ($result as $option) {
            $this->data[$option['name']] = $option['value'];
        }
    }

    private function get($name)
    {

        if (!isset($this->data[$name])) {
            $query = $this->query("SELECT name, value FROM " . DB_PREFIX . "option WHERE name='{$name}' LIMIT 0,1");
            $option = $this->fetch_array($query, true);
            $this->data[$name] = $this->maybe_serialize($option['value']);

        }

        return $this->data[$name];
    }

    private function set($name, $value, $autoload = false)
    {
        $this->query("INSERT INTO " . DB_PREFIX . "option
                                (id, name, value, autoload) VALUES
                                ('', '{$name}', '{$value}', '{$autoload}' )");

        return $this->insert_id();
    }

    private function update($name, $value, $autoload = false)
    {
        $this->query("UPDATE " . DB_PREFIX . "option SET value='{$value}', autoload='{$autoload}' WHERE name='{$name}'");
    }

    public function getOption($option)
    {
        if ($this->isNullOrEmpty($option))
            return false;

        return $this->get($option);
    }

    protected function isNullOrEmpty($var)
    {
        return (!isset($var) || trim($var) === '');
    }

    public function updateOption($option, $value, $autoload = false)
    {

        if ($this->isNullOrEmpty($option) || $this->isNullOrEmpty($value))
            return false;
        if (!is_bool($autoload))
            return false;

        $value = $this->maybe_serialize($value);

         if (isset($this->data[$option])) {
             if ($this->data[$option] === $value)
                 return false;

             $this->update($option, $value, $autoload);
             return true;

         } elseif (!$this->isNullOrEmpty($this->get($option))) {
             if ($this->data[$option] === $value)
                 return false;

             $this->update($option, $value, $autoload);
             return true;
         } else {
             $id = $this->set($option, $value, $autoload);
             if ($id)
                 return true;
             else
                 return false;
         }


    }
}