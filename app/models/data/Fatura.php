<?php
namespace Dados;

class Fatura {
    
    private $id;
    private $dataAbertura;
    private $dataFechamento;
    private $dataPagamento;
    
    public function __construct(int $id, $dataAbertura=null, $dataFechamento=null, $dataPagamento=null) {
        $this->id = $id;
        $this->dataAbertura = $dataAbertura;
        $this->dataFechamento = $dataFechamento;
        $this->dataPagamento = $dataPagamento;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getDataAbertura() {
        return $this->dataAbertura;
    }

    public function setDataAbertura($dataAbertura) {
        $this->dataAbertura = $dataAbertura;
    }

    public function getDataFechamento() {
        return $this->dataFechamento;
    }

    public function setDataFechamento($dataFechamento) {
        $this->dataFechamento = $dataFechamento;
    }

    public function getDataPagamento() {
        return $this->dataPagamento;
    }

    public function setDataPagamento($dataPagamento) {
        $this->dataPagamento = $dataPagamento;
    }
}