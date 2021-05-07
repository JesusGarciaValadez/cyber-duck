<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight xs:w-full w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
            {{ __('Companies') }}
        </h2>
        <p class="max-w-7xl mx-auto py-0 w-full">
            <a href="{{ route('company.create') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 float-right">
                Create
            </a>
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Company
                                                </th>
                                                <th scope="col" class="px-6 py-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Website
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($companies as $company)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <a href="{{ route('company.show', $company->id) }}" class="underline text-blue-600 hover:text-blue-900" target="_self">
                                                                <img class="h-10 w-10 rounded-full" src="{{ url('storage/' . $company->logo) }}" alt="{{ $company->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <a href="{{ route('company.show', $company->id) }}" target="_self">{{ $company->name }}</a>
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                <a href="{{ route('company.show', $company->id) }}" target="_self">{{ $company->email }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <a href="{{ $company->website }}" class="underline text-blue-600 hover:text-blue-900" target="_blank">{{ $company->website }}</a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('company.edit', $company->id) }}" class="text-indigo-600 hover:text-indigo-900 float-left">Edit</a>
                                                    <a href="{{ route('company.destroy', $company->id) }}" class="text-red-600 hover:text-red-900 float-right">Destroy</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $companies->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
