# Sistema Multiplic.cc

Sistema de gestão de saldos múltiplos e faturamento com autenticação multi-guard.

## 🚀 Acesso ao Sistema

### 📱 **URLs Inteligentes de Acesso**

| **Tipo de Usuário** | **URL Simples** | **Comportamento** |
|---------------------|------------------|-------------------|
| **👤 Usuário** | `http://localhost:8000/usuario` | Redireciona automaticamente |
| **🏪 Estabelecimento** | `http://localhost:8000/estabelecimento` | Redireciona automaticamente |
| **🔧 Admin** | `http://localhost:8000/admin` | Dashboard admin |

**💡 Redirecionamento Inteligente:**
- ✅ **Se logado**: Vai direto para o dashboard
- ❌ **Se não logado**: Vai para a tela de login

---

## 🔐 **Sistema de Login Seguro**

### **Credenciais por Tipo de Usuário**

| **Tipo** | **Campo de Login** | **Formato** | **Exemplo** |
|----------|-------------------|-------------|-------------|
| **👤 Usuário** | **CPF** + Senha | 999.999.999-99 | 123.456.789-01 |
| **🏪 Estabelecimento** | **CNPJ** + Senha | 99.999.999/9999-99 | 12.345.678/0001-90 |
| **🔧 Admin** | **E-mail** + Senha | usuario@dominio.com | admin@admin.com |

### **⚡ Por que CPF/CNPJ e não e-mail?**

- ✅ **Documento único e imutável**
- ✅ **Validação governamental oficial**
- ✅ **Padrão bancário e financeiro**
- ✅ **Maior segurança jurídica**
- ✅ **Conformidade com regulamentações**

---

## 🎯 **Dados de Teste**

### **Contas Disponíveis para Teste**

| **Tipo** | **CPF/CNPJ/Email** | **Senha** | **Observações** |
|----------|-------------------|-----------|-----------------|
| **🔧 Admin** | admin@admin.com | 1234 | Acesso total ao sistema |
| **👤 João Silva** | 123.456.789-01 | 123456 | Usuário em período gratuito |
| **👤 Maria Santos** | 987.654.321-00 | 123456 | Usuário em período gratuito |
| **🏪 Loja Teste** | 12.345.678/0001-00 | 123456 | Estabelecimento ativo |

---

## 🛠️ **Comandos Úteis**

```bash
# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=8000

# Testar sistema de faturamento
php artisan test:faturamento status
php artisan test:faturamento processar

# Executar testes
php artisan test

# Reset completo do banco
php artisan migrate:fresh --seed
```

---

## 📊 **Funcionalidades Implementadas**

- ✅ **Sistema de múltiplos saldos** (principal, bônus, mensalidade)
- ✅ **Autenticação multi-guard** (Admin, Usuário, Estabelecimento)
- ✅ **Sistema de transações** 
- ✅ **Faturamento automático mensal**
- ✅ **Geração de arquivos CPFL**
- ✅ **Redirecionamento inteligente**
- ✅ **Validações de segurança**

---

## 🔄 **Fluxo de Faturamento**

1. **Processamento Mensal** (dia 1): Verifica período gratuito → Calcula mensalidade
2. **Fechamento** (dia 5): Consolida transações → Fecha faturamentos
3. **Arquivo CPFL**: Gera arquivo para envio → Marca como enviado

---

## 🏗️ **Arquitetura**

```
🎯 Frontend: Blade Templates
🔧 Backend: Laravel 11
🗄️ Banco: SQLite 
🧪 Testes: PHPUnit (TDD)
🔐 Auth: Multi-Guard
📊 Logs: Laravel Log
```

**Sistema desenvolvido seguindo princípios SOLID, Clean Code e TDD.**
