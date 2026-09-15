<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\NotificacaoModel;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer(
            'components.navbar',
            function ($view) {

                $quantidadeNotificacoes = 0;

                if (
                    auth()->check()
                    && !auth()->user()->is_admin
                ) {
                    $quantidadeNotificacoes =
                        NotificacaoModel::where(
                            'cliente_id',
                            auth()->user()->cliente_id
                        )
                        ->where(
                            'visualizada',
                            false
                        )
                        ->count();
                }

                $view->with(
                    'quantidadeNotificacoes',
                    $quantidadeNotificacoes
                );
            }
        );
    }
}