<?php
/*
Plugin Name: Ennovation sols Widget
Description: Ennovation sols Plugin for search
Author: Ennovation sols
Version: 1

*/


class Search_Widget extends WP_Widget
{
 
   function Search_Widget() {
        parent::WP_Widget(false, $name = 'Ennovation sols Search Books');	
    }
  
 
  function form($instance)
  {
    $title = esc_attr($instance['title']);
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>
  ">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
  
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

	
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
              <?php echo $after_widget; ?>


 
   <!-- WIDGET CODE GOES HERE -->
<?php  if(isset($_GET['s_type'])){
		$s_type = $_GET['s_type'];
		
			}
?>

	 <form  method="GET"  action="<?php echo esc_url( home_url( '/search-book/')); ?>">
     <input type="text" value="" name="s_key" id="s" placeholder="Search" />
     <input type="submit" id="searchsubmit" value="" />
     
     <?php  if (current_user_can('administrator') || current_user_can('admin')) {  ?>
     
<div style="float:left; margin-left:-80px; border-radius:3px; margin-top:-36px;">			
 <select name="s_type" style="height:37px; width:80px;">
        <option  value="Book_Name"<?php if($s_type == "Book_name" ){ ?> selected="selected" <?php }
    else if($s_type != "Author_Name" && $s_type != "price" && $s_type != "year"){?> selected="selected" <?php } ?>>Book</option>
        <option   value="Author_Name" <?php if($s_type == "Author_Name" ){?>selected="selected" <?php } ?>>Author </option>
        <option  value="topic" <?php if($s_type == "topic" ){?>selected="selected" <?php } ?>>Topic</option>
        <option value="Publisher_Name" <?php if($s_type == "Publisher_Name" ){?>selected="selected" <?php } ?>>Publisher</option>
        <option  value="price" <?php if($s_type == "price" ){?>selected="selected" <?php } ?>>Price</option>
        <option value="year" <?php if($s_type == "year" ){?>selected="selected" <?php } ?>>Year</option>
</select>
</div>
        
<?php  }else{ ?>

<input type="radio" name="s_type" value="Book_Name"<?php if($s_type == "Book_name" ){ ?> checked="checked" <?php }
        else if($s_type != "Author_Name" && $s_type != "price" && $s_type != "year"){?> checked="checked" <?php } ?>>Book
     <input type="radio" name="s_type" value="Author_Name" <?php if($s_type == "Author_Name" ){?>checked="checked" <?php } ?>>Author
      <?php // if (current_user_can('administrator') || current_user_can('admin')) {  ?>
	<!-- <input type="radio" name="s_type" value="topic" <?php //if($s_type == "topic" ){?>checked="checked" <?php// } ?>>Topic
     <input type="radio" name="s_type" value="Publisher_Name" <?php //if($s_type == "Publisher_Name" ){?>checked="checked" <?php //} ?>>Publisher-->
        <?php  //} ?>
     <input type="radio" name="s_type" value="price" <?php if($s_type == "price" ){?>checked="checked" <?php } ?>>Price
      <input type="radio" name="s_type" value="year" <?php if($s_type == "year" ){?>checked="checked" <?php } ?>>Year
      
      <?php  } ?>

		</form>

<?php	
			//echo apply_filters( 'get_product_search_form', $form );
 
    echo $after_widget;
  }
 
}

add_action( 'widgets_init', create_function('', 'return register_widget("Search_Widget");') );
?>
