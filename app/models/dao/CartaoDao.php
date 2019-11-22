<?php

namespace Dao;

use Dao\Dao;
use Dados\Cartao;
use DateTime;
use PDOException;

final class CartaoDao extends Dao
{

    public function insert($obj)
    {
        throw new Exception("Não precisa implementar");
    }
    public function read(int $idObj)
    {
        throw new Exception("Não precisa implementar");
    }
    public function readAll()
    {
        throw new Exception("Não precisa implementar");
    }
    public function update($obj)
    {
        throw new Exception("Não precisa implementar");
    }
    public function delete(int $idObj)
    {
        throw new Exception("Não precisa implementar");
    }

    public function readByDetails(string $number, string $clientNameInCard, int $securyCode)
    {
        $result = null;
        $str = str_replace("_", " ", $clientNameInCard);
        try {
            $sql = "SELECT * FROM tb_cartao WHERE numero = :numero AND nome_cliente = :nome_cliente AND cod_seguranca = :cod_seguranca";
            $req = $this->pdo->prepare($sql);
            $req->bindValue(":numero", $number);
            $req->bindValue(":nome_cliente", $str);
            $req->bindValue(":cod_seguranca", $securyCode);
            $req->execute();
            if ($req->rowCount() != 0) {
                $result = $req->fetch();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $result;
    }
    public function buy(array $data)
    {
        try {
            $sql1 = "SELECT * FROM tb_cartao WHERE numero = :numero AND nome_cliente = :nome_cliente AND cod_seguranca = :cod_seguranca";
            $req1 = $this->pdo->prepare($sql1);
            $str = str_replace("_", " ", $data['nome_cliente']);
            $req1->bindValue(":numero", $data['numero_cartao']);
            $req1->bindValue(":nome_cliente", $str);
            $req1->bindValue(":cod_seguranca", $data['cod_seguranca']);
            $req1->execute();

            if ($req1->rowCount() > 0) {
                $result = $req1->fetch();
                $sql2 = "INSERT INTO `tb_compra` ( `tb_cartao_id`, `data`, `valor_em_centavos`) VALUES ( ?, now(), ?)";
                $req = $this->pdo->prepare($sql2);
                $req->bindValue(1, $result['id']);
                $req->bindValue(2, $data['valor_em_centavos']);
                $req->execute();
                $last_id = $this->pdo->lastInsertId();
                $parcelas = 1;
                $m = 0;

                while ($parcelas <= $data['parcelas']) {

                    $date2 = new DateTime('now');
                    $date = new DateTime('now');
                    $date->add(new \DateInterval("P" . $parcelas . "M"));
                    $date2->add(new \DateInterval("P" . ($parcelas + 1) . "M"));






                    $dt_final = $date2->format('Y-m-d');
                    //SELECIONAR FATURAS ABERTAS DO CLIENTE NA DATA ENTRE AS PARCELAS
                    $sql_select_fat = "SELECT tf.id as fatura_id, tp.id as parcela_id, tp.valor_em_centavos as valor_parcela FROM tb_cartao as tc JOIN tb_fatura tf ON tf.tb_cartao_id = tc.id JOIN tb_parcela tp ON tp.tb_fatura_id = tf.id JOIN tb_compra tbc ON tp.tb_compra_id = tbc.id WHERE tc.numero like ? AND tf.data_inicial = ?";
                    $stm_select_fat = $this->pdo->prepare($sql_select_fat);
                    $stm_select_fat->bindValue(1, $data['numero_cartao']);
                    $stm_select_fat->bindValue(2, $date->format('Y-m-d'));
                    $stm_select_fat->execute();

                    //SE HA FATURAS ABERTAS, ATUALIZAR AS PARCELAS EXISTENTES PARA AS FATURAS.
                    if ($stm_select_fat->rowCount() > 0) {


                        $fat_exists = $stm_select_fat->fetch();
                        

                            $sql_updt_parc = "UPDATE tb_parcela SET valor_em_centavos = ? WHERE tb_fatura_id = ?";
                            $stm_upd_parc = $this->pdo->prepare($sql_updt_parc);
                            $stm_upd_parc->bindValue(1, (($data['valor_em_centavos'] / $data['parcelas']) + $fat_exists['valor_parcela']));
                            echo " Atualizando fatura [". $fat_exists['fatura_id']."] com valor [".(($data['valor_em_centavos'] / $data['parcelas']) + $fat_exists['valor_parcela']);
                            $stm_upd_parc->bindValue(2, $fat_exists['fatura_id']);
                            $stm_upd_parc->execute();
                        


                        $parcelas++;
                    } else {
                        
                        $sql3 = "INSERT INTO `tb_fatura` (`tb_cartao_id`, `data_inicial`,`data_final`, `data_pagamento`) VALUES (?, ?, ?, NULL);";
                        $req2 = $this->pdo->prepare($sql3);
                        $req2->bindValue(1, $result['id']);






                        $req2->bindValue(2, $date->format('Y-m-d'));

                        $req2->bindValue(3, $dt_final);

                        $req2->execute();
                        $last_ids = $this->pdo->lastInsertId();


                        $sql_final = "INSERT INTO `tb_parcela` (`tb_compra_id`, `tb_fatura_id`, `valor_em_centavos`) VALUES ( ?, ?, ?);";
                        $req_final = $this->pdo->prepare($sql_final);
                        $req_final->bindValue(1, $last_id);
                        $req_final->bindValue(2, $last_ids);
                        $valor = $data['valor_em_centavos'] / $data['parcelas'];
                        $req_final->bindValue(3, $valor);
                        $req_final->execute();
                        $parcelas++;
                    }









                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function readAvailableLimit(string $number, string $clientNameInCard, int $securyCode)
    {
        $result = null;

        try {
            $sql = "SELECT nome_cliente, (limite_em_centavos - sum(valor_parcela_em_centavos)) as limite_disponivel_em_centavos 
            FROM vw_faturas_abertas_do_banco 
            WHERE numero = :numero AND valor_compra_em_centavos IS NOT NULL AND nome_cliente = :nome_cliente 
            AND cod_seguranca = :cod_seguranca 
            GROUP BY nome_cliente;";

            $req = $this->pdo->prepare($sql);
            $req->bindValue(":numero", $number);
            $req->bindValue(":nome_cliente", $clientNameInCard);
            $req->bindValue(":cod_seguranca", $securyCode);
            $req->execute();

            if ($req->rowCount() == 1) {
                $result = $req->fetchAll(\PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $result;
    }
}
