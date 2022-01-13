<?php declare(strict_types=1);

namespace MyNamespace\Pckg\MyExample;

use Convo\Core\Factory\AbstractPackageDefinition;
use Convo\Core\Intent\EntityModel;
use Convo\Core\Intent\SystemEntity;
use Convoworks\Symfony\Component\ExpressionLanguage\ExpressionFunction;

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
		$entities['EntityName'] = new SystemEntity('EntityName');
		$entity_name_model = new EntityModel('EntityName', false);
		$entity_name_model->load([
			"name" => "EntityName",
			"values" => [
				[
					"value" => "Entity 1",
				]
			]
		]);
		$entities['EntityName']->setPlatformModel('amazon', $entity_name_model);
		$entities['EntityName']->setPlatformModel('dialogflow', $entity_name_model);

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
				array(
					'_preview_angular' => array(
						'type' => 'html',
						'template' => '<div class="code">' .
							'<span class="statement">My Example Element </span>' .
							'</div>'
					),
					'_interface' => '\Convo\Core\Workflow\IServiceContext',
					'_workflow' => 'read',
					'_help' =>  array(
						'type' => 'file',
						'filename' => 'my-example-element.html'
					),
				)
			)
		);
	}
}
