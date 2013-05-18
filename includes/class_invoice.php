<?php

/**
 * Class to handle invoices
 *
 * @author Kien
 */
class invoice extends database
{

    public $table_invoice;
    public $table_invoice_status;
    public $data = array();

    /* Constructor.
     * Take invoice_id as parameter, set all associated keys to data array
     *  */
    public function __construct($invoice_id = null)
    {
        $this->setts = & $setts;
        $this->table_invoice = DB_PREFIX . 'invoices';
        $this->table_invoice_status = DB_PREFIX . 'invoice_statuses';
        if ($invoice_id) {
            $sql = $this->query("SELECT * FROM {$this->table_invoice } WHERE invoice_id='{$invoice_id}'");
            $result = $this->fetch_array($sql, true);
            if ($result) {
                foreach ($result as $key => $value) {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    /* Magic method getter */

    public function __get($name)
    {
        if ($name)
            return $name;
        else
            return null;
    }

    /* Magic method setter */

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /* Method to get invoice's statuses.
     * Parameter: status id. Default to get all statuses
     * Return: invoice's status(es) in array format with key as column's name.
     *  */

    public function getInvoiceStatus($id = "all")
    {

        $sql = "SELECT * FROM {$this->table_invoice_status}";
        if ($id == 'all') {
            $result = $this->fetch_all($this->query($sql), true);
        } else {
            $sql .= " WHERE invoice_status_id='$id'";
            $result = $this->fetch_array($this->query($sql), true);
        }
        return $result;
    }

    /* Get all invoices from an user
     * Parameter: user_id
     * return invoice assoc array */

    public function getInvoicesFromUser($user_id, $status = '')
    {
        $sql = ("SELECT * FROM  {$this->table_invoice} i ");
        if ($status)
            $sql .= " AND invoice_status = '{$status}'";

        $result = $this->query($sql);
        $invoices = $this->fetch_array($result, true);

        return $invoices;
    }

    public function getInvoicesFromItem($item_id, $status = '')
    {
        $sql = ("SELECT * FROM  {$this->table_invoice} i WHERE item_id='{$item_id}'");
        if ($status)
            $sql .= " AND invoice_status = '{$status}'";

        $result = $this->query($sql);
        $invoices = $this->fetch_array($result, true);

        return $invoices;
    }

    /* Get invoices of an item by invoice's state instead of status id */

    public function getItemInvoicesByState($state, $item_id)
    {
        $sql = "SELECT i.* FROM  {$this->table_invoice} i LEFT JOIN  {$this->table_invoice_status} s ON i.invoice_status=s.invoice_status_id WHERE s.state='{$state}'";
        if ($item_id)
            $sql .= " AND i.item_id='{$item_id}'";

        $result = $this->query($sql);
        $invoices = $this->fetch_all($result, true);

        return $invoices;
    }

    /* Update an invoice with data provided by property data */

    public function update()
    {
        if (!isset($this->data['invoice_id']))
            return false;

        $sql = "UPDATE {$this->table_invoice} SET ";

        foreach ($this->data as $key => $value) {
            $sql .= "{$key}='{$value}', ";
        }
        $sql = rtrim($sql, " ,");

        $sql .= " WHERE invoice_id='{$this->data['invoice_id']}'";

        $this->query($sql);
    }

}

?>
