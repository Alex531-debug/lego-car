<?php


namespace App\Service;


use JsonCollectionParser\Parser;

class ImportCar
{
    private $createCar;
    /**
     * Количество строк передаваемых в пакете на загрузку
     * @var int
     */
    private $countChunk = 20;

    public function __construct(CarService $createCar)
    {
        $this->createCar = $createCar;
        $this->createCar->setClearEntityManager(true);
    }

    public function import(string $filename)
    {
        $parser = new Parser();
        $parser->chunk($filename, [$this->createCar, 'createChunk'], $this->countChunk);
    }
    /**
     * @param int $countChunk
     */
    public function setCountChunk(int $countChunk): void
    {
        $this->countChunk = $countChunk;
    }
}