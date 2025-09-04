# Implementação Laravel + RabbitMQ (Filas e Jobs)
Este projeto demonstra como utilizar RabbitMQ para processamento assíncrono de relatórios em um projeto Laravel, simulando o envio de relatórios em PDF por email através de filas e jobs.

## O que o projeto faz?
- Gera relatórios em PDF a partir de filtros enviados pelo usuário.
- Salva o PDF temporariamente no servidor.
- Envia o PDF por email de forma assíncrona utilizando RabbitMQ.
- Remove o arquivo após o envio.

## Fluxo da aplicação:
1 - Usuário solicita um relatório.
2 - O sistema gera o PDF e salva no storage.
3 - É criada uma Job que é enviada para a fila do RabbitMQ.
4 - O Worker consome a fila, processa a Job e envia o email.
5 - O PDF é apagado do servidor após o envio.

## Código de exemplo:
### Controller (geração do PDF + disparo da Job)
```
public function generatePdf(Request $request, DashboardService $dashboardService) {
    try {
        $user = Auth::user();
        $filters = $request->only(['name', 'product', 'total']);
        $sales = $dashboardService->getForPdf($filters);
        
        $pdf = Pdf::loadView('generate-pdf', compact('sales', 'filters'));
        
        $hash = Str::random(10);
        $pdfPath = storage_path("app/public/relatorio_{$hash}.pdf");
        $pdf->save($pdfPath);

        SendEmailReport::dispatch($pdfPath, $user);

        return redirect()->route('dashboard')->with('success', 'Relatorio enviado com sucesso');
    } catch (Exception $e) {
        return redirect()->route('dashboard')->with('error', 'Erro ao enviar relatorio: ' . $e->getMessage());
    }
}
```

### Job (envio do email + limpeza do arquivo)
```
public function handle(): void
{
    Mail::to($this->user->email)->send(new PdfMail($this->pdfPath, $this->user));
    if(file_exists($this->pdfPath)) {
        unlink($this->pdfPath); 
    }
}
```

## Instalar dependências
```
composer install
cp .env.example .env
php artisan key:generate
```

