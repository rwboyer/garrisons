<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_brand-fields',
		'title' => 'Brand Fields',
		'fields' => array (
			array (
				'key' => 'field_5777ecfd00d11',
				'label' => 'Brand Link',
				'name' => 'brand_link',
				'type' => 'text',
				'instructions' => 'Link to brand page',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post_type_brand',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

?>
