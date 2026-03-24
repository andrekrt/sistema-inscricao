<x-layouts.admin
    title="Nova categoria"
    pageTitle="Nova categoria"
    pageSubtitle="Cadastre uma nova categoria do campeonato">

    <form method="POST" action="{{ route('categorias.store') }}">
        @csrf
        @include('categorias._form')
    </form>
</x-layouts.admin>
