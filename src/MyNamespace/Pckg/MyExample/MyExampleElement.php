<?php

namespace MyNamespace\Pckg\MyExample;

use Convo\Core\Params\IServiceParamsScope;
use Convo\Core\Util\ArrayUtil;
use Convo\Core\Workflow\IConversationElement;

class MyExampleElement extends \Convo\Core\Workflow\AbstractWorkflowContainerComponent implements \Convo\Core\Workflow\IConversationElement
{
	/**
	 * @var string
	 */
	private $_direction;

	/**
	 * @var string
	 */
	private $_statusVar;

	/**
	 * @var array
	 */
	private $_directionOptions;

	/**
	 * @var IConversationElement[]
	 */
	private $_goFlow = array();

	/**
	 * @var IConversationElement[]
	 */
	private $_canNotGoFlow = array();

	public function __construct( $properties)
	{
		parent::__construct( $properties);

		$this->_direction = $properties['direction'];
		$this->_statusVar = $properties['status_var'];
		$this->_directionOptions = $properties['direction_options'];

		foreach ( $properties['go'] as $element) {
			$this->_goFlow[] = $element;
			$this->addChild($element);
		}

		foreach ( $properties['can_not_go'] as $element) {
			$this->_canNotGoFlow[] = $element;
			$this->addChild($element);
		}
	}

	/**
	 * @param \Convo\Core\Workflow\IConvoRequest $request
	 * @param \Convo\Core\Workflow\IConvoResponse $response
	 */
	public function read(\Convo\Core\Workflow\IConvoRequest $request, \Convo\Core\Workflow\IConvoResponse $response)
	{
		$direction = $this->evaluateString($this->_direction);
		$statusVar = $this->evaluateString($this->_statusVar);
		$directionOptions = $this->_evaluateArgs( $this->_directionOptions);
		$directionOptionsValues = array_values($directionOptions);

		$params = $this->getService()->getComponentParams( IServiceParamsScope::SCOPE_TYPE_SESSION, $this);
		$index = $params->getServiceParam($statusVar)['current_index'] ?? 0;
		$current_direction_options = $params->getServiceParam($statusVar)['current_direction_options'] ?? $directionOptionsValues[$index];

		if ($params->getServiceParam($statusVar)['has_started'] && in_array(strtolower($direction), $current_direction_options)) {
			if (strtolower($direction) === 'forward') {
				$index++;
				if ($index >= count($directionOptionsValues)) {
					$index = count($directionOptionsValues) - 1;
				}
			} else if (strtolower($direction) === 'backward') {
				$index--;
				if ($index < 0) {
					$index = 0;
				}
			}
		}

		$params->setServiceParam($statusVar, [
			'has_started' => true,
			'direction_options' => $directionOptionsValues,
			'current_direction_options' => $directionOptionsValues[$index],
			'current_index' => $index,
			'last' => $index === count($directionOptionsValues) - 1
		]);

		if (in_array(strtolower($direction), $current_direction_options)) {
			$selected_flow = $this->_goFlow;
		} else {
			$selected_flow = $this->_canNotGoFlow;
		}

		foreach ($selected_flow as $element) {
			$element->read($request, $response);
		}
	}

	private function _evaluateArgs($args)
	{
		// $this->_logger->debug( 'Got raw args ['.print_r( $args, true).']');
		$returnedArgs = [];
		foreach ($args as $key => $val)
		{
			$key	=	$this->evaluateString($key);
			$parsed =   $this->evaluateString($val);

			if (!ArrayUtil::isComplexKey($key))
			{
				$returnedArgs[$key] = $parsed;
			}
			else
			{
				$root = ArrayUtil::getRootOfKey($key);
				$final = ArrayUtil::setDeepObject($key, $parsed, $returnedArgs[$root] ?? []);
				$returnedArgs[$root] = $final;
			}
		}
		// $this->_logger->debug( 'Got evaluated args ['.print_r( $returnedArgs, true).']');
		return $returnedArgs;
	}
}