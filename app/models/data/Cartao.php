<?php
namespace Dados;

class Cartao implements \JsonSerializable {

    private $id;
    private $idCliente;
    private $numero; // ex.: 0000.0000.0000.0000
    private $nomeCliente; // Como está impresso no cartão
    private $bandeira; // nome
    private $codSeguranca;
    private $limiteEmCentavos;
    private $diaFechamentoFatura;

    public function __construct(int $id, int $idCliente=null, string $numero=null, string $nomeCliente=null, string $bandeira=null, int $codSeguranca=null, int $limiteEmCentavos=null, int $diaFechamentoFatura=null) {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->numero = $numero;
        $this->nomeCliente = $nomeCliente;
        $this->bandeira = $bandeira;
        $this->codSeguranca = $codSeguranca;
        $this->limiteEmCentavos = $limiteEmCentavos;
        $this->diaFechamentoFatura = $diaFechamentoFatura;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getIdCliente(): int {
        return $this->idCliente;
    }

    public function setIdCliente(int $idCliente) {
        $this->idCliente = $idCliente;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function setNumero(string $numero) {
        $this->numero = $numero;
    }

    public function getNomeCliente(): string {
        return $this->nomeCliente;
    }

    public function setNomeCliente(string $nomeCliente) {
        $this->nomeCliente = $nomeCliente;
    }

    public function getCodSeguranca(): int {
        return $this->codSeguranca;
    }

    public function setCodSeguranca(int $codSeguranca) {
        $this->codSeguranca = $codSeguranca;
    }

    public function getLimiteEmCentavos(): int {
        return $this->limiteEmCentavos;
    }

    public function setLimiteEmCentavos(int $limiteEmCentavos) {
        $this->limiteEmCentavos = $limiteEmCentavos;
    }

    public function getDiaFechamentoFatura(): int {
        return $this->diaFechamentoFatura;
    }

    public function setDiaFechamentoFatura(int $diaFechamentoFatura) {
        $this->diaFechamentoFatura = $diaFechamentoFatura;
    }

    /**
     * Método sobrescrito da classe JsonSerializable que permite personalizar 
     * como seu objeto deverá ficar quando convertido para um array associativo
     * com a função do PHP json_encode()
     */
    public function jsonSerialize() {
        return get_object_vars($this); // Obtém as propriedades public
    }
}