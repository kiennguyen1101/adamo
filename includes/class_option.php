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
    public $data;

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
        $name = trim($name);
        if (!$name)
            return false;

        $query = $this->query("SELECT name, value FROM " . DB_PREFIX . "option WHERE name='{name}' LIMIT 0,1");
        $option = $this->fetch_array($query, true);

        return $option;
    }

    private function set($name, $value, $autoload = false)
    {
        $name = trim($name);
        $value = trim($value);
        if (!$name || !$value)
            return false;
        if (!is_bool($autoload))
            return false;
        $this->query("INSERT INTO " . DB_PREFIX . "option
                                (id, name, value, autoload) VALUES
                                ('', '{$name}', '{$value}', '{$autoload}' ");

        return $this->insert_id();
    }

    private function update($name, $value, $autoload = false)
    {
        $name = trim($name);
        $value = trim($value);
        if (!$name || !$value)
            return false;
        if (!is_bool($autoload))
            return false;

        $this->query("UPDATE " . DB_PREFIX . "option SET value='{$value}', autoload='{$autoload}' WHERE name='{$name}'");
    }

    public function getOption($option)
    {
        if (!isset($this->data[$option])) {
            $this->data[$option] = $this->get($option);
        }

        $this->data[$option] = @unserialize($this->data[$option]);

        return $this->data[$option];
    }

    public function updateOption($option, $value, $autoload = false)
    {
        $value = $this->maybe_serialize($value);

        if (isset($this->data[$option])) {
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