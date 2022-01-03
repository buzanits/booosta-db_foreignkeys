<?php
namespace booosta\db_foreignkeys;

class Db_foreignkeys extends \booosta\base\Module
{
  use moduletrait_db_foreignkeys;

  protected $data;

  public function __construct($tables = null)
  {
    parent::__construct();

    if(is_string($tables)) $tables = explode(',', $tables);
    $fkeys = $this->DB->DB_foreignkeys($tables);

    $this->data = [];

    foreach($fkeys as $fkey):
      $this->data['foreign_table'][$fkey['table_name']][$fkey['column_name']] = $fkey['referenced_table_name'];
      $this->data['foreign_column'][$fkey['table_name']][$fkey['column_name']] = $fkey['referenced_column_name'];
      $this->data['local_column'][$fkey['table_name']][$fkey['referenced_table_name']] = $fkey['column_name'];
    endforeach;
    #\booosta\debug($this->data);
  }

  public function referenced_table($table, $column) { return $this->get('foreign_table', $table, $column); }
  public function referenced_column($table, $column) { return $this->get('foreign_column', $table, $column); }
  public function local_column($table, $referenced_table) { return $this->get('local_column', $table, $referenced_table); }

  protected function get($list, $idx1, $idx2)
  {
    if(isset($this->data[$list][$idx1][$idx2])) return $this->data[$list][$idx1][$idx2];
    return null;
  }
}
