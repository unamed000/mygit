<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 22/5/2015
 * Time: 2:04 PM
 */

class MY_Model extends CI_Model{

    var $table = '';
    var $table_type = '';

    function get_primary_key_arr(){
        $field_data = $this->db->field_data($this->table);
        $ret = array();
        foreach($field_data as $row){
            if($row->primary_key){
                $ret[] = $row->name;
            }
        }
        return $ret;
    }

    function get_table_field_arr(){
        return $this->db->list_fields($this->table);
    }

    function save($array){
        $table_field_arr = $this->get_table_field_arr();
        $filter_array = array();
        $pri_key_arr = $this->get_primary_key_arr();
        $pri_key_value_list = array();
        foreach($array as $key=>$value){
            if(!in_array($key,$table_field_arr) || is_null($value)){
                continue;
            }
            $filter_array[$key] = $value;
            if(in_array($key,$pri_key_arr)){
                $pri_key_value_list[$key] = $value;
            }
        }
        if(count($pri_key_value_list) == count($pri_key_arr)){
            $is_existed = $this->db->get_where($this->table,$pri_key_value_list)->num_rows();
            if($is_existed){
                if(!isset($filter_array['updated_date'])){
                    $filter_array['updated_date'] = date($this->config->item('database_date_standard'));
                }
                $this->db->update($this->table,$pri_key_value_list,$filter_array);
                return $pri_key_value_list;
            }
        }
        if(!isset($filter_array['created_date'])){
            $filter_array['created_date'] = date($this->config->item('database_date_standard'));
        }
        if(!isset($filter_array['status'])){
            $filter_array['status'] = 1;
        }
        $this->db->insert($this->table,$filter_array);
        return $this->db->insert_id();
    }

}