<?php
/**
 * Custom customizer control class for multiple select dropdown taxonomies.
 */

if( ! class_exists( 'Magazine_Pro_Multiple_Select_Dropdown_Taxonomies' ) ) {

  class Magazine_Pro_Multiple_Select_Dropdown_Taxonomies extends WP_Customize_Control {

    public $type = 'multiple-select-dropdown-taxonomies';

    public $placeholder = '';

    public function __construct($manager, $id, $args = array()) {
      
      parent::__construct( $manager, $id, $args );
    }

    public function render_content() {
      if ( empty( $this->choices ) ) {
        return;
      }       
      ?>
      <label>
        <span class="customize-control-title">
          <?php echo esc_html( $this->label ); ?>
        </span>
        <?php if($this->description) { ?>
          <span class="description customize-control-description">
          <?php echo wp_kses_post($this->description); ?>
          </span>
        <?php } ?>
        <select multiple="multiple" class="hs-chosen-select" <?php $this->link(); ?>>
          <?php
          foreach ( $this->choices as $value => $label ) {
            $selected = '';
            if(in_array($value, $this->value())){
                $selected = 'selected="selected"';
            }
            echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html($label) . '</option>';
          }
          ?>
        </select>
      </label>
      <?php
    }
  }
}