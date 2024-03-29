<?php

namespace Controllers\V1;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Controllers\V1\CoreController;
use Dao\ClienteDao;
use Dao\CartaoDao;

final class BankController extends CoreController
{

    /**
     * @api {GET} /status Status da API
     * 
     * @apiVersion 1.0.0
     * 
     * @apiDescription Verifica a disponibilidade da API
     * 
     * @apiGroup Recursos Abertos
     * 
     * @apiSuccess (200) {String} status Resultado da disponibilidade do servidor.
     * 
     * @apiSuccessExample {JSON} Success-Response:
     *  {
     *      "status": "Serviço disponível WS3"
     *  }
     */

    public static function getStatus(Request $req, Response $res, array $args)
    {
        $dados = [
            "status" => "Serviço disponível WS3"
        ];

        return $res->withStatus(200)->withJson($dados);
    }
    private function verify($data)
    {
        //var_dump($data);
        if (!$data) {
            return false;
        } else {
       
            $verify_client = new CartaoDao();
       



            $client_result = $verify_client->readAvailableLimIt($data['numero_cartao'], $data['nome_cliente'], $data['cod_seguranca']);
            //var_dump($client_result);
            if($client_result[0]['limite_disponivel_em_centavos'] == null){
                $valor_disp = $data['valor_em_centavos'];
            }else{
                $valor_disp = intval($client_result[0]['limite_disponivel_em_centavos']);

            }
            
           
            $parcela = $data['valor_em_centavos'] / $data['parcelas'];
           // var_dump($parcela);
            if ($parcela <= $valor_disp) {
                //var_dump($data['nome_cliente']);
                $cliente_buy = $verify_client->readByDetails($data['numero_cartao'],   $data['nome_cliente'], $data['cod_seguranca']);
                if(!$cliente_buy){
                    return false;
                }
                $verify_client->buy($data);
                return true;
            } else {

                return false;
            }
            
        }
        return true;
    }
    public static function payC(Request $rq, Response $rs, array $args)
    {
        $dados = $rq->getParsedBody();
        $verif = self::verify($dados);
        //var_dump($verif);
        if ($verif != true) {
            $dados = [
                "resultado" => "Falha",
                "detalhes" => "Dados incorretos OU LIMITE INDISPONIVEL. Verifique os dados ou entre em contato com a operadora do cartão."

            ];
            return $rs->withStatus(401)->withJson($dados);
        } else {
            $dados = ["resultado" => "Sucesso", "detalhes" => "Compra efetuada com sucesso."];
        }
        return $rs->withStatus(200)->withJson($dados);

    }
}
