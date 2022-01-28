<?php declare(strict_types=1);

namespace MyNamespace\Pckg\MyExample;

use Convo\Core\Factory\AbstractPackageDefinition;
use Convo\Core\Intent\EntityModel;
use Convo\Core\Intent\SystemEntity;
use Convo\Core\Expression\ExpressionFunction;

class MyExamplePackageDefinition extends AbstractPackageDefinition
{
	const NAMESPACE	=	'my-namespace-my-package';

	public function __construct(
		\Psr\Log\LoggerInterface $logger
	) {
		parent::__construct( $logger, self::NAMESPACE, __DIR__);

		$this->addTemplate( $this->_loadFile( __DIR__ .'/my-example.template.json'));
	}

	protected function _initEntities()
	{
		$entities = [];
		$entities['Direction'] = new SystemEntity('Direction');
		$entity_name_model = new EntityModel('Direction', false);
		$entity_name_model->load([
			"name" => "Direction",
			"values" => [
				[
					"value" => "left",
				],
				[
					"value" => "right",
				],
				[
					"value" => "forward",
				],
				[
					"value" => "backward",
				]
			]
		]);
		$entities['Direction']->setPlatformModel('amazon', $entity_name_model);
		$entities['Direction']->setPlatformModel('dialogflow', $entity_name_model);

		return $entities;
	}

	protected function _initIntents()
	{
		return $this->_loadIntents(__DIR__.'/system-intents.json');
	}

	public function getFunctions()
	{
		$functions = [];

		$functions[] = new ExpressionFunction(
			'my_example_function',
			function ($text) {
				return sprintf('my_example_function(%1$t)', $text);
			},
			function($args, $text) {
				if (is_string($text)) {
					return $text . ' adding example text';
				}
				return 'This is some example text, since you failed to provide an string.';
			}
		);

		return $functions;
	}

	protected function _initDefintions()
	{
		return array (
			new \Convo\Core\Factory\ComponentDefinition(
				$this->getNamespace(),
				'\MyNamespace\Pckg\MyExample\MyExampleElement',
				'My Example Element',
				'Change Me.',
				[
					'direction' => [
						'editor_type' => 'text',
						'editor_properties' => [],
						'defaultValue' => null,
						'name' => 'Direction',
						'description' => 'Direction where to go.',
						'valueType' => 'string'
					],
					'status_var' => array(
						'editor_type' => 'text',
						'editor_properties' => array(),
						'defaultValue' => 'status',
						'name' => 'Status variable',
						'description' => 'Variable name for accessing element status variable information, such as the current index and available directions.',
						'valueType' => 'string'
					),
					'direction_options' => [
						'editor_type' => 'params',
						'editor_properties' => [
							'multiple' => true
						],
						'defaultValue' => array(),
						'name' => 'Direction Options',
						'description' => 'Set of directions where the text game progresses.',
						'valueType' => 'array'
					],
					'go' => [
						'editor_type' => 'service_components',
						'editor_properties' => [
							'allow_interfaces' => ['\Convo\Core\Workflow\IConversationElement'],
							'multiple' => true
						],
						'defaultValue' => [],
						'defaultOpen' => false,
						'name' => 'Going',
						'description' => 'Flow to be executed if can go in certain direction.',
						'valueType' => 'class'
					],
					'can_not_go' => [
						'editor_type' => 'service_components',
						'editor_properties' => [
							'allow_interfaces' => ['\Convo\Core\Workflow\IConversationElement'],
							'multiple' => true
						],
						'defaultValue' => [],
						'defaultOpen' => false,
						'name' => 'Can not go',
						'description' => 'Flow to be executed if can not go in certain direction.',
						'valueType' => 'class'
					],
					'_preview_angular' => [
						'type' => 'html',
						'template' => '<div class="code">Example Element <br>' .
							' <span ng-if="!component.properties[\'_use_var_properties\']" ng-repeat="(key, val) in component.properties.direction_options track by key">' .
							' <b>{{ key}}</b> = <b>{{ val }};</b><br>' .
							' </span>' .
							'<span ng-if="component.properties[\'_use_var_properties\']">{{ component.properties.properties }}</span>' .
							'</div>'
					],
					'_interface' => '\Convo\Core\Workflow\IServiceContext',
					'_workflow' => 'read',
					'_help' =>  [
						'type' => 'file',
						'filename' => 'my-example-element.html'
					],
				]
			)
		);
	}
}
