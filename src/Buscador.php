<?php

namespace Rober\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
     private $httpClient;
     private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
         //Fazendo requisição a pagina
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $crawler = new Crawler();
        $this->crawler->addHtmlContent($html);

        $resultadoCursos = $this->crawler->filter('span.card-curso__nome');

        $cursos = array();
        foreach ($resultadoCursos as $curso) {
            $cursos[] = $curso->textContent;
        }

        return $cursos;
    }
}
