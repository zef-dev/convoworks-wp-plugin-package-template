<?php

namespace MyNamespace\Pckg\MyExample;

class MyExampleElement extends \Convo\Core\Workflow\AbstractWorkflowComponent implements \Convo\Core\Workflow\IConversationElement
{
	public function __construct( $properties)
	{
		parent::__construct( $properties);
	}

	/**
	 * @param \Convo\Core\Workflow\IConvoRequest $request
	 * @param \Convo\Core\Workflow\IConvoResponse $response
	 */
	public function read(\Convo\Core\Workflow\IConvoRequest $request, \Convo\Core\Workflow\IConvoResponse $response)
	{
		// TODO: Implement read() method.
	}
}