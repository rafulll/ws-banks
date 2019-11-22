<?php
namespace Dados;

class Parcela {

    private $id;
    private $idCompra;
    private $idFatura;
    private $valorEmCentavos;

    public function __construct(int $id, int $idCompra=null, int $idFatura=null, int $valorEmCentavos=null) {
        $this->$id = $id;
        $this->$idCompra = $idCompra;
        $this->$idFatura = $idFatura;
        $this->$valorEmCentavos = $valorEmCentavos;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getIdCompra(): int {
        return $this->idCompra;
    }

    public function setIdCompra(int $idCompra) {
        $this->idCompra = $idCompra;
    }

    public function getIdFatura(): int {
        return $this->idFatura;
    }

    public function setIdFatura(int $idFatura) {
        $this->idFatura = $idFatura;
    }

    public function getValorEmCentavos(): int {
        return $this->valorEmCentavos;
    }

    public function setValorEmCentavos(int $valorEmCentavos) {
        $this->valorEmCentavos = $valorEmCentavos;
    }
}