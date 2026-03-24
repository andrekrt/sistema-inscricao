<x-layouts.admin
    title="Editar categoria"
    pageTitle="Editar categoria"
    pageSubtitle="Atualize as informações da categoria">

    <form method="POST" action="{{ route('categorias.update', $categoria) }}">
        @csrf
        @method('PUT')
        @include('categorias._form', ['categoria' => $categoria])
    </form>
</x-layouts.admin>
