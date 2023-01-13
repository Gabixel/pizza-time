<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCUMENT_ROOT . '/common/sql.php';

class AdminHandler
{
	public static function table_exists(&$sql_query, $table_name)
	{
		$query = "SELECT * FROM `$table_name` LIMIT 1";

		$result = $sql_query->request($query);

		return $result;
	}

	private static function has_auto_increment(&$sql_query, $table_name)
	{
		$ai = self::get_auto_increment($sql_query, $table_name);

		return $ai == true;
	}

	// Generate the options for a list with the available tables
	public static function generate_table_options(&$sql_query, $requested_table, $show_empty)
	{
		$table_list = '';

		// If there's no table requested or the requested table does not exists, add the empty option
		if ($show_empty)
			$table_list .= "<option disabled selected></option>\n";

		// Check if the connection has been established correctly
		if (!$sql_query->is_db_connected()) return $table_list;

		$tables = AdminHandler::get_available_tables($sql_query);

		if (count($tables) == 0) return $table_list;

		foreach ($tables as $table) {
			$table_list .= "\t\t\t\t<option" . ($requested_table == $table ? ' selected' : '') . ">$table</option>\n";
		}

		return $table_list;
	}

	private static function get_auto_increment(&$sql_query, $table_name)
	{
		$query =
			"SELECT `AUTO_INCREMENT`
			FROM  	INFORMATION_SCHEMA.TABLES
			WHERE 	TABLE_SCHEMA = '" . $sql_query->get_db_name() . "'
			AND   	TABLE_NAME   = '$table_name'";

		return $sql_query->request($query)->fetch_array()['AUTO_INCREMENT'];
	}

	// Generates a table with info of the selected MySQL table
	public static function generate_table(&$sql_query, $table_name)
	{
		$printed_table = '';

		$AI = self::get_auto_increment($sql_query, $table_name);
		if ($AI)
			$printed_table .= "<p>Auto_Increment Attuale: $AI</p>\n";

		$order_by = $order = '';
		$table = self::get_table($sql_query, $table_name, $order_by, $order);

		if (!$table) return;

		$printed_table .= "<table class=\"dbTable\" cellspacing=\"0\">\n";

		$password_col = -1;
		$printed_table .= self::generate_thead($table['columns'], $password_col, $order_by, $order);

		$printed_table .= self::generate_tbody($table['rows'], $password_col, $table['columns']);

		$printed_table .= "</table>\n";

		return $printed_table;
	}

	// Delete selected rows
	public static function delete_rows(&$sql_query, $table_name, $rows)
	{
		$order_by = $order = '';
		$primary_key = self::get_table($sql_query, $table_name, $order_by, $order)['columns'][0];

		$query =
		"DELETE FROM `$table_name` WHERE ";

		$rows_query = '';
		$i = 0;

		foreach ($rows as $row) {
			// concatenation
			if ($i - 1 < (count($rows) - 1) && $i > 0) $rows_query .= ' OR ';

			$rows_query .= "($row)";

			$i++;
		}

		$query .= $rows_query;

		$sql_query->request($query);

		if (self::has_auto_increment($sql_query, $table_name))
		self::recalc_auto_increment($sql_query, $table_name, $primary_key);
	}

	// Retrieves the available tables
	private static function get_available_tables(&$sql_query)
	{
		if (!$sql_query->is_db_connected()) return [];

		$query = "SHOW TABLES";

		$table_list = [];

		// Request the table list
		$tables_request = $sql_query->request($query);

		// If there are tables
		if ($tables_request->num_rows > 0) {
			for ($i = 0; $i < $tables_request->num_rows; $i++) {
				$table_list[$i] = $tables_request->fetch_array()[0];
			}
		}

		return $table_list;
	}

	private static function generate_thead($columns, &$password_col, $current_order_by, $current_order)
	{
		$head = "<thead>\n";
		$head .= "\t<tr>\n";

		$url = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

		$i = 0;

		// Checkbox column
		$head .= "\t\t<th></th>\n";

		foreach ($columns as $col) {
			$uri = $url . '?table=' . $_GET['table'] . "&orderBy=$col";

			$new_order = 'ASC';

			// If the current column is the user password
			if ($col == 'password') $password_col = $i;

			if ($col == $current_order_by) {
				$arrow = '<i class="fas fa-sort-up"></i>';

				if ($current_order == 'DESC') $arrow = '<i class="fas fa-sort-down"></i>';

				$col .= $arrow;

				if ($current_order == $new_order) $new_order = 'DESC';
			}

			$uri .= "&orderType=$new_order";

			$head .= "\t\t<th><a href=\"$uri\">$col</a></th>\n";

			$i++;
		}

		$head .= "\t</tr>\n";
		$head .= "</thead>\n";
		return $head;
	}

	private static function generate_tbody($rows, $password_col, $cols)
	{
		$body = "<tbody>\n";
		foreach ($rows as $row) {
			$body .= "\t<tr>\n";

			$body .= "\t\t<td><input type=\"checkbox\" name=\"selectedRows[]\" value=\""
				. self::generate_checkbox_value($cols, $row) . "\" form=\"tableList\"></td>\n";

			$j = 0;
			foreach ($row as $field) {
				// Default field text
				if (is_null($field)) $field = '-';

				$html_field = htmlentities($field);

				if ($html_field != $field) $field .= " ($html_field)";

				// Password column
				$hidden = ($password_col >= 0 && $j++ == $password_col) ? 'class="hidden"' : '';

				$body .= "\t\t<td $hidden><span>$field</span>";

				if ($hidden) {
					$body .= '<i class="fas fa-eye-slash"></i>';
					$body .= '<span class="timer"></span>';
				}

				$body .= "</td>\n";
			}
			$body .= "\t</tr>\n";
		}
		$body .= "</tbody>\n";
		return $body;
	}

	private static function generate_checkbox_value($columns, $fields)
	{
		$query = '';
		$i = 0;

		foreach ($columns as $col) {
			// concatenation
			if ($i - 1 < (count($columns) - 1) && $i > 0) $query .= ' AND ';

			$query .= "`$col` = '$fields[$i]'";

			$i++;
		}

		return $query;
	}

	// Retrieves the selected table
	private static function get_table(&$sql_query, $table_name, &$order_by, &$order)
	{
		$table_name = $sql_query->escape_string($table_name);

		// Request table
		$query =
			"SELECT *
			FROM `$table_name`";

		// Check for filters
		self::get_filters($sql_query, $table_name, $order_by, $order);
		if ($order_by && $order)
			$query .= " ORDER BY $order_by $order";

		$table_request = $sql_query->request($query);

		if (!$table_request || $table_request->field_count == 0) return;

		// Get columns
		$columns = $table_request->fetch_fields();

		$i = 0;
		$table = ['columns' => [], 'rows' => []];

		foreach ($columns as $col) {
			// Store columns name
			$table['columns'][$i++] = $col->name;
		}

		$i = 0;
		while ($row = $table_request->fetch_row()) {
			$table['rows'][$i++] = $row;
		}

		return $table;
	}

	private static function recalc_auto_increment($sql_query, $table_name, $primary_key) {
		$max = $sql_query->request("SELECT MAX(`$primary_key`) AS 'max_id' FROM `$table_name`")->fetch_array()['max_id'] + 1;
		$query = "ALTER TABLE `$table_name` AUTO_INCREMENT = $max";

		$sql_query->request($query);
	}

	private static function get_filters(&$sql_query, $table_name, &$order_by, &$order)
	{
		$table = (self::table_exists($sql_query, $table_name))->fetch_fields();
		$table_col = [];

		$i = 0;
		foreach ($table as $col) {
			$table_col[$i++] = $col->name;
		}

		$order = 'ASC';

		if (isset($_GET['orderType']) && $_GET['orderType'] == 'DESC') {
			$order = $_GET['orderType'];
		}

		$order_by = $table_col[0];

		if (isset($_GET['orderBy'])) {
			if (!in_array($_GET['orderBy'], $table_col)) return;

			$order_by = $_GET['orderBy'];
		}
	}
}
