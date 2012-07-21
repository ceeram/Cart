<?php
App::uses('CartAppModel', 'Cart.Model');
/**
 * Order Model
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
class Order extends CartAppModel {
/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Search.Searchable');

/**
 * Order status
 *
 * @var array
 */
	public $orderStatuses = array(
		'pending',
		'failed',
		'completed',
		'refunded',
		'partial-refunded');

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cart' => array(
			'className' => 'Cart.Cart'));

/**
 * belongsTo associations
 *
 * @var array
 */
	public $hasOne = array(
		'BillingAddress' => array(
			'className' => 'Cart.OrderAddress',
			'conditions' => array('type' => 'billing')),
		'ShippingAddress' => array(
			'className' => 'Cart.OrderAddress',
			'conditions' => array('type' => 'shipping')));

/**
 * Filters args for search
 *
 * @var array
 */
	public $filterArgs = array(
		array('name' => 'username', 'type' => 'like', 'field' => 'User.username'),
		array('name' => 'email', 'type' => 'like', 'field' => 'User.email'),
		array('name' => 'total', 'type' => 'value'),
		array('name' => 'created', 'type' => 'like'),
	);

/**
 * 
 */
	public function beforeValidate() {
		return true;
	}

/**
 * beforeSave callback
 *
 * @return boolean
 */
	public function beforeSave() {
		if (!empty($this->data[$this->alias]['cart_snapshop'])) {
			$this->data[$this->alias]['cart_snapshop'] = serialize($this->data[$this->alias]['cart_snapshop');
		}
		return true;
	}

/**
 * 
 */
	public function afterSave() {
		if (isset($this->data[$this->alias]['status']) && $this->data[$this->alias]['status'] == 'paid') {
			CakeEventManager::dispatch(new CakeEvent('Order.paid', $this, array($this->data)));
		}
	}

/**
 * afterFind callback
 *
 * @param array $results
 * @return array
 */
	public function afterFind($results) {
		
		return $results;
	}

/**
 * 
 *
 * @param 
 * @param 
 * @return array
 */
	public function view($orderId, $userId = null) {
		$order = $this->find('first', array(
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $orderId,
				$this->alias . '.user_id' => $userId)));

		if (empty($order)) {
			throw new NotFoundException();
		}
		return $order;
	}

/**
 * 
 * @todo finish me
 */
	public function createOrder($cartData, $status = 'pending') {
		$data[$this->alias]['cart_snapshot'] = serialize($data);

		// Shipping and Billing Address validation if the cart requires shipping
		if (isset($cartData['Cart']['requires_shipping']) && $cartData['Cart']['requires_shipping'] == 1) {
			$this->ShippingAddress->set($data);
			$this->ShippingAddress->validates();

			if (isset($cartData['BillingAddress']['same_as_shipping']) && $cartData['BillingAddress']['same_as_shipping'] == 1) {
				$cartData['BillingAddress'] = $cartData['ShippingAddress'];
			} else {
				$this->BillingAddress->set($data);
				$this->BillingAddress->validates();
			}
		}

		$order = array(
			$this->alias => array(
				'cart_id' => $cartData['Cart']['cart_id'],
				'user_id' => $cartData['Cart']['user_id'],
				'cart_snapshop' => serialize($cartData)));

		$this->create();
		$result = $this->save($order);

		if (isset($cartData['Cart']['requires_shipping']) && $cartData['Cart']['requires_shipping'] == 1) {
			$cartData['BillingAddress']['order_id'] = $this->getLastInsertId();
			$cartData['ShippingAddress']['order_id'] = $this->getLastInsertId();
			$this->BillingAddress->create();
			$this->BillingAddress->save($cartData);
			$this->ShippingAddress->create();
			$this->ShippingAddress->save($cartData);
		}

		if ($result) {
			$result[$this->alias][$this->primaryKey] = $this->getLastInsertId();
			CakeEventManager::dispatch(new CakeEvent('Order.newOrder', $this, array($data)));
		}

		return $result;
	}

	public function fireAfterBuyCallback($cartData) {
		foreach ($data['CartsItem'] as $item) {
			CakeEventManager::dispatch(new CakeEvent('Order.afterBuy', $this, array($cartData)));
		}
	}

}