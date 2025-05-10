<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

class FakeApiController extends Controller
{
    /**
     * Construtor simplificado para API fake
     */
    public function __construct()
    {
        // Não aplicar nenhum middleware para manter a API simples
        // Garantir que as respostas sejam sempre JSON e que a API aceite dados JSON
        $this->middleware(function ($request, $next) {
            // Garante que a API responda com JSON
            $request->headers->set('Accept', 'application/json');
            // Não força mais o Content-Type da requisição para application/json
            // permitindo que o cliente envie dados de formulário (x-www-form-urlencoded)

            return $next($request);
        });
    }
    /**
     * Verifica se um cliente existe pelo número de telefone
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verificarCliente(Request $request): JsonResponse
    {
        // Permitir tanto requisições GET quanto POST para facilitar testes
        if (!in_array($request->method(), ['GET', 'POST'])) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Método não permitido. Esta rota só aceita requisições GET ou POST.',
                'codigo' => 405
            ], 405);
        }

        // Validação do número de telefone
        $request->validate([
            'telefone' => 'required|string|min:10|max:15',
        ]);

        // Obtém o telefone do corpo da requisição JSON ou de parâmetros de formulário
        $telefone = $request->json('telefone') ?? $request->input('telefone');

        // Simulação de verificação - alguns números são considerados cadastrados
        $clienteExiste = in_array($telefone, [
            '11999999999',
            '21988888888',
            '31977777777',
            '41966666666',
        ]);

        if ($clienteExiste) {
            return response()->json([
                'status' => 'success',
                'existe' => true,
                'mensagem' => 'Cliente encontrado no sistema',
                'cliente' => [
                    'id' => rand(1000, 9999),
                    'telefone' => $telefone,
                    'nome' => 'Cliente ' . substr($telefone, -4),
                    'email' => 'cliente' . substr($telefone, -4) . '@exemplo.com',
                    'data_cadastro' => now()->subDays(rand(1, 365))->format('Y-m-d H:i:s'),
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'existe' => false,
            'mensagem' => 'Cliente não encontrado no sistema'
        ]);
    }

    /**
     * Cadastra um novo cliente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cadastrarCliente(Request $request): JsonResponse
    {
        // Permitir tanto requisições GET quanto POST para facilitar testes
        if (!in_array($request->method(), ['GET', 'POST'])) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Método não permitido. Esta rota só aceita requisições GET ou POST.',
                'codigo' => 405
            ], 405);
        }

        // Validação dos dados do cliente
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|min:10|max:15',
            'email' => 'required|email|max:255',
            'cpf' => 'nullable|string|max:14',
            'endereco' => 'nullable|string|max:255',
        ]);

        // Obtém os dados do cliente do corpo da requisição JSON ou de parâmetros de formulário
        $nome = $request->json('nome') ?? $request->input('nome');
        $telefone = $request->json('telefone') ?? $request->input('telefone');
        $email = $request->json('email') ?? $request->input('email');
        $cpf = $request->json('cpf') ?? $request->input('cpf');
        $endereco = $request->json('endereco') ?? $request->input('endereco');

        // Simulação de cadastro bem-sucedido
        return response()->json([
            'status' => 'success',
            'mensagem' => 'Cliente cadastrado com sucesso',
            'cliente' => [
                'id' => rand(1000, 9999),
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'cpf' => $cpf,
                'endereco' => $endereco,
                'data_cadastro' => now()->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    /**
     * Lista todos os clientes (simulado)
     *
     * @return JsonResponse
     */
    public function listarClientes(Request $request): JsonResponse
    {
        // Permitir tanto requisições GET quanto POST para facilitar testes
        if (!in_array($request->method(), ['GET', 'POST'])) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Método não permitido. Esta rota só aceita requisições GET ou POST.',
                'codigo' => 405
            ], 405);
        }

        // Simulação de lista de clientes
        $clientes = [
            [
                'id' => 1001,
                'nome' => 'Cliente Exemplo 1',
                'telefone' => '11999999999',
                'email' => 'cliente1@exemplo.com',
                'data_cadastro' => now()->subDays(30)->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 1002,
                'nome' => 'Cliente Exemplo 2',
                'telefone' => '21988888888',
                'email' => 'cliente2@exemplo.com',
                'data_cadastro' => now()->subDays(15)->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 1003,
                'nome' => 'Cliente Exemplo 3',
                'telefone' => '31977777777',
                'email' => 'cliente3@exemplo.com',
                'data_cadastro' => now()->subDays(5)->format('Y-m-d H:i:s'),
            ],
        ];

        return response()->json([
            'status' => 'success',
            'total' => count($clientes),
            'clientes' => $clientes
        ]);
    }
}
