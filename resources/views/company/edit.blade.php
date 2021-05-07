<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit company: ' . $company->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <div class="space-y-6">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $company->name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        This information will be displayed publicly so be careful what you share.
                                    </p>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <form class="space-y-6" action="{{ route('company.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf

                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="name" class="block text-sm font-medium text-gray-700">
                                                    Name
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input value="{{ $company->name }}"
                                                           type="text"
                                                           name="name"
                                                           id="name"
                                                           required
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('name') border-red-300 @enderror"
                                                           placeholder="Name"
                                                    >
                                                    @error('name')
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
                                                    <input value="{{ $company->email }}"
                                                           type="email"
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
                                                    Website
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input value="{{ $company->website }}"
                                                           type="text"
                                                           name="website"
                                                           id="website"
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300 @error('website') border-red-300 @enderror"
                                                           placeholder="www.example.com"
                                                    >
                                                    @error('website')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Logo
                                            </label>
                                            <div class="mt-1 flex items-center space-x-5">
                                                @if($company->logo)
                                                    <img class="h-20 w-20 rounded-full" src="{{ url('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo">
                                                @else
                                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </span>
                                                @endif
                                                <label for="logo" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <span>Change</span>
                                                    <input id="logo"
                                                           name="logo"
                                                           type="file"
                                                           accept="image/*"
                                                           class="sr-only @error('logo') border-red-300 @enderror"
                                                    >
                                                    @error('logo')
                                                    <div class="text-base leading-5 text-red-300">{{ $message }}</div>
                                                    @enderror
                                                </label>
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
