<?php

namespace App\Http\Controllers;

ini_set('max_execution_time','-1');
require_once "SimpleXLSX.php";

use Response;
use App\Models\Transportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportadoraController extends Controller
{
    public function store(Request $request) 
    {
		if($request->file('planilha')->isValid()):
            $path = $request->planilha->store('planilhas');

		else:
            return response()->json(['success' => 'Arquivo não encontrado!']);
			exit();
		endif;
 
		$this->inserirDados($path);
	}

    public function inserirDados($path)
    {
        $dados = file(storage_path('app')."/".$path);
        $arrayCusto = [];
        foreach($dados as $chave => $linha):
            if ($chave >= 1):
                $valor = explode(',', $linha);
                $cep = explode(';', $valor[0]);
                $peso = explode(';', $valor[1]);
                
                $arrayCusto[] = [
                    "from_postcode" => trim($cep[0]),
                    "to_postcode" => trim($cep[1]),
                    "from_weight" => $this->moeda(trim($peso[0])),
                    "to_weight" => $this->moeda(trim($peso[1])),
                    "cost" => $this->moeda(trim($valor[3])),
                    "created_at" => date("Y-m-d H:i:s"),
                ];
            endif;            
        endforeach;

        DB::table('shipping_cost')->truncate();
        DB::table('shipping_cost')->insert($arrayCusto);
        return response()->json(['success' => 'Dados salvos com Sucesso!']);
    }

    public static function moeda($get_valor) {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); 
        return $valor; 
    }
}
