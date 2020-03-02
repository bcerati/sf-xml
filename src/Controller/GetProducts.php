<?php
namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetProducts
 *
 * @package App\Controller
 */
class GetProducts extends AbstractController
{
    /**
     * @Route(path="/api/products")
     */
    public function __invoke(ProductManager $productManager, SerializerInterface $serializer)
    {
        $data = $productManager->findAll();
        $data = array_map(function (Product $d) {
            return $d->toArray();
        }, $data);

        $xml = $serializer->serialize($data, 'xml', [
            'groups' => 'products',
            'xml_root_node_name' => 'products'
        ]);

        return new Response($xml, 200, [
            'Content-Type' => 'text/xml'
        ]);
    }
}
