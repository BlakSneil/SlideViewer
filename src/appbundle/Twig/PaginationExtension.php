<?php
namespace AppBundle\Twig;

class PaginationExtension extends \Twig_Extension
{
    private $environment;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bs_header',  array($this, 'header'), array('is_safe' => array('html')))
            );
    }

    /**
     * {@inheritDoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function header($pagination, $title, $key, $options = array(), $params = array(), $template = null)
    {
        return $this->environment->render(
            'AppBundle:Pagination:table_header.html.twig',
            array('pagination' => $pagination,
                'title' => $title,
                'key' => $key,
                'options' => $options,
                'params' => $params)
        );
    }

    public function getName()
    {
        return 'paginator_extension';
    }
}