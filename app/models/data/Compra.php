<?php
namespace Dados;

class Compra {

    private $id;
    private $idCartao;
    private $data;
    private $valorEmCentavos;

    public function __construct(int $id, int $idCartao=null, $data=null, int $valorEmCentavos=null) {
        $this->$id = $id;
        $this->$idCartao = $idCartao;
        $this->$data = $data;
        $this->$valorEmCentavos = $valorEmCentavos;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getIdCartao(): int {
        return $this->idCartao;
    }

    public function setIdCartao(int $idCartao) {
        $this->idCartao = $idCartao;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getValorEmCentavos(): int {
        return $this->valorEmCentavos;
    }

    public function setValorEmCentavos(int $valorEmCentavos) {
        $this->valorEmCentavos = $valorEmCentavos;
    }
}