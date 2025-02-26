<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluxo de Desenvolvimento</title>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 2rem;
            background-color: #f8f9fa;
        }
        .workflow-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .workflow {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            padding: 2rem 0;
        }
        .workflow::before {
            content: '';
            position: absolute;
            top: 50px;
            left: 50px;
            right: 50px;
            height: 4px;
            background: linear-gradient(90deg, #0056b3, #007bff);
            z-index: 1;
        }
        .stage {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 2;
            padding: 0 15px;
        }
        .stage-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }
        .stage-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0056b3;
            margin-bottom: 0.75rem;
        }
        .stage-description {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="workflow-container">
        <div class="workflow">
            <div class="stage">
                <div class="stage-icon">1</div>
                <div class="stage-title">Briefing</div>
                <div class="stage-description">Compreensão detalhada das necessidades do cliente e definição clara dos objetivos e metas do projeto</div>
            </div>
            <div class="stage">
                <div class="stage-icon">2</div>
                <div class="stage-title">Planejamento</div>
                <div class="stage-description">Desenvolvimento do wireframe, estruturação da navegação e elaboração do cronograma detalhado</div>
            </div>
            <div class="stage">
                <div class="stage-icon">3</div>
                <div class="stage-title">Execução</div>
                <div class="stage-description">Desenvolvimento dos códigos (PHP, HTML, CSS, JavaScript) e implementação das funcionalidades</div>
            </div>
            <div class="stage">
                <div class="stage-icon">4</div>
                <div class="stage-title">Testes</div>
                <div class="stage-description">Verificação completa de todos os módulos e funcionalidades desenvolvidas</div>
            </div>
            <div class="stage">
                <div class="stage-icon">5</div>
                <div class="stage-title">Entrega</div>
                <div class="stage-description">Implantação no servidor e disponibilização do sistema para uso</div>
            </div>
        </div>
    </div>
</body>
</html>