<?php

namespace CategoryBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CategoryBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->prependExtensionConfig(
            'doctrine',
            [
                'orm' => [
                    'mappings' => [
                        'CategoryBundle' => [
                            'type' => 'attribute',
                            'dir' => '%kernel.project_dir%/categoryBundle/src/Domain/Entity',
                            'prefix' => 'CategoryBundle\Domain\Entity',
                            'alias' => 'CategoryBundle'
                        ]
                    ]
                ]
            ]
        );
    }
}