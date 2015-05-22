<?php

namespace Kunstmaan\TranslatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TranslationAdminType extends AbstractType
{
    /**
     * @var string
     */
    private $intention;

    /**
     * @param string $intention
     *
     * @return TranslationAdminType
     */
    public function setIntention($intention = 'add')
    {
        $this->intention = $intention;

        return $this;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = array();
        if ($this->intention == 'edit') {
            $options = array('read_only' => true);
        }

        $builder->add('domain', 'text', $options);
        $builder->add('keyword', 'text', $options);
        $builder->add('texts', 'collection', array(
            'type' => new TextWithLocaleAdminType(),
            'label' => 'translator.translations',
            'by_reference' => false,
            'required' => false,
            'attr' => array(
                'nested_form' => true,
            )
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'translation';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\Kunstmaan\TranslatorBundle\Model\Translation',
            'cascade_validation' => true,
        ));
    }
}
