<?php
/*
 * DB class
 * 
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Db {
    
    use Singleton;
    
    //DB Tables names
    public $photos_table = 'sightline_photos';
    
    //Construct function
    protected function __construct() {
        
        //load class
        $this->setup_hooks();
    }
    
    /*
     * Function to load action and filter hooks
     */
    protected function setup_hooks() {
        
        //actions and filters        
    }
    
    /*
     * insert record into database
     * 
     * @param $table table in which we will insert record
     * @param $data array of data that we will insert
     * 
     * return last insert id
     */
    
    public function add_record( $table = '', $data = array() ) {
        
        if( empty($data) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $exclude = array( 'btnsave' );
        $attr = "";
        $attr_val = "";
        foreach( $data as $k=>$val ) {            
            if(is_array($val)) {
                $val = maybe_serialize($val);
            }else{
                $val = $this->make_safe($val);
            }
            if( !in_array( $k, $exclude )) { 
                if( $attr == "" ) {
                    $attr.="`".$k."`";
                    $attr_val.="'".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";
                }else{
                    $attr.=", `".$k."`";
                    $attr_val.=", '".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";
                }                
            }
        }
        $sql = "INSERT INTO `".$wpdb->prefix.$table."` (".$attr.") VALUES (".$attr_val.")";
        $wpdb->query($sql);
        $lastid = $wpdb->insert_id;
        return $lastid;        
    }
    
    /*
     * insert multiple records into database
     * 
     * @param $table table in which we will insert record
     * @param $data array of data that we will insert
     * 
     * return last insert id
     */
    public function add_multiple_records( $table = '', $attr = array(), $data = array() ) {
        
        if( empty($data) || empty($table) || empty($attr) ) {
            return false;
        }
        
        global $wpdb;
        
        $exclude = array( 'btnsave' );
        $attr_str = "";
        foreach( $attr as $v ) {
            if( $attr_str == "" ) {
                $attr_str.="`".$v."`";
            }else{
                $attr_str.=", `".$v."`";
            }                
        }
        $attr_val = "";
        foreach( $data as $row ) { 
            if( $attr_val == '' ) {
                $attr_val.='(';
            }else{
                $attr_val.=',(';
            }
            $attr_val_row = '';
            
            foreach( $attr as $k ) {
                $val = $row[$k];
                if(is_array($val)) {
                    $val = maybe_serialize($val);
                }else{
                    $val = $this->make_safe($val);
                }
                if( !in_array( $k, $exclude )) {
                    if( $attr_val_row == "" ) {
                        $attr_val_row.="'".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";
                    }else{
                        $attr_val_row.=", '".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";
                    }
                }
            }
            
            $attr_val.= $attr_val_row.')';
        }
        $sql = "INSERT INTO `".$wpdb->prefix.$table."` (".$attr_str.") VALUES ".$attr_val;
        $wpdb->query($sql);
        $lastid = $wpdb->insert_id;
        return $lastid;    
    }
    
    /*
     * update record into database
     * 
     * @param $table table for which we will update record
     * @param $data array of data that we will update
     * @param $where string for where clause of sql
     */
    public function update_record( $table = '', $data = array(), $where = '' ) {
        
        if( empty($where) || empty($data) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $exclude = array( 'id','btnsave' );
        $attr = "";
        foreach( $data as $k=>$val ) {
            if(is_array($val)) {
                $val = maybe_serialize($val);
            }else{
                $val = $this->make_safe($val);
            }
            if( !in_array( $k, $exclude )) {
                if( $attr == "" ) {
                    $attr.="`".$k."` = '".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";                    
                }else{
                    $attr.=", `".$k."` = '".addslashes($val)."'";//str_replace("'", "\\'",$val)."'";
                }                
            }
        }
        $sql = "UPDATE `".$wpdb->prefix.$table."` SET ".$attr." WHERE ".$where;
        $wpdb->query($sql);
        
        return true;
    }
    
    /*
     * delete record from database
     * 
     * @param $table table from which we will delete record
     * @param $where string for where clause of sql
     */
    public function del_record( $table = '', $where = '' ) {
        
        if( empty($where) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $sql = "DELETE FROM `".$wpdb->prefix.$table."` WHERE ".$where;
        $wpdb->query($sql);
        return true;
    }
    
    /*
     * get data from the database table
     * 
     * @param $table database table from which we will get records
     * @param $where string for where clause of sql
     * @param $get_row return only one row or all rows
     * @param $attr string 
     * 
     * return a row or all rows objects
     */
    public function get_data( $table = '', $where = "1", $get_row = false, $attr = "*" ) {
        
        if( empty($table) ) {
            return false;
        }
        
        global $wpdb;
        
        $sql = "SELECT ".$attr." FROM `".$wpdb->prefix.$table."` WHERE ".$where;
        if( $get_row ) {
            $data = $wpdb->get_row($sql);
        }else{
            $data = $wpdb->get_results($sql);
        }
        
        if( !empty($data) ) {
            $final_data = [];
            if( $get_row ) {
                foreach( $data as $k=>$v ) {
                    $final_data[$k] = stripcslashes($v);
                }
                $data = (object) $final_data;
            }else{
                foreach( $data as $key=>$row ) {
                    $record = [];
                    foreach ( $row as $k=>$v ) {
                        $record[$k] = stripcslashes($v);
                    }
                    $final_data[$key] = (object) $record;
                }
                $data = $final_data;
            }
        }
        
        return $data;
    }
    
    /*
     * make a variable snaitize and 
     * handel quotes double quotes and other characters 
     * 
     * @param $variable
     * 
     * return snaitizeed variable 
     */
    public function make_safe( $variable ) {

        $variable = sanitize_text_field($variable);
        $variable = esc_html($variable);
        
        return $variable;
    }
    
    /*
     * Function to add new column into database table
     */
    public function add_colum_to_table( $table, $column, $type="varchar(255)" ) {
        
        global $wpdb;
        
        if( empty($table) || empty($column) ) {
            return false;
        }
        
        $existing_columns = $wpdb->get_col("DESC `".$wpdb->prefix.$table."`", 0);
        if(in_array( $column, $existing_columns ) ) {
            return false;
        }
        
        $sql="ALTER TABLE `".$wpdb->prefix.$table."`
                          ADD ".$column." ".$type;
        
        $wpdb->query($sql);
    }
    
    /*
     * Function to create properties photos database table
     */
    public function create_photos_table() {
        
        global $wpdb;
        
        $sql="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix.$this->photos_table."` (
                          `id` bigint(20) NOT NULL AUTO_INCREMENT,
                          `url` varchar(255) DEFAULT '',                          
                          PRIMARY KEY (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        
        $wpdb->query($sql);
    }    
}