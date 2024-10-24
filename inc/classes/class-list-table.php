<?php
/*
 * Class to show the admin list tables
 * 
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class List_Table extends \WP_List_Table {
    
    use Singleton;
    
    private $columns            = [];
    
    private $sortable_columns   = [];
    
    private $hidden_columns     = [];
    
    //private $bulk_actions       = [];
    
    //private $primary_attr_name  = '';
    
    //Construct function
    protected function __construct() {

        parent::__construct();
    }
    
    /*
     * Function to prepare items for the list table
     * 
     * @param $items array of items those would be displayed
     * @param $per_page integer per page value
     * @param $total_items integer number of total items
     */
    public function prepare_items( $items = [], $per_page = 10, $total_items = 100 ) {
        
        $current_page   = $this->get_pagenum();
        
        $columns        = $this->get_columns();        
        $hidden         = $this->get_hidden_columns();
        $sortable       = $this->get_sortable_columns();
        
        $this->_column_headers = [ $columns, $hidden, $sortable ];
        
        $this->set_pagination_args( [
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page                     //WE have to determine how many items to show on a page
          ] );
        
        $this->items = $items;
    }
      
    public function column_default( $item, $column_name ) {
        
        return $item[ $column_name ];        
    }
    
    /*
     * Function to set the columns
     * 
     * @param $columns array of columns those need to set
     */
    public function set_columns( $columns = [] ) {
        
        $this->columns = $columns;
    }
    
    /*
     * Function to get the columns
     * 
     * @return $columns array of columns
     */
    public function get_columns(){
        
        $columns = $this->columns;
        
        return $columns;
    }
    
    /*
     * Function to set the sortable columns
     * 
     * @param $columns array of sortable columns those need to set
     */
    public function set_sortable_columns( $columns = [] ) {
        
        $this->sortable_columns = $columns;
    }
    
    /*
     * Function to get the sortable columns
     * 
     * @return $sortable_columns array of sortable columns
     */
    public function get_sortable_columns() {
        
        $sortable_columns = $this->sortable_columns;
        
        return $sortable_columns;
    }
    
    /*
     * Function to set the hidden columns
     * 
     * @param $columns array of hidden columns those need to set
     */
    public function set_hidden_columns( $columns = [] ) {
        
        $this->hidden_columns = $columns;
    }
    
    /*
     * Function to get the hidden columns
     * 
     * @return $hidden_columns array of hidden columns
     */
    public function get_hidden_columns() {
        
        $hidden_columns = $this->hidden_columns;
        
        return $hidden_columns;
    }
    
    /*
     * Function that will use to add actions links. e.g. delete and edit
     * function name should mactch with one of the column id. e.g. function column_[XYZ Column Id](){}
     * 
     * @param $item array of item against which we will show the actions
     * 
     * @return $links string links of actions
     * /
    public function column_booktitle($item) {
        
        $attr_name    = $this->get_primary_attr_name();
          
        $actions = array(
                  'edit'      => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>',$_REQUEST['page'],'edit',$item[$attr_name]),
                  'delete'    => sprintf('<a href="?page=%s&action=%s&book=%s" onclick="javascript: return confirm(\'Are you sure you want to delete it?\');">Delete</a>',$_REQUEST['page'],'delete',$item[$attr_name]),
              );

        $links = sprintf('%1$s %2$s', $item['booktitle'], $this->row_actions($actions) );
        
        return $links;
    }
    
    /*
     * Function to set the primary attribute of the table
     * 
     * @param $attr_name string attribute name
     * /
    public function set_primary_attr_name( $attr_name ) {
        
        $this->primary_attr_name = $attr_name;
    }
    
    /*
     * Function to get the primary attribute of the table
     * 
     * @return $attr_name string attribute name
     * /
    public function get_primary_attr_name() {
        
        $attr_name = $this->primary_attr_name;
        
        return $attr_name;
    }
    
    /*
     * Function that will populate the checkbox column along with its value
     * 
     * @param $item array of item against which we will show the actions
     * 
     * @return $cb checkbox string
     * /
    public function column_cb($item) {
        
        $attr_name    = $this->get_primary_attr_name();
        
        $cb = sprintf(
            '<input type="checkbox" name="'.$attr_name.'[]" value="%s" />', $item[$attr_name]
        );   
        
        return $cb;
    }
    
    /*
     * Function to setup the bulk actions dropdown
     * 
     * @param $actions array of actions those will display in dropdown
     * /
    public function set_bulk_actions( $actions = [ 'delete'    => 'Delete' ] ) {
        
        $this->bulk_actions = $actions;        
    }
    
    /*
     * Function to return the bulk actions
     * 
     * @return $actions array of actions those will display in dropdown
     * /
    public function get_bulk_actions() {
        
        $actions = $this->bulk_actions;
     
        return $actions;
    }
    
    
    /*
     * Sample Admin side display
     * /
    public function sample_admin_page() {        
        
        $paged = isset($_REQUEST['paged'])?$_REQUEST['paged']:1;
        
        $data  = $db->get_data( $db->user_feedback_table );
        
        if( $data ) {
            
            $per_page       = 10;
            $total_items    = count( $data );
            
            if( $total_items > $per_page ) {
                $data = $db->get_data( $db->user_feedback_table, "1 LIMIT ".($paged*$per_page).", ".$per_page );
            }
     
            $list_table = List_Table::get_instance();

            $list_table->set_columns( [ 
                'cb' => '<input type="checkbox" />', 
                'id' => __( 'ID', SIGHTLINE_TEXT_DOMAIN ), 
                'import' => __( 'Import', SIGHTLINE_TEXT_DOMAIN ),
                'name' => __( 'Name', SIGHTLINE_TEXT_DOMAIN ), 
                'state' => __( 'State', SIGHTLINE_TEXT_DOMAIN ), 
                'zip_code' => __( 'Zip', SIGHTLINE_TEXT_DOMAIN ),
                'country' => __( 'Country', SIGHTLINE_TEXT_DOMAIN ) 
                ] );

            $list_table->set_primary_attr_name( 'id' );

            $items = [];

            if( is_array($data) ) {
                foreach( $data as $row ) {
                    
                    $item = [
                        'id' => $row->id,
                        'import' => '<div class="dot-flashing loading-dots-'.$row->id.'"></div><label class="toggler-wrapper toggler-wrapper-'.$row->id.' style-27"><input type="checkbox" class="vts_property_import" value="'.$row->id.'" ><div class="toggler-slider"><div class="toggler-knob"></div></div></label>',
                        'name' => $row->name,
                        'state' => $row->state,
                        'zip_code' => $row->zip_code,
                        'country' => $row->country
                    ];

                    $items[] = $item;
                }
            }

            $list_table->prepare_items( $items, $per_page, $total_items ); //Items to show, per page items, total items

            echo $list_table->display();
        }
    }

    */
}