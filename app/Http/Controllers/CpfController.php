<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpfController extends Controller
{
    public function salvar(Request $request)
{
    // Validação do CPF
    $request->validate([
        'cpf' => 'required|string',
    ]);

    // Pega o CPF do request
    $cpfNumerico = preg_replace('/[^0-9]/', '', $request->cpf);
    
    // Formata o CPF com pontuação
    $cpfFormatado = substr($cpfNumerico, 0, 3) . '.' . 
                   substr($cpfNumerico, 3, 3) . '.' . 
                   substr($cpfNumerico, 6, 3) . '-' . 
                   substr($cpfNumerico, 9, 2);
    
    $user = Auth::user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Usuário não autenticado'], 401);
    }

    // Consultar o nome por CPF
    $nome = $this->consultarNomePorCpf($cpfNumerico);

    // Atualizar o CPF com formato de pontuação e o nome (se disponível) do usuário
    $user->cpf = $cpfFormatado;
    
    if ($nome) {
        $user->name = $nome;
    }

    if ($user->save()) {
        $response = ['success' => true, 'message' => 'CPF salvo com sucesso'];
        if ($nome) {
            $response['nome'] = $nome;
        }
        return response()->json($response);
    } else {
        return response()->json(['success' => false, 'message' => 'Erro ao salvar CPF'], 500);
    }
}
    private function consultarNomePorCpf($cpf)
    {
        try {
            // Realizando a consulta para a API da Receita Federal
            $token = '268753a9b3a24819ae0f02159dee6724'; 
            $url = "https://api.exato.digital/receita-federal/cpf?token={$token}&cpf={$cpf}&format=json";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            // Verificando se o nome está presente na resposta
            if (isset($data['Result']['NomePessoaFisica'])) {
                return $data['Result']['NomePessoaFisica'];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}