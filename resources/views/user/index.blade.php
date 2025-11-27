<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-circle-user"></i> {{ __('Utilisateurs') }}
        </h2>
    </x-slot>

   <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher un utilisateur...">
            <a href="{{ route('users.create') }}" class="ajax-modal table-wrapper-action">Créer un utilisateur</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Société</th>
                        <th>Crée le</th>
                        <th class="align-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->tenant?->name }}</td>
                            <td class="px-6 py-4">{{ carbon($user->created_at)->format('d/m/Y') }}</td>
                            <td class="align-right actions">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="confirm-delete"><i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
</x-app-layout>