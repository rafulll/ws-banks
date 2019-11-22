<?php
namespace Dados;

class Cliente implements \JsonSerializable {

    private $id;
    private $nome;

    public function __construct(int $id, string $nome=null) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome) {
        $this->nome = $nome;
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