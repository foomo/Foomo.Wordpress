<?php

namespace Foomo\Wordpress\Admin;

/**
 * $meta_box = array(
 *    'id' => 'my_meta_box',
 *    'title' => 'Custom meta box',
 *    'page' => 'post',
 *    'context' => 'normal',
 *    'priority' => 'high',
 *    'fields' => array(
 *        array(
 *            'name' => 'Text box',
 *            'desc' => 'Enter something here',
 *            'id' => 'my_text',
 *            'type' => 'text',
 *            'std' => 'Default value 1'
 *        ),
 *        array(
 *            'name' => 'Textarea',
 *            'desc' => 'Enter big text here',
 *            'id' => 'my_textarea',
 *            'type' => 'textarea',
 *            'std' => 'Default value 2'
 *        ),
 *        array(
 *            'name' => 'Select box',
 *            'id' => 'my_select',
 *            'type' => 'select',
 *            'options' => array('Option 1', 'Option 2', 'Option 3')
 *        ),
 *        array(
 *            'name' => 'Radio',
 *            'id' => 'my_radio',
 *            'type' => 'radio',
 *            'options' => array(
 *                array('name' => 'Name 1', 'value' => 'Value 1'),
 *                array('name' => 'Name 2', 'value' => 'Value 2')
 *            )
 *        ),
 *        array(
 *            'name' => 'Checkbox',
 *            'id' => 'my_checkbox',
 *            'type' => 'checkbox'
 *        )
 *    )
 * );
 */
class MetaBox 
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	
	/**
	 * @var array
	 */
	private $metaBox;
	/**
	 * @var string
	 */
	private $md5;
	
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------
	
	/**
	 *
	 * @param type $this->metaBox 
	 */
	public function __construct($metaBox)
	{
		$this->metaBox = $metaBox;
		$this->md5 = md5(serialize($this->metaBox));
		
		add_action('admin_menu', array(&$this, '_admin_menu'));
		add_action('save_post', array(&$this, '_save_post'));
	}
	
	
	//---------------------------------------------------------------------------------------------
	// ~ Actions
	//---------------------------------------------------------------------------------------------
	
	/**
	 * @internal
	 */
	public function _admin_menu()
	{
		add_meta_box($this->metaBox['id'], $this->metaBox['title'], array(&$this, '_show_meta_box'), $this->metaBox['page'], $this->metaBox['context'], $this->metaBox['priority']);
	}	
	
	/**
	 * @internal
	 */
	public function _show_meta_box($post)
	{
		// Use nonce for verification
		wp_nonce_field(__CLASS__, \str_replace('-', '_', $this->metaBox['id']) . '_noncename');

		echo '<table class="form-table">';

		foreach ($this->metaBox['fields'] as $field) {
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);

			echo '<tr>',
					'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
					'<td>';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
					break;
				case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $option) {
						echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
					echo '</select>';
					break;
				case 'radio':
					foreach ($field['options'] as $option) {
						echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
					}
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
					break;
			}
			echo     '<td>',
				'</tr>';
		}

		echo '</table>';
	}	
	
	/**
	 * @internal
	 * @param integer $post_id
	 * @return integer 
	 */
	public function _save_post($post_id) 
	{
		// check data
		if (empty($_POST)) return $post_id;
		
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

		// verify nonce
		if (!wp_verify_nonce($_POST[\str_replace('-', '_', $this->metaBox['id']) . '_noncename'], __CLASS__)) return $post_id;

		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		foreach ($this->metaBox['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];

			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}