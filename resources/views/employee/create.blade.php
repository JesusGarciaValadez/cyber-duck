<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-6">
                        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">New Employee</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        This information will be displayed publicly so be careful what you share.
                                    </p>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <form class="space-y-6" action="{{ route('employee.store') }}" method="POST">
                                        @csrf

                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="first_name" class="block text-sm font-medium text-gray-700">
                                                    First Name
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text"
                                                           name="first_name"
                                                           id="first_name"
                                                           required
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('first_name') border-red-300 @enderror"
                                                           placeholder="First Name"
                                                    >
                                                    @error('first_name')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="last_name" class="block text-sm font-medium text-gray-700">
                                                    Last Name
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text"
                                                           name="last_name"
                                                           id="last_name"
                                                           required
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('last_name') border-red-300 @enderror"
                                                           placeholder="Last Name"
                                                    >
                                                    @error('last_name')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="email" class="block text-sm font-medium text-gray-700">
                                                    Email
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="email"
                                                           name="email"
                                                           id="email"
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('email') border-red-300 @enderror"
                                                           placeholder="Email"
                                                    >
                                                    @error('email')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="website" class="block text-sm font-medium text-gray-700">
                                                    Phone Number
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text"
                                                           name="phone"
                                                           id="phone"
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('phone') border-red-300 @enderror"
                                                           placeholder="+55 (5) 5555 5555"
                                                    >
                                                    @error('phone')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative inline-block text-left">
                                            <div role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                                <div class="py-1" role="none">
                                                    <select required
                                                            name="company_id"
                                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500 @error('company_id') border-red-300 @enderror"
                                                    >
                                                        <option value="" class="text-gray-700 block px-4 py-2 text-sm">Select a company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">{{ $company->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('company_id')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <a href="{{ url()->previous() }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cancel
                                            </a>
                                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
