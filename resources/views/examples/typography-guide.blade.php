@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/typography-guide.css') }}">

<div class="typography-guide">
    <h1 class="mb-4">Sistema de Tipografia</h1>
    <p class="mb-4">Este guia demonstra o sistema de tipografia utilizado em todo o Segura Essa, garantindo consistência visual e boa legibilidade.</p>

    <div class="typography-guide__section">
        <h2 class="typography-guide__section-title">Fontes</h2>

        <div class="typography-guide__font-demo">
            <h3 class="typography-guide__font-name">Inter (Texto)</h3>
            <div class="typography-guide__font-sample">
                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Regular (400)</div>
                    <div class="weight-regular">Este é um exemplo de texto usando Inter Regular</div>
                </div>

                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Medium (500)</div>
                    <div class="weight-medium">Este é um exemplo de texto usando Inter Medium</div>
                </div>

                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Semibold (600)</div>
                    <div class="weight-semibold">Este é um exemplo de texto usando Inter Semibold</div>
                </div>

                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Bold (700)</div>
                    <div class="weight-bold">Este é um exemplo de texto usando Inter Bold</div>
                </div>
            </div>
        </div>

        <div class="typography-guide__font-demo">
            <h3 class="typography-guide__font-name">Poppins (Cabeçalhos)</h3>
            <div class="typography-guide__font-sample">
                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Semibold (600)</div>
                    <div class="heading-semibold">Este é um exemplo de texto usando Poppins Semibold</div>
                </div>

                <div class="typography-guide__weight-sample">
                    <div class="typography-guide__weight-title">Bold (700)</div>
                    <div class="heading-bold">Este é um exemplo de texto usando Poppins Bold</div>
                </div>
            </div>
        </div>
    </div>

    <div class="typography-guide__section">
        <h2 class="typography-guide__section-title">Hierarquia de Cabeçalhos</h2>

        <div class="typography-guide__size-sample">
            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h1 (30px)</div>
                <h1 class="typography-guide__size-preview">Cabeçalho Principal</h1>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h2 (24px)</div>
                <h2 class="typography-guide__size-preview">Cabeçalho Secundário</h2>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h3 (20px)</div>
                <h3 class="typography-guide__size-preview">Cabeçalho Terciário</h3>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h4 (18px)</div>
                <h4 class="typography-guide__size-preview">Cabeçalho Quaternário</h4>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h5 (16px)</div>
                <h5 class="typography-guide__size-preview">Cabeçalho Quinário</h5>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">h6 (14px)</div>
                <h6 class="typography-guide__size-preview">CABEÇALHO SENÁRIO</h6>
            </div>
        </div>
    </div>

    <div class="typography-guide__section">
        <h2 class="typography-guide__section-title">Tamanhos de Texto</h2>

        <div class="typography-guide__size-sample">
            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">xs (12px)</div>
                <div class="typography-guide__size-preview text-xs">Texto extra pequeno usado para informações secundárias, notas de rodapé, etc.</div>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">sm (14px)</div>
                <div class="typography-guide__size-preview text-sm">Texto pequeno usado para legendas, descrições e texto de UI menor.</div>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">base (16px)</div>
                <div class="typography-guide__size-preview text-base">Texto base usado para a maioria do conteúdo textual em toda a aplicação.</div>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">lg (18px)</div>
                <div class="typography-guide__size-preview text-lg">Texto grande usado para destacar informações importantes.</div>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">xl (20px)</div>
                <div class="typography-guide__size-preview text-xl">Texto extra grande usado para subtítulos e informações de destaque.</div>
            </div>

            <div class="typography-guide__size-example">
                <div class="typography-guide__size-label">2xl (24px)</div>
                <div class="typography-guide__size-preview text-2xl">Texto duplo extra grande usado para títulos secundários.</div>
            </div>
        </div>
    </div>

    <div class="typography-guide__section">
        <h2 class="typography-guide__section-title">Exemplos de Uso</h2>

        <div class="typography-guide__usage-example">
            <div class="typography-guide__usage-title">Card de Informação</div>

            <div class="demo-card">
                <h3 class="demo-card__title">Título do Card</h3>
                <div class="demo-card__subtitle">Subtítulo ou informação complementar</div>
                <p class="demo-card__content">
                    Este é um exemplo de conteúdo de card usando o sistema de tipografia.
                    A fonte principal é Inter para o corpo do texto, enquanto os títulos utilizam Poppins.
                    Isso cria uma hierarquia visual clara e melhora a legibilidade.
                </p>
                <div class="demo-card__footer">
                    <a href="#" class="font-medium">Ver mais</a>
                </div>
            </div>
        </div>

        <div class="typography-guide__usage-example">
            <div class="typography-guide__usage-title">Texto em diferentes pesos</div>

            <p class="mb-3 font-light">Este texto usa o peso Light (300) para conteúdo menos enfatizado.</p>
            <p class="mb-3 font-normal">Este texto usa o peso Normal (400) para a maioria do conteúdo.</p>
            <p class="mb-3 font-medium">Este texto usa o peso Medium (500) para elementos de interface e destaque moderado.</p>
            <p class="mb-3 font-semibold">Este texto usa o peso Semibold (600) para títulos e elementos importantes.</p>
            <p class="font-bold">Este texto usa o peso Bold (700) para máxima ênfase e chamadas à ação.</p>
        </div>
    </div>
</div>
@endsection
