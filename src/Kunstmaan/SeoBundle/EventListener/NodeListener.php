<?php

namespace Kunstmaan\SeoBundle\EventListener;

use Doctrine\ORM\EntityManager;

use Kunstmaan\SeoBundle\Entity\Seo,
    Kunstmaan\SeoBundle\Form\SeoType,
    Kunstmaan\SeoBundle\Form\SocialType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kunstmaan\AdminBundle\Helper\FormWidgets\FormWidget;
use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\Tab;
use Kunstmaan\NodeBundle\Event\AdaptFormEvent;
use Kunstmaan\NodeBundle\Entity\HasNodeInterface;



/**
 * This will add a seo tab on each page
 */
class NodeListener
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param EntityManager      $em
     * @param ContainerInterface $container
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
    	if($event->getPage() instanceof HasNodeInterface) {
    		/* @var Seo $seo */
    		$seo = $this->em->getRepository('KunstmaanSeoBundle:Seo')->findOrCreateFor($event->getPage());
    		
    		$seoWidget = new FormWidget();
    		$seoWidget->addType('seo', $this->container->get('form.type.seo'), $seo);
    		$event->getTabPane()->addTab(new Tab('SEO', $seoWidget));
    		
    		$socialWidget = new FormWidget();
    		$socialWidget->addType('social', $this->container->get('form.type.social'), $seo);
    		$event->getTabPane()->addTab(new Tab('Social', $socialWidget));
    	}
    }

}
