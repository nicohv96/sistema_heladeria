@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Inicio
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inicio | Bienvenido</h1>
</div>

<div class="contentTable p-2 mb-3 overflow-auto">
    <div class="m-4">
        <!-- Contenedor de tarjetas -->
        <div class="row">
            <!-- Tarjeta de Clientes -->
            <div class="col-sm-12 col-md-6 my-3">
                <div class="card text-white bg-dark">
                    <div class="card-body d-flex gap-3">
                        <div class="icon-card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                            </svg>
                        </div>
                        <div class="data-card">
                            <h5 class="card-title">Clientes</h5>
                            <p class="card-text h1">{{ $customerCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Ventas -->
            <div class="col-sm-12 col-md-6 my-3">
                <div class="card text-white bg-dark">
                    <div class="card-body d-flex gap-3">
                        <div class="icon-card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
                              </svg>
                        </div>
                        <div class="data-card">
                            <h5 class="card-title">Ventas</h5>
                            <p class="card-text h1">{{ $saleCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Tarjeta de Categorías -->
            <div class="col-sm-12 col-md-6 my-3">
                <div class="card text-white bg-dark">
                    <div class="card-body d-flex gap-3">
                        <div class="icon-card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0"/>
                                <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z"/>
                            </svg>
                        </div>
                        <div class="data-card">
                            <h5 class="card-title">Categorías</h5>
                            <p class="card-text h1">{{ $categoryCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Productos -->
            <div class="col-sm-12 col-md-6 my-3">
                <div class="card text-white bg-dark">
                    <div class="card-body d-flex gap-3">
                        <div class="icon-card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                              </svg>
                        </div>
                        <div class="data-card">
                            <h5 class="card-title">Productos</h5>
                            <p class="card-text h1">{{ $productCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>

@endsection
