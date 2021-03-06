<?php
/**
 * OrderAddressFixture
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
class OrderAddressFixture extends CakeTestFixture {

/**
 * Name
 *
 * @var string $name
 */
	public $name = 'OrderAddress';

/**
 * Table
 *
 * @var array $table
 */
	public $table = 'order_addresses';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'order_addresses' => array(
			'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
			'order_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
			'user_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
			'first_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'last_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'company' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'street' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'street2' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'city' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'zip' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 128),
			'country' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 2),
			'type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 2, 'comment' => 'billing or shipping'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array(
				'PRIMARY' => array('column' => 'id', 'unique' => 1),
				'USER_INDEX' => array('column' => 'user_id'),
				'ORDER_INDEX' => array('column' => 'order_id'))
	));

/**
 * Records
 *
 * @var array
 */
	public $records = array(
	);

}
