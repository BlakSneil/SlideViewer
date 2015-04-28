<?php
namespace AppBundle\Twig;

class PaginationExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('bs_header', 'sortable'),
        );
    }

    public function sortable($pagination, $title, $key, $options = array(), $params = array(), $template = null)
    {
        return $this->environment->render(
            'AppBundle:Pagination:table_header.html.twig',
            array_merge($pagination, $title, $key, $options, $params)
        );
    }

    public function getName()
    {
        return 'paginator_extension';
    }
}