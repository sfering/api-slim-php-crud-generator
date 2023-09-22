<?php

namespace App\Command;

class CrudGeneratorEntity
{
    public $list1, $list2, $list3, $list4, $list5, $list6;

    /**
     * Get Dynamic Parameters and Fields List.
     */
    public function getParamsAndFields($db, $table)
    {
        $fields = $this->getEntityFields($db, $table);
        foreach ($fields as $field) {
            $this->getFieldsList($field, $table);
        }
        $this->cleanFields();
    }

    public function getEntityFields($db, $table)
    {
        $query = "DESC `$table`";
        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getFieldsList($field, $table)
    {
        $this->list1 .= sprintf("`%s`, ", $field['Field']);
        $this->list2 .= sprintf(":%s, ", $field['Field']);
        $this->list3 .= sprintf('$statement->bindParam(\'%s\', $%s->%s);%s', $field['Field'], $table, $field['Field'], PHP_EOL);
        $this->list3 .= sprintf("        %s", '');
        if ($field['Field'] != 'id') {
            $this->list4 .= sprintf("`%s` = :%s, ", $field['Field'], $field['Field']);
            $this->list5 .= sprintf("if (isset(\$data->%s)) {%s", $field['Field'], PHP_EOL);
            $this->list5 .= sprintf("            $%s->%s = \$data->%s;%s", $table, $field['Field'], $field['Field'], PHP_EOL);
            $this->list5 .= sprintf("        }%s", PHP_EOL);
            $this->list5 .= sprintf("        %s", '');
            if ($field['Null'] == "NO" && strpos($field['Type'], 'varchar') !== false) {
                $this->list6 .= sprintf("'%s' => '%s',%s", $field['Field'], 'aaa', PHP_EOL);
                $this->list6 .= sprintf("            %s", '');
            }
            if ($field['Null'] == "NO" && strpos($field['Type'], 'int') !== false) {
                $this->list6 .= sprintf("'%s' => %s,%s", $field['Field'], 1, PHP_EOL);
                $this->list6 .= sprintf("            %s", '');
            }
        }
    }

    public function cleanFields()
    {
        $this->list1 = mb_substr($this->list1, 0, -2);
        $this->list2 = mb_substr($this->list2, 0, -2);
        $this->list3 = mb_substr($this->list3, 0, -8);
        $this->list4 = mb_substr($this->list4, 0, -2);
        $this->list5 = mb_substr($this->list5, 0, -9);
        $this->list6 = mb_substr($this->list6, 0, -14);
    }
}
