<?php

namespace App\Http\Controllers;

ini_set('max_execution_time','-1');
require_once "SimpleXLSX.php";

use Response;
use App\Models\Transportadora;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSX;

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
                
                $arrayCusto = [
                    "from_postcode" => trim($cep[0]),
                    "to_postcode" => trim($cep[1]),
                    "from_weight" => $this->moeda(trim($peso[0])),
                    "to_weight" => $this->moeda(trim($peso[2])),
                    "cost" => $this->moeda(trim($valor[4]))
                ];
            endif;
            dd($arrayCusto);
        endforeach;

        DB::table('table')->insert($arrayCusto);
    }

    public static function moeda($get_valor) {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); 
        return $valor; 
    }
}
