<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright �2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################
include_once(INCLUDE_DIR. 'global.php');

class db_main
{
    var $setts = array();
    var $layout = array();
    var $nb_queries = 0;
    var $die = true;
    var $query_error = null;
    var $db_prefix = DB_PREFIX; ## for PPB & PPA Integration

    var $display_errors = false; ## by default the sql errors are not displayed; change to true to be displayed (for debugging purposes only)

    function connect($host, $username, $password)
    {
        $result = @mysql_connect($host, $username, $password);

        if (!$result) {
            $error = $this->display_error(MSG_ERROR_MYSQL_CONNECT, $this->sql_error());

            if ($this->die) {
                die ($error);
            } else {
                return false;
            }
        } else {
            return true;
        }

    }

    function select_db($database)
    {
        $result = @mysql_select_db($database);

        if (!$result) {
            $error = $this->display_error(MSG_ERROR_MYSQL_SELECT_DB, $this->sql_error($result));

            if ($this->die) {
                die ($error);
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function sql_error()
    {
        return @mysql_error();
    }

    function display_error($error_message, $sql_error = '', $sql_query = '')
    {
        $display_output = '<p style="font-family: arial; font-size: 12px;"><strong>' . MSG_MYSQL_ERROR_OCCURRED . '</strong>' .
            '<ul>' .
            '<li style="font-family: arial; font-size: 12px;">' . $error_message . '</li>' .
            ((!empty($sql_error) && DEBUG) ? '<li style="font-family: arial; font-size: 12px;"><strong>' . MSG_SQL_ERROR . ':</strong> ' . $sql_error . '</li>' : '') .
            ((!empty($sql_query) && DEBUG) ? '<li style="font-family: arial; font-size: 12px;"><strong>' . MSG_SQL_QUERY . ':</strong> ' . $sql_query . '</li>' : '') .
            '</ul></p>';

        return $display_output;
    }

    public function beginTransaction()
    {
        if ($this->query("START TRANSACTION"))
            return true;
        else
            return false;
    }

    public function commit()
    {
        if ($this->query("COMMIT"))
            return true;
        else
            return false;
    }

    public function rollBack()
    {
        if ($this->query("ROLLBACK"))
            return true;
        else
            return false;
    }

    private function hasError()
    {
        if (mysql_errno())
            return true;
        else
            return false;
    }


    function query($query, $debug_output = false, $die = true)
    {
        //echo $query . '<br>'; ## used if we want to display all queries made on a page

        $result = @mysql_query($query);

        if ($this->hasError()) {

            $mysql_error = $this->display_error(MSG_ERROR_MYSQL_QUERY, $this->sql_error($result), $query);
            if (DEBUG)
                $mysql_error .= "<p>{$query}</p>";
            if ($die) {
                die($mysql_error);
            } else {
                $this->query_error = $mysql_error;

                return null;
            }
        } else {
            return $result;
        }
    }

    function query_silent($query)
    {
        $result = @mysql_query($query);

        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    function insert_id()
    {
        return @mysql_insert_id();
    }

    function sql_result($query_result, $row_id, $field_name)
    {
        $result = @mysql_result($query_result, $row_id, $field_name);

        if ($this->sql_error($result)) {
            throw new Exception($this->display_error(MSG_ERROR_MYSQL_RESULT, $this->sql_error($result)));
        }

        return $result;
    }

    function num_rows($query_result)
    {
        $result = @mysql_num_rows($query_result);

        if ($this->sql_error($result)) {
            throw new Exception($this->display_error(MSG_ERROR_MYSQL_NUM_ROWS, $this->sql_error($result)));
        }

        return $result;
    }

    function fetch_array($query_result, $assoc = false)
    {
        {
            $result = @mysql_fetch_array($query_result, ($assoc) ? MYSQL_ASSOC : MYSQL_BOTH);

            if ($this->sql_error($result)) {
                throw new Exception($this->display_error(MSG_ERROR_MYSQL_FETCH_ARRAY, $this->sql_error($result)));
            }

            return $result;
        }
    }

    function fetch_all($query_result, $assoc = false)
    {
        $a = array();
        while ($a[] = @mysql_fetch_array($query_result, ($assoc) ? MYSQL_ASSOC : MYSQL_BOTH)) ;
        array_pop($a);
        return $a;
    }
}

class database extends db_main
{


    public function maybe_serialize($data)
    {
        if (is_array($data) || is_object($data))
            return serialize($data);
        else
            return $data;
    }

    public function maybe_unserialize($data)
    {
        if ($this->is_serialized($data)) // don't attempt to unserialize data that wasn't serialized going in
            return @unserialize($data);

        return $data;
    }

    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @since 2.0.5
     *
     * @param mixed $data Value to check to see if was serialized.
     * @return bool False if not serialized and true if it was.
     */
    public function is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        $length = strlen($data);
        if ($length < 4)
            return false;
        if (':' !== $data[1])
            return false;
        $lastc = $data[$length - 1];
        if (';' !== $lastc && '}' !== $lastc)
            return false;
        $token = $data[0];
        switch ($token) {
            case 's' :
                if ('"' !== $data[$length - 2])
                    return false;
            case 'a' :
            case 'O' :
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                return (bool)preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }
        return false;
    }


    function get_sql_field($query, $field, $null_message = NULL)
    {
        (string)$field_value = NULL;

        $query_result = $this->query($query);

        if ($this->num_rows($query_result)) {
            $field_value = $this->sql_result($query_result, 0, $field);
        } else {
            $field_value = $null_message;
        }

        return $field_value;
    }

    function get_sql_number($query) /* obsolete function */
    {
        $result = $this->query($query);
        $nb_rows = $this->num_rows($result);

        return $nb_rows;
    }

    /**
     * New function to count the number of rows in a table
     * very fast but it will need a different set of params
     * Preferrably get_sql_number wont be used anymore at all.
     *
     * To make it more flexible, the WHERE clause will need to be added when
     * constructing the condition.
     */
    function count_rows($table_name, $condition = null, $debug = false)
    {
        $query_result = $this->query("SELECT count(*) AS count_rows FROM " . $this->db_prefix . $table_name . " " . $condition, $debug);
        $count_rows = $this->sql_result($query_result, 0, 'count_rows');

        return $count_rows;
    }

    function get_sql_row($query, $debug = false)
    {
        (array)$row_result = NULL;

        $query_result = $this->query($query, $debug);

        if ($this->num_rows($query_result)) {
            $row_result = $this->fetch_array($query_result);
        }

        return $row_result;
    }

    function table_fields($table_name)
    {
        (array)$result = NULL;

        $query_result = $this->query("SHOW COLUMNS FROM " . $table_name);
        while ($row = mysql_fetch_array($query_result)) $result[] = $row[0];

        return $result;
    }

    function implode_array($values_array = null, $glue = ',', $array_check = true, $default_result = '0')
    {
        (string)$result = $default_result;
        (array)$formatted_array = null;

        if (is_array($values_array) || !$array_check) {
            foreach ($values_array as $value) {
                $formatted_array[] = (empty($value)) ? 0 : $value;
            }

            $result = implode($glue, $values_array);
        }

        return $result;
    }

    function rem_special_chars($string)
    {
        $string = stripslashes($string);
        //	$string = eregi_replace("'","&#039;",$string);
//	$string = eregi_replace('"','&quot;',$string);
        $string = str_replace("'", "&#039;", $string);
        $string = str_replace('"', '&quot;', $string);

        return $string;
    }

    function rem_special_chars_array($input_array)
    {
        (array)$output = null;

        foreach ($input_array as $key => $value) {
            if (!is_array($value)) $output[$key] = $this->rem_special_chars($value);
            else $output[$key] = $value;
        }

        return $output;
    }

    function add_special_chars($string, $no_quotes = FALSE)
    {
        $pattern = "/(?i)<img.+\.php/";
        /*
                $string = eregi_replace("&amp;","&",$string);

                if (!$no_quotes)
                $string = eregi_replace("&#039;","'",$string);

                $string = eregi_replace('&quot;','"',$string);
                $string = eregi_replace('&lt;','<',$string);
                $string = eregi_replace('&gt;','>',$string);
                $string = eregi_replace('&nbsp;',' ',$string);
        */
        if (!$no_quotes)
            $string = htmlspecialchars_decode($string, ENT_COMPAT);
        else
            $string = htmlspecialchars_decode($string, ENT_QUOTES);

        $string = str_replace("&nbsp;", " ", $string);

        $string = (preg_match($pattern, $string)) ? strip_tags($string, '<br>') : $string;

        return $string;
    }

    // added the check_voucher function here so it can be used by all fees related classes
    function check_voucher($voucher_value, $voucher_type, $use_voucher = false)
    {
        $output = array('valid' => false, 'voucher_type' => null, 'display' => null, 'reduction' => 0, 'assigned_fees' => null);

        $sql_select_voucher = $this->query("SELECT * FROM " . $this->db_prefix . "vouchers WHERE
			voucher_code='" . $voucher_value . "' AND voucher_type='" . $voucher_type . "' AND
			(exp_date=0 OR exp_date>=" . CURRENT_TIME . ") AND (uses_left>0 OR nb_uses=0) LIMIT 0,1");

        $is_voucher = $this->num_rows($sql_select_voucher);

        if ($is_voucher) {
            $voucher_details = $this->fetch_array($sql_select_voucher);

            $output['valid'] = true;
            $output['display'] = '<table cellpadding="3" width="100%" class="errormessage"><tr><td>' . GMSG_VOUCHER_VALID . '</td></tr></table>';
            $output['reduction'] = $voucher_details['voucher_reduction'];
            $output['assigned_fees'] = $voucher_details['assigned_fees'];
            $output['voucher_type'] = $voucher_details['voucher_type'];

            if ($voucher_details['nb_uses'] > 0 && $use_voucher) {
                $sql_update_uses_left = $this->query("UPDATE " . $this->db_prefix . "vouchers SET
					uses_left=uses_left-1 WHERE voucher_id=" . $voucher_details['voucher_id']);
            }
        } else {
            $output['display'] = '<table cellpadding="3" width="100%" class="errormessage"><tr><td class=redfont>' . GMSG_VOUCHER_INVALID . '</td></tr></table>';
        }

        return $output;
    }

    function main_category($category_id)
    {
        (int)$result = 0;

        if ($category_id > 0) {
            $main_category = $category_id;
            while ($main_category > 0) {
                $result = $main_category;
                $main_category = $this->get_sql_field("SELECT parent_id FROM " . $this->db_prefix . "categories WHERE
					category_id='" . $main_category . "'", 'parent_id');
            }
        }

        return $result;
    }

    function random_rows($table_name, $table_fields, $condition, $nb_rows, $debug = false)
    {
        (array)$random_numbers = null;
        (array)$primary_fields_array = null;
        (array)$result = null;
        (int)$counter = 0;

        $table_rows = $this->count_rows($table_name, $condition);
        //$table_rows = ($table_rows > 100) ? 100 :$table_rows;

        $total_rows = ($table_rows > $nb_rows) ? $nb_rows : $table_rows;

        while ($counter < $total_rows) {
            $number = rand(0, ($table_rows - 1));

            if (!@in_array($number, $random_numbers)) {
                $random_numbers[] = $number;
                $counter++;
            }
        }

        if (is_array($random_numbers)) {
            foreach ($random_numbers as $value) {
                $result[] = $this->get_sql_row("SELECT " . $table_fields . " FROM
					" . $this->db_prefix . $table_name . " " . $condition . " LIMIT " . $value . ", 1", $debug);
            }
        }

        return $result;
    }
}

?>