<?php

/*
Plugin name: gerneralforms
*/
global $jal_db_version;
$jal_db_version = '1.0';
define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));
class MyPlugin {  

     public $pluginName;


 function register(){
        add_action('admin_enqueue_scripts',array($this,'enqueue'));

        add_action('admin_menu',array($this,'add_admin_page'));

        add_filter( "plugin_action_links_$this->pluginName", array($this,'settings_link'));
    }
       function enqueue(){
    //enqueue all our scripts
    wp_enqueue_style('mypluginstyle','https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css');
    // wp_enqueue_script('mypluginstyle1','https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
    wp_enqueue_script('mypluginstyle2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js');
    wp_enqueue_script('mypluginstyle3','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js');

   }
    public  function settings_link($links)
    {
        //add code settings link
        $settingslink='<a href="admin.php?page=iqra_plugin">settings</a>';
        array_push($links, $settingslink);
        return $links;
    }
     public function add_admin_page(){
        add_menu_page('Iqra F charts','chart sizes','manage_options','iqra_plugin',array($this,'admin_index'),'dashicons-universal-access',10);
    } 
     public function admin_index(){
        //required admin template
    require_once  PLUGIN_PATH .'templates/admin_index.php';

    }

    public static function baztag_func( $atts, $content = "" ) {

     	$user_id = get_current_user_id();
		
    	$content = '
    	<form method="post">
    <input type="text" class="form-control" name="user_id" value="'.$user_id.'" id="user"  hidden>
    <div class="form-group col-md-12">
      <label for="inputEmail4">name</label>
      <input type="text" class="form-control" name="chart_name" id="chart_name"  >
    </div>
      <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputEmail4">SHOULDER</label>
      <input type="text" class="form-control" name="shoulder" id="shoulder"  >
    </div>
    
  
  <div class="form-group col-md-4">
    <label for="inputAddress">BUST</label>
    <input type="text" class="form-control" name="bust" id="bust"  >
  </div>
   <div class="form-group col-md-4">
    <label for="inputAddress">WAIST</label>
    <input type="text" class="form-control" name="waist" id="waist"  >
  </div>
</div>
    <div class="form-row">
   <div class="form-group col-md-4">
    <label for="inputAddress">HIP</label>
    <input type="text" class="form-control" name="hip" id="hip"  >
  </div>
   <div class="form-group col-md-4">
    <label for="inputAddress">SHIRT LENGTH</label>
    <input type="text" class="form-control" name="shirt_length" id="shirt_length"  >
  </div>
   <div class="form-group col-md-4">
    <label for="inputAddress">ARMHOLE</label>
    <input type="text" class="form-control" name="armhole" id="armhole"  >
  </div>
</div>
  <div class="form-row">
   <div class="form-group col-md-4">
    <label for="inputAddress">SLEVE LENGHT</label>
    <input type="text" class="form-control" name="sleve_hole" id="sleve_hole"  >
  </div>
   <div class="form-group col-md-4">
    <label for="inputAddress">WRIST</label>
    <input type="text" class="form-control" name="wrist" id="wrist"  >
  </div>
   
</div>
<div class="form-group col-md-12">
    <label for="inputAddress">Add Notes</label>
    <input type="text" class="form-control" name="addnote" id="addnote"  >
  </div>
  <div class="col-md-9">
  <button type="submit" name="submit" class="btn btn-primary chartbrn">Add size chart</button>
</div>
</form>';

        return "$content";    
    }

public static function baztag_func_db(){
	if ( isset( $_POST['submit'] ) ){

global $wpdb;
    $table_name = $wpdb->prefix . 'iqrafchaudhry';

$data=array(
'chart_name' => $_POST[ 'chart_name'],
'user_id' => $_POST[ 'user_id'],
'shoulder' => $_POST[ 'shoulder'],
'waist' => $_POST[ 'waist'],
'bust' => $_POST[ 'bust'],
'hip' => $_POST[ 'hip'],
'shirt_length' => $_POST[ 'shirt_length'],
'armhole' => $_POST[ 'armhole'],
'sleve_hole' => $_POST[ 'sleve_hole'],
'wrist' => $_POST[ 'wrist'],
'addnote' => $_POST[ 'addnote']
);

$wpdb->insert( $table_name, $data);

}
}



function jal_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'iqrafchaudhry';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        chart_name tinytext NOT NULL,
        user_id tinytext NOT NULL,
        shoulder tinytext NOT NULL,
        waist tinytext NOT NULL,
        bust tinytext NOT NULL,
        hip tinytext NOT NULL,
        shirt_length tinytext NOT NULL,
        armhole tinytext NOT NULL,
        sleve_hole tinytext NOT NULL,
        wrist tinytext NOT NULL,
        addnote text NOT NULL,
         PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'jal_db_version', $jal_db_version );
}

//closing tag of myplugin class
}


if(class_exists('MyPlugin')) {
// activation hook for creating activation 
 $obj=new MyPlugin();
 register_activation_hook( __FILE__, array($obj,'jal_install') );

//for creating admin chart sise link and page
    $obj->register();
    //$obj->registerfrntend();
}
add_action( 'wp_head',array( 'MyPlugin', 'baztag_func_db' ) ) ;
add_shortcode( 'baztag', array( 'MyPlugin', 'baztag_func' ) );


?>