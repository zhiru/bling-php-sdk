<?php

namespace Bling\Repositories;

use Spatie\ArrayToXml\ArrayToXml;

class CategorieRepository extends BaseRepository
{
    public function all(array $filters = [], int $page = 0): ?array
    {
        $options = [];

        foreach ($filters as $k => $v) {
            $filters[$k] = $k.'['.$v.']';
        }

        if(count($filters)) {
            $options['filters'] = implode('; ', $filters);
        }

        if($page > 0){            
            return $this->client->get('categorias/page='.$page.'/json/', $options);
        }
        
        return $this->client->get('categorias/json/', $options);
    }

    public function find(int $numero): ?array
    {
        return $this->client->get("categoria/$numero/json/");
    }

    public function create(array $params): ?array
    {
        $options = [];

        $rootElement = array_key_first($params);

        $xml = ArrayToXml::convert($params[$rootElement], $rootElement);

        $options['xml'] = $xml;

        return $this->client->post('categoria/json/', $options);
    }

    public function send(int $numero, int $categorias, $categoria, $descricao, $idCategoriaPai = false): ?array
    {
        $options = [];

        $options['categorias'] = $categorias;
        $options['categoria'] = $categoria;
        $options['descricao'] = $descricao;
        $options['idCategoriaPai'] = $idCategoriaPai;

        return $this->client->post("categoria/$numero/json/", $options);
    }
}
