<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 w-full">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre del personaje
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Alias
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categoría
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Imagen
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($characters as $character)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $character->id }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $character->name }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $character->nickname }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $character->category }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                               @if($character->img && $character->img !== "")
                                                    <img src="{{ $character->img }}" alt="Imagen" width="80" height="80"/>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-guest-layout>
