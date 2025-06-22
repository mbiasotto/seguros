<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoriaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um admin e fazer login
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        $this->actingAs($admin);
    }

    public function test_admin_pode_visualizar_lista_de_categorias()
    {
        $response = $this->get('/admin/categorias');

        $response->assertStatus(200);
        $response->assertViewIs('admin.categorias.index');
    }

    public function test_admin_pode_visualizar_formulario_de_criacao_de_categoria()
    {
        $response = $this->get('/admin/categorias/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.categorias.create');
    }

    public function test_admin_pode_criar_categoria_com_dados_validos()
    {
        $dadosCategoria = [
            'nome' => 'Padaria',
            'descricao' => 'Padarias e confeitarias',
            'ativo' => true
        ];

        $response = $this->post('/admin/categorias', $dadosCategoria);

        $response->assertRedirect('/admin/categorias');

        $this->assertDatabaseHas('categorias', [
            'nome' => 'Padaria',
            'descricao' => 'Padarias e confeitarias',
            'ativo' => true
        ]);
    }

    public function test_categoria_criada_fica_ativa_por_padrao()
    {
        $dadosCategoria = [
            'nome' => 'Açougue',
            'descricao' => 'Açougues e casas de carnes'
        ];

        $this->post('/admin/categorias', $dadosCategoria);

        $this->assertDatabaseHas('categorias', [
            'nome' => 'Açougue',
            'ativo' => true
        ]);
    }

    public function test_nome_da_categoria_eh_obrigatorio()
    {
        $dadosCategoria = [
            'descricao' => 'Descrição sem nome'
        ];

        $response = $this->post('/admin/categorias', $dadosCategoria);

        $response->assertSessionHasErrors(['nome']);
        $this->assertDatabaseCount('categorias', 6); // Apenas as 6 do seeder
    }

    public function test_nome_da_categoria_deve_ser_unico()
    {
        $nomeUnico = 'Categoria Teste Unica';
        Categoria::factory()->create(['nome' => $nomeUnico]);

        $dadosCategoria = [
            'nome' => $nomeUnico,
            'descricao' => 'Tentando duplicar nome'
        ];

        $response = $this->post('/admin/categorias', $dadosCategoria);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_admin_pode_editar_categoria()
    {
        $categoria = Categoria::factory()->create([
            'nome' => 'Categoria Original',
            'descricao' => 'Descrição original'
        ]);

        $dadosAtualizados = [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição atualizada',
            'ativo' => false
        ];

        $response = $this->put("/admin/categorias/{$categoria->id}", $dadosAtualizados);

        $response->assertRedirect('/admin/categorias');

        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição atualizada',
            'ativo' => false
        ]);
    }

    public function test_admin_pode_visualizar_formulario_de_edicao()
    {
        $categoria = Categoria::factory()->create();

        $response = $this->get("/admin/categorias/{$categoria->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.categorias.edit');
        $response->assertViewHas('categoria', $categoria);
    }

    public function test_admin_pode_deletar_categoria_sem_estabelecimentos()
    {
        $categoria = Categoria::factory()->create(['nome' => 'Categoria Teste']);

        $response = $this->delete("/admin/categorias/{$categoria->id}");

        $response->assertRedirect('/admin/categorias');
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }

    public function test_admin_nao_pode_deletar_categoria_com_estabelecimentos()
    {
        $categoria = Categoria::first(); // Pega uma categoria do seeder

        // Criar um estabelecimento que usa esta categoria
        \App\Models\Estabelecimento::factory()->create([
            'categoria_id' => $categoria->id
        ]);

        $response = $this->delete("/admin/categorias/{$categoria->id}");

        $response->assertRedirect('/admin/categorias');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);
    }
}
