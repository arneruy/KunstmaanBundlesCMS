<?php

namespace Kunstmaan\NodeSearchBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\Tab;
use Kunstmaan\NodeBundle\Event\AdaptFormEvent;

use Kunstmaan\NodeSearchBundle\Form\NodeSearchAdminType;
use Kunstmaan\NodeSearchBundle\Helper\FormWidgets\SearchFormWidget;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * NodeListener
 */
class NodeListener
{
    /** @var EntityManager $em */
    private $em;

    /** @var ContainerInterface $container */
    private $container;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @param AdaptFormEvent $event
     */
    public function adaptForm(AdaptFormEvent $event)
    {
        $searchWidget = new SearchFormWidget($event->getNode(), $this->em);
        $searchWidget->addType('node_search', $this->container->get('form.type.node_search'));

        $tabPane = $event->getTabPane();
        $tabPane->addTab(new Tab('Searcher', $searchWidget));
    }
}
