<?php
App::uses('Object', 'Core');
App::uses('CakeResponse', 'Network');
App::uses('PaymentProcessorException', 'Cart.Error');
App::uses('PaymentApiException', 'Cart.Error');
App::uses('ClassRegistry', 'Utility');
App::uses('CakeSession', 'Model/Datasource');

/**
 * BasePaymentProcessor
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
abstract class BasePaymentProcessor extends Object {
/**
 * CakeRequest object instance
 * 
 * @var CakeRequest
 */
	protected $_request;

/**
 * CakeResponse object instance
 * 
 * @var CakeResponse
 */
	protected $_response;

/**
 * Constructor
 *
 * @return void
 */
	public function __construct($options = array()) {
		if (!empty($options['request'])) {
			$this->_request = $options['request'];
		} else {
			$this->_request = new CakeRequest();
		}
		if (!empty($options['response'])) {
			$this->_response = $options['response'];
		} else {
			$this->_response = new CakeResponse();
		}
		if (!isset($options['cartModel'])) {
			$options['cartModel'] = 'Cart.Cart';
		}
		$this->CartModel = ClassRegistry::init($options['cartModel']);
		$this->OrderModel = ClassRegistry::init('Cart.Order');
	}

/**
 * Callback Url
 * 
 * @var mixed array or string url, parseable by the Router
 */
	public $callbackUrl = array('admin' => false, 'plugin' => 'cart', 'controller' => 'carts', 'action' => 'callback');

/**
 * Return Url
 *
 * @var mixed array or string url, parseable by the Router
 */
	public $returnUrl = array('admin' => false, 'plugin' => 'cart', 'controller' => 'carts', 'action' => 'confirm_order');

/**
 * Cancel Url
 *
 * @var mixed array or string url, parseable by the Router
 */
	public $cancelUrl = array('admin' => false, 'plugin' => 'cart', 'controller' => 'carts', 'action' => 'cancel_order');

/**
 * Redirect
 *
 * @param string url to redirect to
 * @param integer Http status code
 */
	public function redirect($url, $status = null) {
		if (is_array($status)) {
			extract($status, EXTR_OVERWRITE);
		}

		if (!empty($status) && is_string($status)) {
			$codes = array_flip($this->_response->httpCodes());
			if (isset($codes[$status])) {
				$status = $codes[$status];
			}
		}

		$this->_response->header('Location', Router::url($url));

		if (!empty($status) && ($status >= 300 && $status < 400)) {
			$this->_response->statusCode($status);
		}

		$this->_response->send();
		exit;
	}

/**
 * 
 */
	public function checkout() {
		return;
	}

/**
 *
 */
	public function callback() {
		return;
	}

/**
 * Log
 *
 * @param string $message
 * @param string $type
 */
	public function log($message, $type = null) {
		if (empty($type)) {
			$type = Inflector::underscore(__CLASS__);
		}
		parent::log($message, $type);
	}

}